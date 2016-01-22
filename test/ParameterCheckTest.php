<?php

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ParameterCheckTest extends PHPUnit_Framework_TestCase
{
    public function testGivenMultipleRules_parameterCheckAppliesAll() {
        $lang = new ExpressionLanguage();
        $check = new \Birke\GeofencyProxy\ParameterCheck( [
            'a == 1',
            'b < 3'
        ], $lang );
        $this->assertTrue( $check->parametersMatch( [ 'a' => 1, 'b' => 2 ] ) );
    }
}
