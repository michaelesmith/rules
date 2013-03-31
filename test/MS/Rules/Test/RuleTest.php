<?php

namespace MS\Rules\Test;

use MS\Rules\Rule;

/**
 * @author msmith
 */
class RuleTest extends TestCase
{
    public function testProcess()
    {
        $context = $this->getMock('MS\Rules\RuleContextInterface');

        $r = $this->getRule(true);
        $this->assertTrue($r->process($context));

        $r = $this->getRule(false);
        $this->assertTrue($r->process($context), 'returns true means keep processing rules');

        $r = $this->getRule(true);
        $r->setPropagate(false);
        $this->assertFalse($r->process($context), 'returns false means stop processing rules');

        $r = $this->getRule(false);
        $r->setPropagate(false);
        $this->assertTrue($r->process($context));
    }

    private function getRule($value)
    {
        $r = new Rule();

        $c = $this->getMock('\MS\Rules\CriteriaInterface', array('matches'));
        $c->expects($this->once())
            ->method('matches')
            ->will($this->returnValue($value))
        ;
        $r->getCriteriaSet()->add($c);

        $a = $this->getMock('\MS\Rules\ActionInterface', array('execute'));
        $a->expects($this->exactly($value ? 1 : 0))
            ->method('execute')
        ;
        $r->getActionsSet()->add($a);

        return $r;
    }

}
