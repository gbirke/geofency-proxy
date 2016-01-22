<?php

namespace Birke\GeofencyProxy;


use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ParameterCheck
{
    private $rules;
    private $language;

    /**
     * ParameterCheck constructor.
     * @param ExpressionLanguage $language
     * @param array $rules
     */
    public function __construct( $language, $rules = [] )
    {
        $this->rules = $rules;
        $this->language = $language;
    }

    /**
     * Check if all rules match
     * @param array $parameters
     * @return bool
     */
    public function parametersMatch( $parameters ) {
        foreach( $this->rules as $rule ) {
            if( !$this->language->evaluate( $rule, $parameters ) ) {
                return false;
            }
        }
        return true;
    }

    public function addRule( $rule ) {
        $this->rules[] = $rule;
    }

}