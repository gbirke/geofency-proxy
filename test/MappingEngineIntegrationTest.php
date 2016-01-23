<?php


use Birke\GeofencyProxy\MappingEngine;
use Birke\GeofencyProxy\RequestFactory;
use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

class MappingEngineIntegrationTest extends PHPUnit_Framework_TestCase
{
    public function testMappingEngineCanBeCreatedFromConfig() {
        $config = Yaml::parse( file_get_contents( __DIR__ . '/../config.dist.yml' ) );
        $client = $this->getMock( ClientInterface::class );
        $requests = [];
        $client->expects( $this->once() )->method( 'send' )->will( $this->returnCallback( function( Request $r ) use ( &$requests ) {
            $requests[] = $r;

        } ) );
        $requestFactory = new RequestFactory();
        $mappingEngine = MappingEngine::createFromConfig( $config['mappings'], $client, $requestFactory );
        $processed = $mappingEngine->processParameters( [ 'entry' => '0', 'name' => 'Home' ] );
        $this->assertSame( 1, $processed );

        $this->assertSame( 'POST', $requests[0]->getMethod() );
        $this->assertSame( 'http://localhost:8080/rest/items/Presence', (string) $requests[0]->getUri() );
        $this->assertSame( 'text/plain', $requests[0]->getHeader( 'Content-Type' )[0] );
        $this->assertSame( 'OFF', $requests[0]->getBody()->getContents() );
    }
}
