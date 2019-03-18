<?php

// Imports
include_once( 'includes/parser.php' );


// Globals
$filename = $argv[1];
$writename = writeFilename( $filename );

// Open write file 
$writefile = fopen( $writename, 'w' ) or die( 'Unable to open file ' . $writename );

if ( $filename && file_exists( $filename ) ) { // Confirm file exists
    $file = fopen( $filename, 'r' );
    parse( $file, $writefile );
} else {
    throw new Exception ( 'File not found or not a valid file.' );
}

fclose( $writefile );

