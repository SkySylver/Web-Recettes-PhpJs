<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/class/Panier.php';
session_start();

use App\Panier;

if(!isset($_SESSION['panier'])) $_SESSION['panier'] = new Panier();

    if(isset($_POST['id'])) $_SESSION['panier']->afficher($_POST['id']);