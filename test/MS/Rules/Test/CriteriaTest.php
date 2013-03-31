<?php

namespace MS\Rules\Test;

/**
 * @author msmith
 */
class CriteriaTest extends TestCase
{
    public function testNegate()
    {
        $c = $this->getMock('\MS\Rules\Criteria', array('doMatches'));
        $c->expects($this->exactly(2))
            ->method('doMatches')
            ->will($this->returnValue(true));

        $context = $this->getMock('MS\Rules\RuleContextInterface');

        $this->assertTrue($c->matches($context));

        $c->setNegate(true);

        $this->assertFalse($c->matches($context));
    }

}
