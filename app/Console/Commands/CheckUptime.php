<?php

namespace App\Console\Commands;

use App\Models\UptimeCheck;
use App\Models\UptimeCheckResult;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class CheckUptime extends Command
{
    protected $signature = 'uptime:check';

    protected $description = 'Run every enabled uptime/API check and record the result';

    public function handle(): int
    {
        $checks = UptimeCheck::where('enabled', true)->get();
        $checked = 0;

        foreach ($checks as $check) {
            $this->runCheck($check);
            $checked++;
        }

        $this->info("Checked {$checked} uptime check(s).");

        return self::SUCCESS;
    }

    private function runCheck(UptimeCheck $check): void
    {
        $started = microtime(true);
        $statusCode = null;
        $success = false;
        $error = null;
        $sslExpiresAt = null;

        try {
            $request = Http::withHeaders($check->headers ?? [])->timeout(10);
            $response = match (strtoupper($check->method)) {
                'POST' => $request->post($check->url, $this->decodeBody($check->body)),
                'PUT' => $request->put($check->url, $this->decodeBody($check->body)),
                'PATCH' => $request->patch($check->url, $this->decodeBody($check->body)),
                'DELETE' => $request->delete($check->url),
                default => $request->get($check->url),
            };

            $statusCode = $response->status();
            $success = $statusCode === (int) $check->expected_status;
            if ($success && $check->expected_body_contains) {
                $success = str_contains($response->body(), $check->expected_body_contains);
            }
            if (! $success) {
                $error = "Expected status {$check->expected_status}".($check->expected_body_contains ? ' with matching body' : '').", got {$statusCode}.";
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }

        if (str_starts_with($check->url, 'https://')) {
            $sslExpiresAt = $this->sslExpiry($check->url);
        }

        $responseTimeMs = (int) round((microtime(true) - $started) * 1000);

        UptimeCheckResult::create([
            'uptime_check_id' => $check->id,
            'status_code' => $statusCode,
            'response_time_ms' => $responseTimeMs,
            'success' => $success,
            'ssl_expires_at' => $sslExpiresAt,
            'error' => $error,
            'checked_at' => now(),
        ]);

        $check->update([
            'last_success' => $success,
            'last_response_time_ms' => $responseTimeMs,
            'last_checked_at' => now(),
            'ssl_expires_at' => $sslExpiresAt,
        ]);
    }

    private function decodeBody(?string $body): array
    {
        if (! $body) {
            return [];
        }
        $decoded = json_decode($body, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function sslExpiry(string $url): ?Carbon
    {
        $host = parse_url($url, PHP_URL_HOST);
        if (! $host) {
            return null;
        }
        $port = parse_url($url, PHP_URL_PORT) ?? 443;

        $context = stream_context_create(['ssl' => ['capture_peer_cert' => true, 'verify_peer' => false, 'verify_peer_name' => false]]);
        $client = @stream_socket_client("ssl://{$host}:{$port}", $errno, $errstr, 5, STREAM_CLIENT_CONNECT, $context);
        if (! $client) {
            return null;
        }

        $params = stream_context_get_params($client);
        fclose($client);
        $cert = $params['options']['ssl']['peer_certificate'] ?? null;
        if (! $cert) {
            return null;
        }

        $certData = openssl_x509_parse($cert);
        if (empty($certData['validTo_time_t'])) {
            return null;
        }

        return Carbon::createFromTimestamp($certData['validTo_time_t']);
    }
}
