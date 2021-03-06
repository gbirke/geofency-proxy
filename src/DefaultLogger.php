<?php
/**
 * Created by PhpStorm.
 * User: gbirke
 * Date: 23.01.16
 * Time: 21:36
 */

namespace Birke\GeofencyProxy;

use Monolog\Logger;
use Monolog\Handler\NullHandler;
use Psr\Log\LoggerInterface;

trait DefaultLogger
{

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if ( is_null( $this->logger ) ) {
            $this->logger = new Logger( 'Null-Logger', [ new NullHandler() ] );
        }
        return $this->logger;
    }

}