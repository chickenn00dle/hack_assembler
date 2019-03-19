<?php

// Imports
include_once( 'includes/parser.php' );
include_once( 'includes/translator.php' );

// Globals
$filename = $argv[1];
$writename = writeFilename( $filename );

// Helper function to generate new filename for writing
function writeFilename( $filename ) {
    if ( strpos( $filename, '.' ) ) {
        $pos = strpos( $filename, '.' );
        $new = substr( $filename, 0, $pos );
        return $new . '.hack';
    } else {
        throw new Exception( 'Invalid Filename format for write' );
    }
}

// Assembler Begins
if ( $filename && file_exists( $filename ) ) { // Confirm file exists
    $file = fopen( $filename, 'r' );
    $parseArr = parse( $file );
    $writefile = fopen( $writename, 'w' ) or die( 'Unable to open file ' . $writename );

    foreach ( $parseArr as $parsedLine ) {
        fwrite( $writefile, translateParsedLine( $parsedLine ) ); 
    }
    
    fclose( $writefile );
} else {
    throw new Exception ( 'File not found or not a valid file.' );
}
