<?php

require_once __DIR__ . '/../vendor/autoload.php';

$configName = __DIR__ . '/../config.yml';
if ( !file_exists( $configName ) ) {
    echo "Config file $configName not found.\n";
    exit( 1 );
}
$config = \Symfony\Component\Yaml\Yaml::parse( file_get_contents( $configName ) );
print_r($config);

// TODO: Create guzzle client
// TODO: create mappingEngine from config
// TODO: send POST to mappingEngine