<?php

$expected     = array('$foo->$bar[\'bazf\']( )', 
                      '$foo->$bar[\'baz\']',
                      '$$foo[\'bar\'][\'baz\']',
                      'Foo::$bar[\'baz\']( )', );

$expected_not = array('$$foo[\'bar\']', // Partial result
                      '$$foo1[\'bar1\']',
                      );

?>