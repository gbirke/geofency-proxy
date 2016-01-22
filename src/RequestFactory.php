<?php

namespace Birke\GeofencyProxy;

use GuzzleHttp\Psr7\Request;

class RequestFactory
{
    public function create( $requestConfig ) {
        $method = empty( $requestConfig['method'] ) ? 'POST' :$requestConfig['method'];
        $body = $requestConfig['body'];
        $url = $requestConfig['url'];
        return new Request( $method, $url, [], $body );
    }
}