<?php

namespace Birke\GeofencyProxy;

use GuzzleHttp\ClientInterface;

class MappingEngine
{
    private $mappings;

    /**
     * @param Mapping[] $mappings
     */
    public function __construct($mappings)
    {
        $this->mappings = $mappings;
    }

    public function processParameters( $params ) {
        $numMappingsProcessed = 0;
        foreach( $this->mappings as $map ) {
            $numMappingsProcessed += $map->sendRequestIfParamMatches( $params ) ? 1 : 0;
        }
        return $numMappingsProcessed;
    }


    /**
     * @param array $config
     * @param ClientInterface $client
     * @param ParameterCheckFactory $parameterCheckFactory
     * @param RequestFactory $requestFactory
     * @return MappingEngine
     */
    public static function createFromConfig( array $config, ClientInterface $client, ParameterCheckFactory $parameterCheckFactory,
                                             RequestFactory $requestFactory ) {
        $mappings = [];
        foreach ( $config as $mapConfig ) {
            $check = $parameterCheckFactory->createWithRules( $mapConfig['rules'] );
            $mappings[] = new Mapping( $check, $client, $requestFactory->create( $mapConfig['request'] ) );
        }
        return new self( $mappings );
    }

}