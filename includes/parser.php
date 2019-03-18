<?php 

// import translator
include_once( 'translator.php' );

function hasMoreCommands( $file ) {
    return !feof( $file );
}

function advance( $file ) {
    return fgets( $file );
}

// Check command type of each line
function commandType( $line ) {
    $firstChar = substr( $line, 0, 1 );
    if ( $firstChar == '' ) { // if line is emtpy, skip
       return 'SKIP'; 
    } else if ( ! is_numeric( $firstChar ) ) {
        switch ( $firstChar ) {
            case '@':
                return 'A_Command';
                break;
            case '(':
                return 'L_Command';
                break;
            case '/':
                return 'SKIP';
                break;
            default:
                return 'C_Command';
        }
    } else {
        return 'C_Command'; // remaining case, command begins with 0
    }
    
}


// These functions parse for the actual commands 
function symbol( $command ) {
    return substr( $command, 1 ); 
}

function dest( $command ) {
    if ( strpos( $command, '=' ) ) { // if there is an =, get everything before it
        $pos = strpos( $command, '=' );
        return substr( $command, 0, $pos );
    }
    return null;
}

function comp( $command ) {
    $begin = strpos( $command, '=' ); // Get location of C_Instruction start
    $end = strpos( $command, ';' );   // Get location of C_Instruction end 
    if ( $begin && $end ) { // COMP between DEST && JMP
        return substr( $command, $begin + 1, $end );
    }    
    if ( $begin ) {
        return substr( $command, $begin + 1 ); // COMP after DEST & no JMP
    }
    return substr( $command, 0, $end ); // COMP before JMP & no Dest
}

function jump( $command ) {
    if ( strpos( $command, ';' ) ) { // if there is a ;, get everything after it
        $pos = strpos( $command, ';' );
        return substr( $command, $pos + 1);
    }
    return null;
}


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

// Primary parse function
function parse( $file, $writefile ) {
    while ( hasMoreCommands( $file ) ) {
        $next = advance( $file ); 
        $line = trim( $next );
        $command = commandType( $line );
        switch ( $command ) {
            case 'SKIP':
                break;
            case 'L_Command':
                break;
            case 'A_Command':
                $acmd = symbol( $line );
                fwrite( $writefile, translateVal( $acmd ) . "\n" );
                break;
            case 'C_Command':
                $destcmd = dest( $line );
                $compcmd = comp( $line );
                $jumpcmd = jump( $line );
                $destbits = translateDest( $destcmd );
                $compbits = translateComp( $compcmd );
                $jumpbits = translateJump( $jumpcmd );
                fwrite( $writefile, '111' . $compbits . $destbits . $jumpbits . "\n");
        }
    }
}
