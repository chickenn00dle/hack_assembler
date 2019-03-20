<?php 
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

// These functions parse for actual commands 
function symbol( $command ) {
    return substr( $command, 1 ); 
}

function label( $command ) {
    return substr( $command, 1, -1 );
}

function dest( $command ) {
    if ( strpos( $command, '=' ) ) { // if =, get everything before it
        $pos = strpos( $command, '=' );
        return substr( $command, 0, $pos );
    }
    return null;
}

function comp( $command ) {
    $begin = strpos( $command, '=' ); // C_Instruction start
    $end = strpos( $command, ';' );   // C_Instruction end 
    $comment = strpos( $command, ' ' ); // Check for comments
    if ( $begin && $end ) { // COMP between DEST && JMP
        return substr( $command, $begin + 1, $end );
    }    
    if ( $begin ) {
        $cmmnt = strpos( $command, ' ' );
        $result = substr( $command, $begin + 1 ); // COMP after DEST & no JMP
        return trim( $result );
    }
    return substr( $command, 0, $end ); // COMP before JMP & no Dest
}

function jump( $command ) {
    $comment = strpos( $command, ' ' ); // Check for comments
    if ( strpos( $command, ';' ) ) { // if ;, get everything after it
        $pos = strpos( $command, ';' );
        $cmmnt = strpos( $command, ' ' );
        $result =  substr( $command, $pos + 1 );
        return trim( $result );
    }
    return null;
}

// Helper function to strip comments
function stripComments( $line ) {
    $comment = strpos( $line, '//' );
    if ( $comment ) {
        return substr( $line, 0, $comment - 1 );
    }
    return $line;
}

// Primary parse function
function parse( $file ) {
    $parseArr;
    while ( hasMoreCommands( $file ) ) {
        $next = advance( $file ); 
        $strippedLine = stripComments( $next );
        $line = trim( $strippedLine );
        $command = commandType( $line );
        switch ( $command ) {
            case 'SKIP':
                break;
            case 'L_Command':
                break;
            case 'A_Command':
                $acmd = symbol( $line );
                $parseArr[] = [ 'A_Command', $acmd ];
                break;
            case 'C_Command':
                $destcmd = dest( $line );
                $compcmd = comp( $line );
                $jumpcmd = jump( $line );
                $parseArr[] = [ 'C_Command', [ $destcmd, $compcmd, $jumpcmd ] ];
        }
    }
    return $parseArr;
}
