<?php
// Global translate arrays
$DESTARR = array(
    'A' => '100',
    'D' => '010',
    'M' => '001',
    'MD' => '011',
    'AM' => '101',
    'AD' => '110',
    'AMD' => '111',
);

$COMPARR = array( 
    'A' => '0110000',
    'D' => '0001100',
    '!D' => '0001101',
    '-A' => '0110011',
    'D+1' => '0011111',
    'A+1' => '0110111',
    'D-1' => '0001110',
    'A-1' => '0110010',
    'D+A' => '0000010',
    'D-A' => '0010011',
    'A-D' => '0000111',
    'D&A' => '0000000',
    'D|A' => '0010101',
    'M' => '1110000',
    '!M' => '1110001',
    '-M' => '1110011',
    'M+1' => '1110111',
    'M-1' => '1110010',
    'D+M' => '1000010',
    'D-M' => '1010011',
    'M-D' => '1000111',
    'D&M' => '1000000',
    'D|M' => '1010101',
    '0' => '0101010',
    '1' => '0111111',
    '-1' => '0111010', 
);

$JUMPARR = array(
    'JGT' => '001',
    'JEQ' => '010',
    'JGE' => '011',
    'JLT' => '100',
    'JNE' => '101',
    'JLE' => '110',
    'JMP' => '111', 
);

// Translate dest to bits
function translateDest( $dest ) {
    global $DESTARR;
    if ( isset( $dest ) ) {
        $bits = $DESTARR[ $dest ] ;
        return $bits;
    }
    return '000';
}

// Translate comp to bits
function translateComp( $comp ) {
    global $COMPARR;
    if ( isset( $comp ) ) {
        $bits = $COMPARR[ $comp ];
        return $bits;
    } 
}

// Translate jump to bits
function translateJump( $jump ) {
    global $JUMPARR;
    if ( isset( $jump ) ) { 
        $bits = $JUMPARR[ $jump ];
        return $bits; 
    }
    return '000';
}

// Translate A command to bits
function translateVal( $val ) {
    $bin =  decbin( $val );
    $abits = str_pad( $bin, 16, '0', STR_PAD_LEFT);
    return $abits;
}
