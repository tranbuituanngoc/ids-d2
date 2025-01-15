<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Level;

class CustomDailyLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger('custom_daily');

        $date = date('Y-m-d');
        $logPath = storage_path("logs/{$date}_Laravel.log");

        $handler = new StreamHandler($logPath, Level::Debug);
        $handler->setFormatter(new LineFormatter(null, null, true, true));

        $logger->pushHandler($handler);

        return $logger;
    }
}
