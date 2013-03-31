<?php

namespace MS\Rules\Test;

use MS\Rules\ActionsSet;

/**
 * @author msmith
 */
class ActionSetTest extends TestCase
{
    public function testNegate()
    {
        $as = new ActionsSet();

        for($i=0; $i<3; $i++){
            $a = $this->getMock('\MS\Rules\ActionInterface', array('execute'));
            $a->expects($this->once())
                ->method('execute')
            ;

            $as->add($a);
        }

        $context = $this->getMock('MS\Rules\RuleContextInterface');

        $as->execute($context);
    }

}
