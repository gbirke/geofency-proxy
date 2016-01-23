<?php

namespace Birke\GeofencyProxy;

use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    /** @var LoggerInterface  */
    private $ruleLogger;

    public static function createFromConfig( array $config ) {
        $instance = new self();
        $nullHandler = new NullHandler();
        $handler = new StreamHandler( $config['file'], Logger::DEBUG );
        $ruleErrors = new Logger( 'rule-errors');
        $instance->setRuleLogger( $ruleErrors );
        $ruleHandler = empty( $config['rule_errors'] ) ? $nullHandler : $handler;
        $ruleErrors->setHandlers( [ $ruleHandler ] );
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