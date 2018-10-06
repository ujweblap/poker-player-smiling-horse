<?php

namespace SmilingHorse;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerInterface {
    /** @var Logger */
    protected $monolog;

    public function __construct()
    {
        $this->monolog = new Logger('player');
        $this->monolog->pushHandler(new StreamHandler("php://stderr", Logger::DEBUG));
    }

    /**
     * @return Logger
     */
    public function getMonolog()
    {
        return $this->monolog;
    }
}