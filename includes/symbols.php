<?php

// Imports
include_once( 'parser.php' );
include_once( __DIR__ . '/../classes/symbols.php' );

// Parse file for symbols
function parseSymbols( $file ) {
    $symbolTable = new SymbolTable();
    $lcmd = null;
    $n = -1;
    while ( hasMoreCommands( $file ) ) {
        $next = advance( $file );
        $line = trim( $next );
        $command = commandType( $line );
        if ( $command == 'SKIP' ) {
            continue; 
        } else if ( $command == 'L_Command' ) {
            $lcmd = label( $line );
        } else if ( $command == 'A_Command' || $command == 'C_Command' ) {
            $lcmd ? $symbolTable->addEntry( $lcmd, $n ) : $lcmd = null;
            $n++;
        }
    } 
    return $symbolTable;
}
