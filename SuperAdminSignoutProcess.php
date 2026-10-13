<?php

session_start();

if(isset($_SESSION["su"])){

    $_SESSION["su"] = null;
    session_destroy();

    echo ("success");
    
}

?>