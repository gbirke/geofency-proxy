<?php

namespace Birke\GeofencyProxy;

use GuzzleHttp\Psr7\Request;

class RequestFactory
{
    public function create( $requestConfig ) {
        $method = empty( $requestConfig['method'] ) ? 'POST' :$requestConfig['method'];
        $body = $requestConfig['body'];
        $url = $requestConfig['url'];
        $headers = [];
        // Only until we allow more complex types like form parameters or JSON
        $headers[ 'Content-Type' ] = 'text/plain';
        return new Request( $method, $url, $headers, $body );
    }
}