<?php
// Retourne sous catégorie d'une catégorie cliqué dans la hierarchie

require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/Donnees.inc.php';


$_POST['id'] = trim($_POST['id']);


if (isset($_POST['id']) && array_key_exists($_POST['id'], $Hierarchie)) {
    $Recettes_res = array();
    echo '<ul>';

    if(isset($Hierarchie[$_POST['id']]['sous-categorie'])) {
        foreach ($Hierarchie[$_POST['id']]['sous-categorie'] as $val) {

            //Si pas plus de specificité
            if(!isset($Hierarchie[$_POST['id']]['sous-categorie'])){
                //Obtenir la/les recette/s
                foreach ($Recettes as $rec){
                    //Si ingredient dans la recette
                    if(in_array($val, $rec['index'])){
                        //Ajoute la recette a la liste des recettes de l'ingredient
                        array_push($Recettes_res['index'],$rec);
                    }
                }
            }
            //Sinon il y a des sous listes
            else echo '<li class="btn-rec">' . $val . '</li>';
        }
    }
    echo '</ul>';
}else if(isset($_POST['id']) && $_POST['id'] == "Hierarchie"){
    foreach ($Hierarchie as $categorie => $restes) {
        if (!isset($restes['super-categorie']))
            foreach ($restes['sous-categorie'] as $Aliment)
                echo '<li class="btn-rec">' . $Aliment . '</li>';
    }
}
?>