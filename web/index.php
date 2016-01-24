<?php

use Birke\GeofencyProxy\LoggerFactory;
use Birke\GeofencyProxy\MappingFactory;
use Birke\GeofencyProxy\ParameterCheckFactory;
use Birke\GeofencyProxy\ParameterCheckException;
use Birke\GeofencyProxy\RequestFactory;
use GuzzleHttp\Client;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

if ( empty( $_POST ) ) {
    header( 'HTTP/1.0 405 Method Not Allowed' );
    header( 'Content-Type: text/plain' );
    die( "Only POST requests accepted" );
}


$configName = __DIR__ . '/../config.yml';
if ( !file_exists( $configName ) ) {
    echo "Config file $configName not found.\n";
    exit( 1 );
}
$config = Yaml::parse( file_get_contents( $configName ) );

$client = new Client();

$logging = LoggerFactory::createFromConfig( $config['logging'] );
$parameterCheckFactory = new ParameterCheckFactory( $logging->getRuleLogger() );

$mappingEngine = MappingFactory::createMappingEngineFromConfig(
    $config['mappings'],
    $parameterCheckFactory,
    new RequestFactory(),
    $client,
    $logging->getResponseLogger()
);

header( 'Content-Type: text/plain' );
try {
    $processedParams = $mappingEngine->processParameters( $_POST );
    printf( "%d rule(s) matched\n", $processedParams );
}
catch ( ParameterCheckException $e ) {
    echo "Error while matching rules.\n";
}

