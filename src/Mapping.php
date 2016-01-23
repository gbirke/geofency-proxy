<?php
/**
 * Created by PhpStorm.
 * User: gbirke
 * Date: 21.01.16
 * Time: 22:29
 */

namespace Birke\GeofencyProxy;

use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;

class Mapping
{
    use DefaultLogger;

    private $parameterCheck;
    private $client;
    private $request;
    private $lastResponse;

    private $logger;

    /**
     * Mapping constructor.
     * @param ParameterCheck $parameterCheck
     * @param ClientInterface $client
     * @param RequestInterface $request;
     */
    public function __construct( $parameterCheck, $client, $request )
    {
        $this->parameterCheck = $parameterCheck;
        $this->client = $client;
        $this->request = $request;
    }

    public function sendRequestIfParamMatches( $params ) {
        if ( $this->parameterCheck->parametersMatch( $params ) ) {
            $this->lastResponse = $this->client->send( $this->request );
            $content = [ 'headers' =>  $this->lastResponse->getHeaders() ];
            $this->getLogger()->info( $this->lastResponse->getBody()->getContents(), $content );
            return true;
        }
        return false;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }



}