<?php  // content="text/plain; charset=iso-8859-1"

if( empty($_GET['id']) ) {
    echo 'Incorrect argument(s) to script <b>'.basename(__FILE__).'</b>.'; 
}
else {
    echo 'Some details on bar with id='.$_GET['id'];
}

?>
