<?php

namespace Birke\GeofencyProxy;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    /** @var LoggerInterface  */
    private $ruleLogger;

    public static function createFromConfig( array $config ) {
        $instance = new self();
        $handler = new StreamHandler( $config['file'], Logger::DEBUG );
        $ruleErrors = new Logger( 'rule-errors');
        $instance->setRuleLogger( $ruleErrors );
        if ( !empty($config['rule_errors']) ) {
            $ruleErrors->setHandlers( [$handler] );
        }
        return $instance;
    }

    /**
     * @return LoggerInterface
     */
    public function getRuleLogger()
    {
        return $this->ruleLogger;
    }

    /**
     * @param LoggerInterface $ruleLogger
     */
    public function setRuleLogger($ruleLogger)
    {
        $this->ruleLogger = $ruleLogger;
    }



}