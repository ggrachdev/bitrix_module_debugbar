<?php

use PHPUnit\Framework\TestCase;

class NoticeRawTest extends TestCase {

    public function testNotice() {
        // @todo
        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack) - 1]);
        $this->assertSame(1, count($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }

    public function testErrors() {
        
    }

    public function testSuccess() {
        
    }

    public function testWarning() {
        
    }

}
