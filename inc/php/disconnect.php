<?php
//Deconnecte User

require $_SERVER["DOCUMENT_ROOT"].'/Projet/class/User.php';
use App\Panier;
    session_start();
    $_SESSION['user']->disconnect();
    session_destroy();
    Header('Location:/Projet/home.php');