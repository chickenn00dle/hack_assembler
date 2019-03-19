<?php
// Imports
include_once( 'includes/parser.php' );
include_once( 'includes/translator.php' );
include_once( 'includes/symbols.php' );

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
    $file = fopen( $filename, 'r' ); // Open file read only
    $symbols = parseSymbols( $file ); // Fill symbol table 
    rewind( $file );
    $parseArr = parse( $file ); // Generate parse array
    $writefile = fopen( $writename, 'w' ) or die( 'Unable to open file ' . $writename ); // Open write file write only
    foreach ( $parseArr as $parsedLine ) { // Iterate through parse array and translate into bits
        fwrite( $writefile, translateParsedLine( $parsedLine, $symbols ) . "\n" ); 
    }
    fclose( $writefile ); // Close write file
} else {
    throw new Exception ( 'File not found or not a valid file.' );
}
