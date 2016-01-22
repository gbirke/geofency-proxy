<?php
/**
 * Created by PhpStorm.
 * User: gbirke
 * Date: 22.01.16
 * Time: 00:31
 */

namespace Birke\GeofencyProxy;


use GuzzleHttp\ClientInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class MappingEngine
{
    private $mappings;

    /**
     * MappingEngine constructor.
     * @param Mapping[] $mappings
     */
    public function __construct($mappings)
    {
        $this->mappings = $mappings;
    }

    public function processParameters( $params ) {
        foreach( $this->mappings as $map ) {
            $map->sendRequestIfParamMatches( $params );
        }
    }


    /**
     * @param array $config
     * @param ClientInterface $client
     * @param RequestFactory $requestFactory
     * @return MappingEngine
     */
    public static function createFromConfig( $config, $client, $requestFactory ) {
        $mappings = [];
        $lang = new ExpressionLanguage();
        foreach ( $config as $mapConfig ) {
            $check = new ParameterCheck( $lang );
            foreach( $mapConfig['rules'] as $rule ) {
                $check->addRule( $rule );
            }
            $mappings[] = new Mapping( $check, $client, $requestFactory->create( $mapConfig['request'] ) );
        }
        return new self( $mappings );
    }

}