<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Server::latest()->get());
    }

    /**
     * Store a newly created resource in storage. Issues a one-time agent
     * token — this is the only response that will ever contain it.
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $server = Server::create($validated);
        $token = $server->createToken('agent', ['agent:heartbeat'])->plainTextToken;

        AuditLogger::log('server.created', 'Server', $server->id, [], $server->toArray());

        return response()->json(['server' => $server, 'token' => $token], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Server $server)
    {
        return response()->json($server);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Server $server)
    {
        $validated = $this->validated($request, $server);
        $before = $server->toArray();

        $server->update($validated);

        AuditLogger::log('server.updated', 'Server', $server->id, $before, $server->fresh()->toArray());

        return response()->json($server->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server)
    {
        $server->tokens()->delete();
        $before = $server->toArray();
        $server->delete();

        AuditLogger::log('server.deleted', 'Server', $before['id'], $before, []);

        return response()->json(null, 204);
    }

    /**
     * Revoke the server's current agent token(s) and issue a new one.
     */
    public function rotateToken(Server $server)
    {
        $server->tokens()->delete();
        $token = $server->createToken('agent', ['agent:heartbeat'])->plainTextToken;

        AuditLogger::log('server.token_rotated', 'Server', $server->id);

        return response()->json(['token' => $token]);
    }

    private function validated(Request $request, ?Server $server = null): array
    {
        return $request->validate([
            'name' => $server ? 'sometimes|string|max:255' : 'required|string|max:255',
            'hostname' => 'nullable|string|max:255',
            'ip_address' => 'nullable|string|max:100',
            'public_ip' => 'nullable|string|max:100',
            'private_ip' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'os_version' => 'nullable|string|max:100',
            'kernel_version' => 'nullable|string|max:100',
            'architecture' => 'nullable|string|max:50',
            'cpu_cores' => 'nullable|integer|min:1',
            'ram_mb' => 'nullable|integer|min:1',
            'storage_gb' => 'nullable|integer|min:1',
            'environment' => 'nullable|string|in:production,staging,development',
            'role' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
        ]);
    }
}
