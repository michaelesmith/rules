<?php

namespace MS\Rules;

/**
 * @author msmith
 */
class RuleSet
{
    protected $rules = array();

    public function add(Rule $rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function process(RuleContextInterface $context)
    {
        foreach($this->rules as $rule){
            /** @var $rule Rule */
            if(!$rule->process($context)){

                return;
            }
        }
    }

}
