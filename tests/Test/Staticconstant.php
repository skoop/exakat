<?php

namespace Test;

include_once(dirname(dirname(__DIR__)).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');

class Staticconstant extends Tokenizeur {
    /* 1 methods */

    public function testStaticconstant01()  { $this->generic_test('Staticconstant.01'); }
}
?>