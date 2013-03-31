<?php
/**
 * @author msmith
 * @created 3/30/13 9:23 PM
 */

namespace MS\Rules;


interface ActionInterface {
    public function execute(RuleContextInterface $context);
}
