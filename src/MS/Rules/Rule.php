<?php
/**
 * @author msmith
 * @created 3/30/13 9:18 PM
 */

namespace MS\Rules;


class Rule {
    protected $criteria;

    protected $actions;

    protected $propagate = true;

    function __construct()
    {
        $this->criteria = new CriteriaSet();
        $this->actions = new ActionsSet();
    }

    public function getActionsSet()
    {
        return $this->actions;
    }

    public function getCriteriaSet()
    {
        return $this->criteria;
    }

    public function setPropagate($propagate)
    {
        $this->propagate = $propagate;
    }

    public function getPropagate()
    {
        return $this->propagate;
    }

    public function process(RuleContextInterface $context)
    {
        if($matched = $this->getCriteriaSet()->matches($context)){
            $this->getActionsSet()->execute($context);
        }

        return $this->propagate || !$matched;
    }
}
