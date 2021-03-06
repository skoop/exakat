<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Structures_ShortTags extends Analyzer {
    /* 6 methods */

    public function testStructures_ShortTags01()  { $this->generic_test('Structures_ShortTags.01'); }
    public function testStructures_ShortTags02()  { $this->generic_test('Structures_ShortTags.02'); }
    public function testStructures_ShortTags03()  { $this->generic_test('Structures_ShortTags.03'); }
    public function testStructures_ShortTags04()  { $this->generic_test('Structures_ShortTags.04'); }
    public function testStructures_ShortTags05()  { $this->generic_test('Structures_ShortTags.05'); }
    public function testStructures_ShortTags06()  { $this->generic_test('Structures_ShortTags.06'); }
}
?>