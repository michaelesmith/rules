<?php

namespace MS\Rules\Test;

use MS\Rules\RuleSet;

/**
 * @author msmith
 */
class RuleSetTest extends TestCase
{
    public function testProcess()
    {
        $context = $this->getMock('MS\Rules\RuleContextInterface');

        $rs = $this->getRuleSet(array(true, true, false, array(true, 0)));

        $rs->process($context);
    }

    private function getRuleSet($values)
    {
        $rs = new RuleSet();

        foreach($values as $value){
            if(is_array($value)){
                $return = $value[0];
                $count = $value[1];
            }else{
                $return = $value;
                $count = 1;
            }
            $r = $this->getMock('\MS\Rules\Rule', array('process'));
            $r->expects($this->exactly($count))
                ->method('process')
                ->will($this->returnValue($return))
            ;
            $rs->add($r);
        }

        return $rs;
    }

}
