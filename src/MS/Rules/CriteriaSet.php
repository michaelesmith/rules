<?php
/**
 * @author msmith
 * @created 3/30/13 9:20 PM
 */

namespace MS\Rules;


class CriteriaSet {
    protected $criteria = array();

    protected $mode = self::MATCHES_ALL;

    const MATCHES_ALL = 1;
    const MATCHES_ANY = 2;
    const MATCHES_UNLESS_ALL = 3;
    const MATCHES_UNLESS_ANY = 4;

    protected $modes = array(self::MATCHES_ALL, self::MATCHES_ANY, self::MATCHES_UNLESS_ALL, self::MATCHES_UNLESS_ANY);

    public function __construct(array $criteria = array(), $mode = self::MATCHES_ALL)
    {
        $this->criteria = $criteria;
        $this->setMode($mode);
    }

    public function add(CriteriaInterface $criteria)
    {
        $this->criteria[] = $criteria;

        return $this;
    }

    public function getCriteria()
    {
        return $this->criteria;
    }

    public function setMode($mode)
    {
        if(!in_array($mode, $this->modes)){
            throw new \InvalidArgumentException(sprintf('Invalid mode specified "%s"', $mode));
        }

        $this->mode = $mode;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function matches(RuleContextInterface $context)
    {
        switch($this->mode){
            case self::MATCHES_ALL:
                return $this->doMatches(true, $context);
            case self::MATCHES_ANY:
                return $this->doMatches(false, $context);
            case self::MATCHES_UNLESS_ALL:
                return !$this->doMatches(true, $context);
            case self::MATCHES_UNLESS_ANY:
                return !$this->doMatches(false, $context);
            default:
                throw new \InvalidArgumentException(sprintf('Invalid mode specified "%s"', $this->mode));
        }
    }

    private function doMatches($all, RuleContextInterface $context)
    {
        foreach($this->criteria as $criteria){
            /** @var $criteria CriteriaInterface */
            if(!$all == $criteria->matches($context)){

                return !$all;
            }
        }

        return $all;
    }

}
