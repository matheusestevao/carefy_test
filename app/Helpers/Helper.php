<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class Helper
{
    public static function log_message(
        \Throwable $exception,
        ?string $channel = 'single',
        ?string $level = 'error'
    ): void
    {
        Log::channel($channel)->$level($exception->getFile() . ' - ' . $exception->getLine() . ' - ' . print_r($exception->getMessage(), 1));
    }
}