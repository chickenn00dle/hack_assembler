<?php

class SymbolTable { 
    public function __construct() {
        $this->table = [
            'SP' => 0,
            'LCL' => 1,
            'ARG' => 2,
            'THIS' => 3,
            'THAT' => 4,
            'R0' => 0,
            'R1' => 1,
            'R2' => 2,
            'R3' => 3,
            'R4' => 4,
            'R5' => 5,
            'R6' => 6,
            'R7' => 7,
            'R8' => 8,
            'R9' => 9,
            'R10' => 10,
            'R11' => 11,
            'R12' => 12,
            'R13' => 13,
            'R14' => 14,
            'R15' => 15,
            'SCREEN' => 16384,
            'KBD' => 24576,
        ];
    } 

    public function addEntry( $symbol, $address ) { 
        $this->table[ $symbol ] = $address;
    } 

    public function contains( $symbol ) {
        return array_key_exists( $symbol, $this->table );
    }

    public function getAddress( $symbol ) {
        return $this->table[ $symbol ];
    }
} 
