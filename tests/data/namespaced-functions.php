<?php

namespace MyApp;

// These should NOT trigger PSL suggestions because they're in a namespace
function strlen($str) {
    return \strlen($str);
}

function array_map($callback, $array) {
    return \array_map($callback, $array);
}

// Usage of namespaced functions - should not trigger suggestions
$length = \MyApp\strlen('hello');
$mapped = \MyApp\array_map('strtoupper', ['a', 'b']);

// Fully qualified function calls - should not trigger suggestions
$qualified_length = \MyApp\strlen('hello');
