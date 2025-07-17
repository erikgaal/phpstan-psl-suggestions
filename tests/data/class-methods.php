<?php

class TestClass {
    public function testMethod() {
        // Method calls should not trigger suggestions
        return $this->strlen('test');
    }

    private function strlen($str) {
        return \strlen($str);
    }
}
