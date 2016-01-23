<?php

use Birke\GeofencyProxy\RequestFactory;

class RequestFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    protected function setUp()
    {
        $this->requestFactory = new RequestFactory();
    }

    public function testRequestMethodIsSetFromConfig() {
        $request = $this->requestFactory->create( [ 'method' => 'PUT', 'url' => 'http://localhost/', 'body' => 'ON' ] );
        $this->assertSame( 'PUT', $request->getMethod() );
    }

    public function testGivenNoMethodInConfig_RequestMethodIsPOST() {
        $request = $this->requestFactory->create( [  'url' => 'http://localhost/', 'body' => 'ON' ] );
        $this->assertSame( 'POST', $request->getMethod() );
    }

    public function testURLIsSetFromConfig() {
        $request = $this->requestFactory->create( [ 'method' => 'PUT', 'url' => 'http://localhost/', 'body' => 'ON' ] );
        $this->assertSame( 'http://localhost/', (string) $request->getUri() );
    }

    public function testBodyIsSetFromConfig() {
        $request = $this->requestFactory->create( [ 'method' => 'PUT', 'url' => 'http://localhost/', 'body' => 'ON' ] );
        $this->assertSame( 'ON', $request->getBody()->getContents() );
    }

    public function testDefaultContentTypeIsTextPlain() {
        $request = $this->requestFactory->create( [ 'method' => 'PUT', 'url' => 'http://localhost/', 'body' => 'ON' ] );
        $this->assertTrue( $request->hasHeader( 'Content-Type' ) );
        $this->assertSame( 'text/plain', $request->getHeader( 'Content-Type' )[0] );
    }
}
