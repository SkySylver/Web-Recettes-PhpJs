<?php
require $_SERVER["DOCUMENT_ROOT"] . '/Projet/class/User.php';

use App\User;

session_start();
if (!(\App\isConnected())) Header('Location:login.php');

/**
 * Vérifications PHP
 */
if (isset($_POST['submit'])) {
// Password
    if (isset($_POST['password'])) {

        if (!preg_match('/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/', $_POST['password'])) {
            $errors['password'] = 'Votre mot de passe doit contenir au minimum, 8 caractères, dont 2 chiffres, et un caractère spécial !@#$%^&*\\';
            unset($_POST['confirm_password']);
        }
        elseif (!isset($_POST['confirm_password']) || ($_POST['confirm_password'] != $_POST['password'])) $errors['confirm_password'] = 'Veuillez ressaisir le même mot de passe';
        else $_SESSION['user']->setPassword($_POST['password']);
    }

    //Mail
    if (isset($_POST['mail'])) {
        if (trim($_POST['mail']) == '') unset($_POST['mail']);
        elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) $errors['mail'] = 'Veuillez saisir une adresse Email valide';
        else $_SESSION['user']->setMail($_POST['mail']);
    }

    //CP
    if (isset($_POST['CP']) && (strlen($_POST['CP']) != 0)) {
        if (!preg_match('/[0-9]*/', $_POST['CP'])) $errors['CP'] = 'Le code postal doit correspondre a un nombre';
        else $_SESSION['user']->setCP($_POST['CP']);
    }
    //Number
    if (isset($_POST['number']) && (strlen($_POST['number']) != 0)) {
        if (!preg_match('/[0-9]*/', $_POST['number'])) $errors['number'] = 'Le numero de rue doit correspondre a un nombre';
        else $_SESSION['user']->setNumber($_POST['number']);
    }
    //Street
    if (isset($_POST['street']) && (strlen($_POST['street']) != 0)) {
        if (!preg_match('/[a-zA-Z ]*/', $_POST['street'])) $errors['street'] = 'Le nom de rue doit correspondre a des lettres';
        else $_SESSION['user']->setStreet($_POST['street']);
    }
    //City
    if (isset($_POST['city']) && (strlen($_POST['city']) != 0)) {
        if (!preg_match('/[a-zA-Z ]*/', $_POST['city'])) $errors['city'] = 'La ville doit correspondre a des lettres';
        else $_SESSION['user']->setCity($_POST['city']);
    }

    //tel
    if (isset($_POST['tel'])) {
        if (empty($_POST['tel'])) unset($_POST['tel']);
        elseif (!preg_match('/[0-9]{10}/', $_POST['tel'])) $errors['tel'] = 'Veuillez saisir un numéro de téléphone valide';
        else $_SESSION['user']->setTel($_POST['tel']);
    }
    //Maj fichier
    $_SESSION['user']->register();
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php $title = 'Login';
    require $_SERVER["DOCUMENT_ROOT"] . '/Projet/inc/php/header.php'; ?>
</head>
<body>

<?php require $_SERVER["DOCUMENT_ROOT"] . '/Projet/inc/php/nav.php'; ?>

<div>
    <h4 class="h4 text-center">Mes informations personnelles</h4>

    <?php
    $usr = $_SESSION['user'];


    ?>
    <form method="post" action="#">
        <div class="row">
            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Login :</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getLogin(); ?></div>
            <div class="col-sm-6"></div>

            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Nom :</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getName(); ?></div>
            <div class="col-sm-6"></div>

            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Prénom :</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getSurname(); ?></div>
            <div class="col-sm-6"></div>

            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Genre :</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getSexe(); ?></div>
            <div class="col-sm-6"></div>

            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Date de naissance :</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getNaissance(); ?></div>
            <div class="col-sm-6"></div>

            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Adresse Email :</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getMail(); ?></div>
            <div class="form-group col-sm-3">
                <input class="form-control" type="email" name="mail" placeholder="Nouvelle adresse mail">
            </div>
            <div class="col-sm-3"></div>


            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Adresse :</div>
            <div class="col-sm-3 border-bottom border-primary"></div>
            <div class="col-sm-6"></div>

            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Numéro :</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getNumber(); ?></div>
            <div class="form-group col-sm-3">
                <input class="form-control" type="number" name="number" placeholder="Nouveau numéro de rue">
            </div>
            <div class="col-sm-3"></div>


            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Rue</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getStreet(); ?></div>
            <div class="form-group col-sm-3">
                <input class="form-control" type="text" name="street" placeholder="Nouvelle rue">
            </div>
            <div class="col-sm-3"></div>

            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Ville</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getCity(); ?></div>
            <div class="form-group col-sm-3">
                <input class="form-control" type="text" name="city" placeholder="Nouvelle ville">
            </div>
            <div class="col-sm-3"></div>


            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Code Postal</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getCP(); ?></div>
            <div class="form-group col-sm-3">
                <input class="form-control" type="number" name="CP" placeholder="Nouveau code postal">
            </div>
            <div class="col-sm-3"></div>


            <div class="col-sm-2 offset-1 border-right border-bottom border-primary">Téléphone :</div>
            <div class="col-sm-3 border-right border-bottom border-primary"><?= $usr->getSurname(); ?></div>
            <div class="form-group col-sm-3">
                <input class="form-control" type="number" name="tel" placeholder="Nouveau téléphone">
            </div>
            <div class="col-sm-3"></div>


            <div class="col-sm-6"></div>
            <div class="form-group col-sm-3">
                <input class="form-control" type="submit" name="submit" value="Modifier">
            </div>


            <div class="col-sm-6"></div>
            <div class="col-sm-3">
                <?php
                if (isset($errors)) {
                    echo '<ul class="erreurs">';
                    foreach ($errors as $error) {
                        echo '<li>' . $error . '</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>

</body>
</html>
