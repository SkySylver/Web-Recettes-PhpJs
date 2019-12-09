<?php
//Modifie le panier : ajoute ou supprime une recette dans le panier

require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/class/Panier.php';


session_start();
use App\Panier;
if(isset($_POST['methode']) && isset($_POST['id'])){
    $id = $_POST['id'];
    if(!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = new Panier();
    }
    switch ($_POST['methode']){
        case 'ajouter':
            $_SESSION['panier']->ajouter($id);
            break;
        case 'supprimer':
            echo 'supp';
            $_SESSION['panier']->supprimer($id);
            break;
    }
    //echo json_encode($_SESSION['panier']->_panier);

}