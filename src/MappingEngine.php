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
}