<?php
/**
 * @author msmith
 * @created 3/30/13 9:21 PM
 */

namespace MS\Rules;

interface CriteriaInterface {

    public function matches(RuleContextInterface $context);

}
