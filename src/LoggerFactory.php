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

    /** @var  LoggerInterface */
    private $requestLogger;

    public static function createFromConfig( array $config ) {
        $instance = new self();
        $nullHandler = new NullHandler();
        $handler = empty( $config['file'] ) ? $nullHandler : new StreamHandler( $config['file'], Logger::DEBUG );
        $ruleErrorLogger = new Logger( 'rule-errors');
        $responseLogger = new Logger( 'response' );
        $requestLogger = new Logger( 'request' );
        $instance->setRuleLogger( $ruleErrorLogger );
        $instance->setResponseLogger( $responseLogger );
        $instance->setRequestLogger( $requestLogger );
        $ruleHandler = empty( $config['rule_errors'] ) ? $nullHandler : $handler;
        $responseHandler = empty( $config['response'] ) ? $nullHandler : $handler;
        $requestHandler =  empty( $config['request'] ) ? $nullHandler : $handler;
        $ruleErrorLogger->setHandlers( [ $ruleHandler ] );
        $responseLogger->setHandlers( [$responseHandler] );
        $requestLogger->setHandlers( [$requestHandler] );
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

    /**
     * @return LoggerInterface
     */
    public function getRequestLogger()
    {
        return $this->requestLogger;
    }

    /**
     * @param LoggerInterface $requestLogger
     */
    public function setRequestLogger($requestLogger)
    {
        $this->requestLogger = $requestLogger;
    }

}