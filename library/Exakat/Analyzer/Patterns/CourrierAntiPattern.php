<?php
/*
 * Copyright 2012-2017 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
 * This file is part of Exakat.
 *
 * Exakat is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Exakat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Exakat.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://exakat.io/>.
 *
*/

namespace Exakat\Analyzer\Patterns;

use Exakat\Analyzer\Analyzer;

class CourrierAntiPattern extends Analyzer {
    public function dependsOn() {
        return array('Patterns/DependencyInjection');
    }
    
    public function analyze() {
        $this->analyzerIs('Patterns/DependencyInjection')
             ->outIsIE('LEFT')
             ->savePropertyAs('code', 'arg')
             ->goToFunction()
             ->outIs('BLOCK')
             ->atomInside('Variable')
             ->samePropertyAs('code', 'arg')
             ->inIs('RIGHT')
             ->outIs('LEFT')
             ->atomIs('Member')
             ->outIs('MEMBER')
             ->savePropertyAs('code', 'property')
             ->goToClass()
             ->outIs('METHOD')
             ->outIs('BLOCK')
             ->atomInside('New')
             ->outIs('NEW')
             ->outIs('ARGUMENTS')
             ->outIs('ARGUMENT')
             ->atomIs('Member')
             ->outIs('MEMBER')
             ->samePropertyAs('code', 'property')
             ->back('first');
        $this->prepareQuery();
    }
}

?>
