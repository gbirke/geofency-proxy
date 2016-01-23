<?php

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Birke\GeofencyProxy\ParameterCheckException;
use Psr\Log\LoggerInterface;

class ParameterCheckTest extends PHPUnit_Framework_TestCase
{
    public function testGivenMultipleRules_allAreApplied() {
        $lang = new ExpressionLanguage();
        $check = new \Birke\GeofencyProxy\ParameterCheck( $lang, [
            'a == 1',
            'b < 3'
        ] );
        $this->assertTrue( $check->parametersMatch( [ 'a' => 1, 'b' => 2 ] ) );
    }

    public function testGivenInvalidRules_anExceptionIsThrown() {
        $this->setExpectedException( ParameterCheckException::class );
        $lang = new ExpressionLanguage();
        $check = new \Birke\GeofencyProxy\ParameterCheck( $lang, [
            'a == 1',
            'b < 3'
        ] );
        $this->assertTrue( $check->parametersMatch( [ 'b' => 2 ] ) );
    }

    public function testGivenInvalidRules_theViolationIsLogged() {
        $this->setExpectedException( ParameterCheckException::class );
        $lang = new ExpressionLanguage();
        $check = new \Birke\GeofencyProxy\ParameterCheck( $lang, [
            'a == 1',
            'b < 3'
        ] );
        $logger = $this->getMock( LoggerInterface::class );
        $logger->expects( $this->once() )
            ->method( 'info' )->with( $this->stringContains( '"a"' ), $this->equalTo(
                ['parameters' => [ 'b' => 2 ] ]
            ) );
        $check->setLogger( $logger );
        $this->assertTrue( $check->parametersMatch( [ 'b' => 2 ] ) );
    }
}
