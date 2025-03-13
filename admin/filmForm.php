<?php

require_once "../inc/functions.inc.php";




if (!isset($_SESSION['client'])) {
    header('location:'.RACINE_SITE.'authentication.php');
} else {
    if ($_SESSION['client']['role'] == "ROLE_USER") {
        header('location:'.RACINE_SITE.'profil.php');
    }
}





require_once "../inc/header.inc.php";

?>

























<?php


require_once "../inc/footer.inc.php";


?>