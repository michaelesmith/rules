<?php
/**
 * @author msmith
 * @created 3/30/13 10:17 PM
 */

namespace MS\Rules;


abstract class Criteria implements CriteriaInterface {

    protected $negate = false;

    public function setNegate($negate)
    {
        $this->negate = $negate;
    }

    public function getNegate()
    {
        return $this->negate;
    }

    public function matches(RuleContextInterface $context)
    {
        return $this->negate ? !$this->doMatches($context) : $this->doMatches($context);
    }

    abstract protected function doMatches(RuleContextInterface $context);

}
