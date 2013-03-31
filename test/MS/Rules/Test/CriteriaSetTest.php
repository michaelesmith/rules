<?php

namespace MS\Rules\Test;

use MS\Rules\CriteriaSet;

/**
 * @author msmith
 */
class CriteriaSetTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetModeException()
    {
        $cs = new CriteriaSet();
        $cs->setMode(1017);
    }

    public function testMatchesAll()
    {
        $context = $this->getMock('MS\Rules\RuleContextInterface');

        //default to mode MATCHES_ALL
        $cs = $this->getCriteriaSet(array(true, true, true));
        $this->assertTrue($cs->matches($context));

        $cs = $this->getCriteriaSet(array(true, true, true));
        $cs->setMode(CriteriaSet::MATCHES_ALL);
        $this->assertTrue($cs->matches($context));

        $cs = $this->getCriteriaSet(array(true, false, array(true, 0)));
        $cs->setMode(CriteriaSet::MATCHES_ALL);
        $this->assertFalse($cs->matches($context));
    }

    public function testMatchesAny()
    {
        $context = $this->getMock('MS\Rules\RuleContextInterface');

        $cs = $this->getCriteriaSet(array(true, array(true, 0), array(true, 0)));
        $cs->setMode(CriteriaSet::MATCHES_ANY);
        $this->assertTrue($cs->matches($context));

        $cs = $this->getCriteriaSet(array(false, true, array(true, 0)));
        $cs->setMode(CriteriaSet::MATCHES_ANY);
        $this->assertTrue($cs->matches($context));

        $cs = $this->getCriteriaSet(array(false, false, false));
        $cs->setMode(CriteriaSet::MATCHES_ANY);
        $this->assertFalse($cs->matches($context));
    }

    public function testMatchesUnlessAll()
    {
        $context = $this->getMock('MS\Rules\RuleContextInterface');

        $cs = $this->getCriteriaSet(array(true, true, true));
        $cs->setMode(CriteriaSet::MATCHES_UNLESS_ALL);
        $this->assertFalse($cs->matches($context));

        $cs = $this->getCriteriaSet(array(false, array(true, 0), array(true, 0)));
        $cs->setMode(CriteriaSet::MATCHES_UNLESS_ALL);
        $this->assertTrue($cs->matches($context));

        $cs = $this->getCriteriaSet(array(false, array(false, 0), array(false, 0)));
        $cs->setMode(CriteriaSet::MATCHES_UNLESS_ALL);
        $this->assertTrue($cs->matches($context));
    }

    public function testMatchesUnlessAny()
    {
        $context = $this->getMock('MS\Rules\RuleContextInterface');

        $cs = $this->getCriteriaSet(array(true, array(true, 0), array(true, 0)));
        $cs->setMode(CriteriaSet::MATCHES_UNLESS_ANY);
        $this->assertFalse($cs->matches($context));

        $cs = $this->getCriteriaSet(array(false, true, array(true, 0)));
        $cs->setMode(CriteriaSet::MATCHES_UNLESS_ANY);
        $this->assertFalse($cs->matches($context));

        $cs = $this->getCriteriaSet(array(false, false, false));
        $cs->setMode(CriteriaSet::MATCHES_UNLESS_ANY);
        $this->assertTrue($cs->matches($context));
    }

    private function getCriteriaSet($values)
    {
        $cs = new CriteriaSet();
        foreach($values as $value){
            if(is_array($value)){
                $return = $value[0];
                $count = $value[1];
            }else{
                $return = $value;
                $count = 1;
            }
            $c = $this->getMock('\MS\Rules\CriteriaInterface', array('matches'));
            $c->expects($this->exactly($count))
                ->method('matches')
                ->will($this->returnValue($return))
            ;

            $cs->add($c);
        }

        return $cs;
    }

}
