<?php

// Imports
include_once( 'parser.php' );
include_once( __DIR__ . '/../classes/symbols.php' );

// Parse file for symbols
function parseSymbols( $file ) {
    $symbolTable = new SymbolTable();
    $lcmds = [];
    $n = 0;
    while ( hasMoreCommands( $file ) ) {
        $next = advance( $file );
        $strippedLine = stripComments( $next );
        $line = trim( $strippedLine );
        $command = commandType( $line );
        if ( $command == 'SKIP' ) {
            continue; 
        } else if ( $command == 'L_Command' ) {
            $lcmds[] = label( $line );
        } else if ( $command == 'A_Command' || $command == 'C_Command' ) {
            if ( $lcmds ) {
                foreach ( $lcmds as $lcmd ) {
                    $symbolTable->addEntry( $lcmd, $n );
                }
                $lcmds = [];
            }
            $n++;
        }
    } 
    return $symbolTable;
}

function parseSymAddr( $file, $symbolTable ) {
    $n = 16;
    while ( hasMoreCommands( $file ) ) {
        $next = advance( $file );
        $strippedLine = stripComments( $next );
        $line = trim( $strippedLine );
        $command = commandType( $line );
        if ( $command == 'A_Command' ) {
            $value = symbol( $line );
            $addedSym = $symbolTable->contains( $value );
            if ( ! is_numeric( $value ) && ! $addedSym ) {
                $symbolTable->addEntry( $value, $n );
                $n++;
            }    
        }
    }
    return $symbolTable;
}
