<?php

namespace Ctrl\Log;

use \Zend\Log\Logger as ZendLogger;

class Logger extends \Zend\Log\Logger
{
    public function logException(\Exception $exception, $priority = ZendLogger::ERR)
    {
        $this->log($priority, $exception->getMessage().PHP_EOL.$exception->getTraceAsString().PHP_EOL);
    }
}
