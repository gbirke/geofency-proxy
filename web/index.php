<?php

use Birke\GeofencyProxy\MappingEngine;
use Birke\GeofencyProxy\RequestFactory;
use GuzzleHttp\Client;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

$configName = __DIR__ . '/../config.yml';
if ( !file_exists( $configName ) ) {
    echo "Config file $configName not found.\n";
    exit( 1 );
}
$config = Yaml::parse( file_get_contents( $configName ) );

$client = new Client();

$mappingEngine = MappingEngine::createFromConfig( $config['mappings'], $client, new RequestFactory() );

header( 'Content-Type: text/plain' );
printf( "%d rule(s) matched\n", $mappingEngine->processParameters( $_POST ) );