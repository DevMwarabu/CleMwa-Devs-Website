<?php

namespace App\Support;

class LogLevelParser
{
    // Most severe first, so a message like "CRITICAL: connection error" is
    // classified CRITICAL, not the also-present substring ERROR.
    private const LEVELS = ['EMERGENCY', 'ALERT', 'CRITICAL', 'ERROR', 'WARNING', 'WARN', 'NOTICE', 'INFO', 'DEBUG'];

    public static function guess(string $message): string
    {
        foreach (self::LEVELS as $level) {
            if (stripos($message, $level) !== false) {
                return $level === 'WARN' ? 'WARNING' : $level;
            }
        }

        return 'INFO';
    }
}
