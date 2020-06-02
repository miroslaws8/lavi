<?php

namespace Lavi\Config;

use Lavi\Logger\ILogger;

class Config implements IConfig
{
    private $settings;
    private $logger;

    public function set(array $data): void
    {
        $this->config = $data;
    }

    public function getPathPrefix(string $prefix): string
    {
        return $this->settings['prefix'];
    }

    public function setPathPrefix(string $prefix): void
    {
        $this->settings['prefix'] = $prefix;
    }

    public function getLogger(): ILogger
    {
        return $this->logger;
    }

    public function setLogger(ILogger $logger): void
    {
        $this->logger = $logger;
    }
}