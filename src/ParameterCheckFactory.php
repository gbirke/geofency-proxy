<?php
/**
 * Created by PhpStorm.
 * User: gbirke
 * Date: 23.01.16
 * Time: 21:49
 */

namespace Birke\GeofencyProxy;


use Psr\Log\LoggerInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ParameterCheckFactory
{
    private $logger;

    /**
     * ParameterCheckFactory constructor.
     * @param LoggerInterface $logger
     */
    public function __construct( LoggerInterface $logger=null )
    {
        $this->logger = $logger;
    }

    public function createWithRules( array $rules ) {
        $lang = new ExpressionLanguage();
        $check = new ParameterCheck( $lang );
        foreach( $rules as $rule ) {
            $check->addRule( $rule );
        }
        if ( $this->logger ) {
            $check->setLogger( $this->logger );
        }
        return $check;
    }
}