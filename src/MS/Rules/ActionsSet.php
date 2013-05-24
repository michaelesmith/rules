<?php
/**
 * @author msmith
 * @created 3/30/13 9:23 PM
 */

namespace MS\Rules;


class ActionsSet {
    protected $actions = array();

    public function __construct(array $actions = array())
    {
        $this->actions = $actions;
    }

    public function add(ActionInterface $action)
    {
        $this->actions[] = $action;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function execute(RuleContextInterface $context)
    {
        foreach($this->actions as $action){
            /** @var $action ActionInterface */
            $action->execute($context);
        }
    }
}
