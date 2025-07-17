<?php

// These functions don't have PSL equivalents, so should not trigger suggestions
$result1 = some_custom_function('test');
$result2 = another_function(1, 2, 3);
$result3 = user_defined_function();

// Built-in PHP functions that don't have PSL equivalents
$result4 = phpinfo();
$result5 = var_dump('test');
$result6 = print_r(['a', 'b']);
echo 'hello';

// Variable function calls should be ignored
$func = 'strlen';
$result8 = $func('hello');

// Anonymous functions should be ignored
$result9 = (function ($x) {
    return $x * 2;
})(5);
