<?php

$length = strlen('hello world'); // Should trigger PSL suggestion
$mapped = array_map('strtoupper', ['a', 'b', 'c']); // Should trigger PSL suggestion
$maximum = max(1, 2, 3, 4, 5); // Should trigger PSL suggestion

// Additional test cases
$substring = substr('hello', 1, 3); // Should trigger PSL suggestion
$position = strpos('hello world', 'world'); // Should trigger PSL suggestion
$replaced = str_replace('hello', 'hi', 'hello world'); // Should trigger PSL suggestion
$lowercase = strtolower('HELLO'); // Should trigger PSL suggestion
$trimmed = trim('  hello  '); // Should trigger PSL suggestion
$keys = array_keys(['a' => 1, 'b' => 2]); // Should trigger PSL suggestion
$count = count([1, 2, 3]); // Should trigger PSL suggestion
