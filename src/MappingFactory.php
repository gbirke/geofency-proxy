<?php

namespace Birke\GeofencyProxy;

use Psr\Log\LoggerInterface;
use GuzzleHttp\ClientInterface;

class MappingFactory
{
    /** @var  ParameterCheckFactory */
    private $parameterCheckFactory;


    /** @var  RequestFactory */
    private $requestFactory;

    /** @var  ClientInterface */
    private $client;

    /** @var LoggerInterface  */
    private $logger;

    /**
     * MappingFactory constructor.
     * @param ParameterCheckFactory $parameterCheckFactory
     * @param RequestFactory $requestFactory
     * @param ClientInterface $client
     * @param LoggerInterface $logger
     */
    public function __construct(ParameterCheckFactory $parameterCheckFactory, RequestFactory $requestFactory, ClientInterface $client, LoggerInterface $logger=null )
    {
        $this->parameterCheckFactory = $parameterCheckFactory;
        $this->requestFactory = $requestFactory;
        $this->client = $client;
        $this->logger = $logger;
    }

    public function create( array $config ) {
        $check = $this->parameterCheckFactory->createWithRules( $config['rules'] );
        $mapping = new Mapping( $check, $this->client, $this->requestFactory->create( $config['request'] ) );
        if ( $this->logger ) {
            $mapping->setLogger( $this->logger );
        }
        return $mapping;
    }

    public static function createMappingEngineFromConfig( array $config, ParameterCheckFactory $parameterCheckFactory,  RequestFactory $requestFactory,
                ClientInterface $client,  LoggerInterface $logger=null  ) {
        $instance = new self( $parameterCheckFactory, $requestFactory, $client, $logger );
        $mappings = [];
        foreach ( $config as $mapConfig ) {
            $mappings[] = $instance->create( $mapConfig );
        }
        return new MappingEngine( $mappings );
    }

}