<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Structures_Bracketless extends Analyzer {
    /* 5 methods */

    public function testStructures_Bracketless01()  { $this->generic_test('Structures_Bracketless.01'); }
    public function testStructures_Bracketless02()  { $this->generic_test('Structures_Bracketless.02'); }
    public function testStructures_Bracketless03()  { $this->generic_test('Structures_Bracketless.03'); }
    public function testStructures_Bracketless04()  { $this->generic_test('Structures_Bracketless.04'); }
    public function testStructures_Bracketless05()  { $this->generic_test('Structures/Bracketless.05'); }
}
?>