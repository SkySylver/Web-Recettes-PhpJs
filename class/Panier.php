<?php

namespace App;
require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/Donnees.inc.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/class/User.php';
const dirp = 'panier/';
class Panier
{

    /**
     * Tableau des recettes preferes en tant qu'id de chaque recette dans $Recettes
     */
    public $_panier = array();


    /**
     * Constructeur par défaut
     */
    public function __construct(){}


    /**
     * Mise à jour du fichier du panier si l'utilisateur est connecté
     */
    function MajFile()
    {
        if (isConnected()) {
            $json = json_encode($this->_panier);
            file_put_contents($_SERVER["DOCUMENT_ROOT"].'/Projet/panier/' . $_SESSION['user']->getLogin() . '.json', $json);
        }
    }


    /**
     * @return Nombre de recettes preferees dans le panier
     */
    function getTaille()
    {
        return sizeof($this->_panier);
    }


    /**
     * @param $r : Recette à ajouter au panier
     */
    function ajouter($r)
    {
        if (!in_array($r, $this->_panier)) array_push($this->_panier, $r);
        $this->MajFile();
    }


    /**
     * Supprime la recette du panier a l'indice $i
     * Et met a jour le fichier de l'utilisateur si connecté
     *
     * @param $r : id de la Recette à retirer du panier
     */
    function supprimer($r)
    {
        foreach ($this->_panier as $indice => $tmp) {
            if ($tmp == $r) unset($this->_panier[$r]);
        }
        $this->MajFile();
    }

    /**
     * Affiche la recette du panier a l'indice i
     * Et met a jour le fichier de l'utilisateur si connecté
     *
     * @param $i : Indice dans les recette preferees
     * Si $i == -1 : Affiche toutes les recettes preferes
     */
    function afficher($i)
    {
        if ($this->getTaille() == 0) echo 'Votre panier de recettes est vide...';

        if ($i == -1) foreach ($this->_panier as $r) $this->afficher($r);
        elseif (isset($this->_panier[$i])) {
            ?>
            <div>
                <h1><?= $Recettes[$this->_panier[$i]]['titre']; ?></h1>
                <p>Ingredients : <?= $Recettes[$this->_panier[$i]]['ingredients']; ?></p>
                <p>Preparation : <?= $Recettes[$this->_panier[$i]]['preparation']; ?></p>
            </div>
            <?php
        }
    }
}
