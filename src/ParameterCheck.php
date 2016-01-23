<?php

namespace Birke\GeofencyProxy;

use Psr\Log\LoggerInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class ParameterCheck
{
    use DefaultLogger;

    private $rules;
    private $language;
    private $logger;

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
    public function parametersMatch( array $parameters ) {
        foreach( $this->rules as $rule ) {
            if( !$this->tryRuleEvaluation( $rule, $parameters ) ) {
                return false;
            }
        }
        return true;
    }

    public function addRule( $rule ) {
        $this->rules[] = $rule;
    }

    private function tryRuleEvaluation( $rule, array $parameters ) {
        try {
            return $this->language->evaluate( $rule, $parameters );
        }
        catch( SyntaxError $e ) {
            $this->getLogger()->info( $e->getMessage(), [ 'parameters' => $parameters ] );
            return false;
        }
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }


}