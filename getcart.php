
<?php
    session_start();
    include "config.php";
    
    $arr = unserialize($_SESSION['ur']);

    $cd = new cartDAO();

    $cd->uid = $arr['uid'];
    
    $cd->getCartData();
?>