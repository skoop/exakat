<?php

namespace Tokenizer;

class Arguments extends TokenAuto {
    static public $operators = array('T_COMMA');
    static public $atom = 'Arguments';

    public function _check() {
        $operands = 'yes';
        
        // @note arguments separated by ,
        $this->conditions = array(-2 => array('token' => array_merge(array('T_COMMA', 'T_OPEN_PARENTHESIS', 'T_OPEN_BRACKET', 'T_ECHO', 
                                                                           'T_GLOBAL', 'T_USE', 'T_IMPLEMENTS', 'T_EXTENDS', 'T_VAR', 
                                                                           'T_SEMICOLON', 'T_STATIC', 'T_DECLARE', 'T_CONST' ), 
                                                                     _Ppp::$operators)),
                                  -1 => array('atom'    => $operands,
                                              'notAtom' => 'Arguments'),
                                   0 => array('token'   => Arguments::$operators,
                                              'atom'    => 'none'),
                                   1 => array('atom'    => $operands),
                                   2 => array('token'   => array('T_COMMA', 'T_CLOSE_PARENTHESIS', 'T_CLOSE_BRACKET', 'T_SEMICOLON')),
                                 );
        
        $this->actions = array('makeEdge'    => array( 1 => 'ARGUMENT',
                                                      -1 => 'ARGUMENT'
                                                      ),
                               'order'       => array( 1 => '1',
                                                      -1 => '0'),
                               'mergeNext'   => array('Arguments' => 'ARGUMENT'), 
                               'atom'        => 'Arguments',
                               'cleanIndex'  => true
                               );
        $this->checkAuto();

        // @note arguments separated by , (interface), ending on a {
        $this->conditions = array(-1 => array('atom'  => array('Identifier', 'Arguments', 'Nsname') ),
                                   0 => array('token' => Arguments::$operators,
                                              'atom'  => 'none'),
                                   1 => array('atom'  => array('Identifier', 'Nsname')),
                                   2 => array('token' => 'T_OPEN_CURLY')
                                 );
        
        $this->actions = array('makeEdge'    => array( 1 => 'ARGUMENT',
                                                      -1 => 'ARGUMENT'
                                                      ),
                               'order'       => array( 1 => '1',
                                                      -1 => '0'),
                               'mergeNext'   => array('Arguments' => 'ARGUMENT'), 
                               'atom'        => 'Arguments',
                               'cleanIndex'  => true
                               );
        $this->checkAuto();

        // @note End of )
        $this->conditions = array(-2 => array('filterOut' => array("T_NS_SEPARATOR")),
                                  -1 => array('atom'      => $operands,
                                              'notAtom'   => 'Arguments'),
                                   0 => array('token'     => Arguments::$operators,
                                              'atom'      => 'none'),
                                   1 => array('token'     => 'T_CLOSE_PARENTHESIS',
                                              'atom'      => 'none'),
        );
        
        $this->actions = array('makeEdge'    => array(-1 => 'ARGUMENT'),
                               'order'       => array( 1 => '1',
                                                      -1 => '0'),
                               'atom'        => 'Arguments',
                               );
        $this->checkAuto();

        return $this->checkRemaining();
    }

    public function fullcode() {
        return <<<GREMLIN

s = [];
fullcode.out("ARGUMENT").sort{it.order}._().each{ s.add(it.fullcode); };

if (s.size() == 0) {
    s = '';
} else {
    fullcode.setProperty('fullcode', s.join(", "));
}

// note : parenthesis are set in arguments (above), if needed.

GREMLIN;
    }
}
?>