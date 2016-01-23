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

    /** @var LoggerInterface  */
    private $responseLogger;

    public static function createFromConfig( array $config ) {
        $instance = new self();
        $nullHandler = new NullHandler();
        $handler = new StreamHandler( $config['file'], Logger::DEBUG );
        $ruleErrors = new Logger( 'rule-errors');
        $response = new Logger( 'response' );
        $instance->setRuleLogger( $ruleErrors );
        $instance->setResponseLogger( $response );
        $ruleHandler = empty( $config['rule_errors'] ) ? $nullHandler : $handler;
        $responseHandler = empty( $config['response'] ) ? $nullHandler : $handler;
        $ruleErrors->setHandlers( [ $ruleHandler ] );
        $response->setHandlers( [$responseHandler] );
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

    /**
     * @return LoggerInterface
     */
    public function getResponseLogger()
    {
        return $this->responseLogger;
    }

    /**
     * @param LoggerInterface $responseLogger
     */
    public function setResponseLogger($responseLogger)
    {
        $this->responseLogger = $responseLogger;
    }



}