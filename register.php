<?php
require $_SERVER["DOCUMENT_ROOT"].'/Projet/class/User.php';

use App\User;
use function App\isConnected;
session_start();
if (isConnected()) header('Location:home.php');


/**
 * Vérifications PHP
*/
if(isset($_POST['submit'])) {
    //Login
    if (!isset($_POST['login']) || !preg_match('/[a-zA-Z0-9]{3,29}/', $_POST['login'])) {
        $errors['login'] = 'Veuillez saisir un Login valide.';
    } elseif (file_exists('users/' .$_POST['login'] .'.json'))//!Existe
        $errors['login'] = 'Ce Login est déjà utilisé.';


    // Password
    if (!isset($_POST['password']) || !preg_match('/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/', $_POST['password'])) {
        $errors['password'] = 'Votre mot de passe doit contenir au minimum, 8 caractères, dont 2 chiffres, et un caractère spécial !@#$%^&*\\';
        unset($_POST['confirm_password']);
    }
    elseif (!isset($_POST['confirm_password']) || ($_POST['confirm_password'] != $_POST['password'])) $errors['confirm_password'] = 'Veuillez ressaisir le même mot de passe';

    //Nom
    if (isset($_POST['name'])) {
        if (empty($_POST['name'])) unset($_POST['name']);
        elseif (!preg_match('/^[a-zA-ZàáâäãčćèéêëėìíîïńòóôöõùúûüūÿýżźñçčšžÀÁÂÄÃÅĆČĖÈÉÊËÌÍÎÏŃÒÓÔÖÕÙÚÛÜŪŸÝŻŹÑÇŒÆČŠŽ]*$/', $_POST['name'])) $errors['name'] = 'Les caractères spéciaux ne sont pas autorisés.';
    }

    //Prénom
    if (isset($_POST['surname'])) {
        if (empty($_POST[''])) unset($_POST['surname']);
        elseif (!preg_match('/^[a-zA-ZàáâäãčćèéêëėìíîïńòóôöõùúûüūÿýżźñçčšžÀÁÂÄÃÅĆČĖÈÉÊËÌÍÎÏŃÒÓÔÖÕÙÚÛÜŪŸÝŻŹÑÇŒÆČŠŽ]*$/', $_POST['surname'])) $errors['surname'] = 'Les caractères spéciaux ne sont pas autorisés.';
    }

    //Email
    if (isset($_POST['mail'])) {
        if (trim($_POST['mail']) == '') unset($_POST['mail']);
        elseif (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) $errors['mail'] = 'Veuillez saisir une adresse Email valide';
    }

    //Genre
    if (isset($_POST['sexe'])){
        if(empty($_POST['sexe'])) unset($_POST['sexe']);
        elseif (($_POST['sexe'] != 'Monsieur') && ($_POST['sexe'] != 'Madame')) $errors['sexe'] = 'Genre invalide';
    }

    //Date de naissance
    if (isset($_POST['naissance'])) {
        if(empty($_POST['naissance'])) unset($_POST['naissance']);
        elseif (!preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $_POST["naissance"])) {
            $errors['naissance'] = 'Format de date invalide';
        } else {
            $d = explode('-', $_POST['naissance']);
            if (!checkdate($d[1], $d[2], $d[0])) $errors['naissance'] = 'Format de date invalide';
            elseif (strtotime($_POST['naissance'] >= (new DateTime()))) $errors['naissance'] = 'Vous n\'êtes pas encore né ?';
        }
    }

    // Adresse
    if(isset($_POST['CP']) && (strlen($_POST['CP']) != 0)) $cp =$_POST['CP'];
    if(isset($_POST['number']) && (strlen($_POST['number']) != 0)) $number =$_POST['number'];
    if(isset($_POST['street']) && (strlen($_POST['street']) != 0)) $street =$_POST['street'];
    if(isset($_POST['city']) && (strlen($_POST['city']) != 0)) $city =$_POST['city'];

    if(isset($cp) || isset($street) || isset($number) || isset($city)) {
        if (!isset($cp) || !isset($street) || !isset($number) || !isset($city)) {
            $errors['Adress'] = 'Veuillez saisir une adresse complete';
        } elseif (!preg_match('/[0-9]*/', $number)) $errors['number'] = 'Le numero de rue doit correspondre a un nombre';
        elseif (!preg_match('/[0-9]*/', $cp)) $errors['CP'] = 'Le code postal doit correspondre a un nombre';
        elseif (!preg_match('/[a-zA-Z ]*/', $city)) $errors['city'] = 'La ville doit correspondre a des lettres';
        elseif (!preg_match('/[a-zA-Z ]*/', $street)) $errors['street'] = 'Le nom de rue doit correspondre a des lettres';
    }

    // Téléphone
    if(isset($_POST['tel'])) {
        if(empty($_POST['tel'])) unset($_POST['tel']);
        elseif(!preg_match('/[0-9]{10}/', $_POST['tel'])) $errors['tel'] = 'Veuillez saisir un numéro de téléphone valide';
    }

    //Enregistrement si tout est valide
    if(!isset($errors)){
        $usr = new User($_POST['login'], $_POST['password']);

        if(isset($_POST['name'])) $usr->setName($_POST['name']);
        if(isset($_POST['surname'])) $usr->setSurname($_POST['surname']);
        if(isset($_POST['mail'])) $usr->setMail($_POST['mail']);
        if(isset($_POST['sexe'])) $usr->setSexe($_POST['sexe']);
        if(isset($_POST['naissance'])) $usr->setNaissance($_POST['naissance']);
        if(isset($_POST['number'])) $usr->setNumber($_POST['number']);
        if(isset($_POST['street'])) $usr->setStreet($_POST['street']);
        if(isset($_POST['city'])) $usr->setCity($_POST['city']);
        if(isset($_POST['CP'])) $usr->setCP($_POST['CP']);
        if(isset($_POST['tel'])) $usr->setTel($_POST['tel']);

        $usr->register();
        Header('Location:home.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php $title='Inscription'; require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/header.php'; ?>
    <style>
        #submit:hover{
            background-color: purple;
            color: white;
            cursor: pointer;
        }
    </style>
    <script type="text/javascript" src="inc/js/register.js"></script>
</head>
<body>

<?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/nav.php'; ?>

<form action="#" method="post" class="col-8 mx-auto mb-5" id="form">
    Vous êtes déjà inscrit ? <a href="login.php">Connectez vous ici</a>
    <fieldset>
        <legend class="text-center">Inscription</legend>
        <div class="form-group">
            <label for="login">Login *:</label>
            <input class="form-control<?php if(isset($errors['login'])) echo ' is-invalid'; elseif (isset($_POST['login'])) echo ' is-valid';?>" id="login" type="text" name="login" value="<?php if(isset($_POST['login']) && !isset($errors['login'])) echo $_POST['login']; ?>" required/>
            <div class="valid-feedback">Login valide</div>
            <div class="invalid-feedback"><?php if(isset($errors['login'])) echo $errors['login']; ?></div>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe *:</label>
            <input class="form-control<?php if(isset($errors['password'])) echo ' is-invalid'; elseif (isset($_POST['password'])) echo ' is-valid'; ?>" id="password" type="password" name="password" value="<?php if(isset($_POST['password']) && !isset($errors['password'])) echo $_POST['password']; ?>" required/>
            <div class="valid-feedback">Mot de passe valide</div>
            <div class="invalid-feedback"><?php if(isset($errors['password'])) echo $errors['password']; ?></div>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmez votre mot de passe *:</label>
            <input class="form-control<?php if(isset($errors['confirm_password'])) echo ' is-invalid'; elseif (isset($_POST['confirm_password'])) echo ' is-valid';?>" id="confirm_password" type="password" name="confirm_password" value="<?php if(isset($_POST['confirm_password']) && !isset($errors['confirm_password'])) echo $_POST['confirm_password']; ?>" required/>
            <div class="valid-feedback">Mot de passe confirmé</div>
            <div class="invalid-feedback"><?php if(isset($errors['confirm_password'])) echo $errors['confirm_password']; ?></div>
        </div>

        <div class="form-group">
            <label for="name">Nom :</label>
            <input class="form-control<?php if(isset($errors['name'])) echo ' is-invalid'; elseif (isset($_POST['name'])) echo ' is-valid';?>" id="name" type="text" name="name" value="<?php if(isset($_POST['name']) && !isset($errors['name'])) echo $_POST['name']; ?>"/>
            <div class="valid-feedback">Nom valide</div>
            <div class="invalid-feedback"><?php if(isset($errors['name'])) echo $errors['name']; ?></div>
        </div>

        <div class="form-group">
            <label for="surname">Prénom :</label>
            <input class="form-control<?php if(isset($errors['surname'])) echo ' is-invalid'; elseif (isset($_POST['surname'])) echo ' is-valid';?>" id="surname" type="text" name="surname" value="<?php if(isset($_POST['surname']) && !isset($errors['surname'])) echo $_POST['surname']; ?>"/>
            <div class="valid-feedback">Prénom valide</div>
            <div class="invalid-feedback"><?php if(isset($errors['surname'])) echo $errors['surname']; ?></div>
        </div>

        <div class="form-group">
            <label>Genre :</label>
            <div class="form-check">
                <input id="Monsieur" class="form-check-input<?php if(isset($errors['sexe'])) echo ' is-invalid'; ?>" type="radio" name="sexe" value="Monsieur" <?php if(isset($_POST['sexe']) && ($_POST['sexe'] == 'Monsieur')) echo 'checked'; ?>/>
                <label class="form-check-label" for="Monsieur">Monsieur</label>
            </div>
            <div class="form-check">
                <input id="Madame" class="form-check-input <?php if(isset($errors['sexe'])) echo ' is-invalid'; ?>" type="radio" name="sexe" value="Madame" <?php if(isset($_POST['sexe']) && ($_POST['sexe'] == 'Madame')) echo 'checked';?>>
                <label class="form-check-label" for="Madame">Madame</label>
            </div>
        </div>

        <div class="form-group">
            <label for="mail">Adresse Email :</label>
            <input class="form-control<?php if(isset($errors['mail'])) echo ' is-invalid'; elseif (isset($_POST['mail'])) echo ' is-valid';?>" value="<?php if(isset($_POST['mail']) && !isset($errors['mail'])) echo $_POST['mail']; ?>" id="mail" type="email" name="mail"/>
            <div class="valid-feedback">Adresse Email valide</div>
            <div class="invalid-feedback"><?php if(isset($errors['mail'])) echo $errors['mail']; ?></div>
        </div>

        <div class="form-group">
            <label for="naissance">Date de naissance :</label>
            <input class="form-control<?php if(isset($errors['naissance'])) echo ' is-invalid'; elseif (isset($_POST['naissance'])) echo ' is-valid';?>" value="<?php if(isset($_POST['naissance']) && !isset($errors['naissance'])) echo $_POST['naissance']; ?>" id="naissance" type="date" name="naissance"/>
            <div class="valid-feedback">Valide</div>
            <div class="invalid-feedback"><?php if(isset($errors['naissance'])) echo $errors['naissance'] . $_POST['naissance']; ?></div>
        </div>

        <label style="text-decoration: underline;">Adresse :</label>
        <div class="row">
            <div class="form-group col-2">

                <label>Numéro :</label>
                <input class="trig form-control<?php
                if(isset($errors['Adress'])) echo ' is-invalid"';
                elseif (isset($_POST['number'])) echo ' is-valid"';
                if(isset($_POST['number'])) echo 'value="' .$_POST['number'] .'"';
                ?> id="number" type="number" name="number"/>
                <?php if(isset($errors['Adress'])) echo '<div class="invalid-feedback">' .$errors['Adress'] .'</div>';?>
            </div>

            <div class="form-group col-2">
                <label>Rue :</label>
                <input class="trig form-control<?php
                if(isset($errors['Adress'])) echo ' is-invalid';
                elseif (isset($_POST['street'])) echo ' is-valid';

                echo '"';
                if(isset($_POST['street'])) echo 'value="' .$_POST['street'] .'"';
                ?> id="street" type="text" name="street"/>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group col-2">
                <label>Code postal :</label>
                <input class="trig form-control<?php
                if(isset($errors['Adress'])) echo ' is-invalid';
                elseif (isset($_POST['CP'])) echo ' is-valid';
                echo '"';

                if(isset($_POST['CP'])) echo 'value="' .$_POST['CP'] .'"';
                ?> id="CP" type="text" name="CP"/>
            </div>

            <div class="form-group col-2">
                <label>Ville :</label>
                <input class="trig form-control<?php
                if(isset($errors['Adress'])) echo ' is-invalid"';
                elseif (isset($_POST['city'])) echo ' is-valid"';
                if(isset($_POST['city'])) echo 'value="' .$_POST['city'] .'"';
                ?>" id="city" type="text" name="city"/>
            </div>
        </div>

        <div class="form-group">
            <label>Téléphone :</label>
            <input class="form-control<?php if(isset($errors['tel'])) echo ' is-invalid'; elseif (isset($_POST['tel'])) echo ' is-valid';?>" id="tel" type="tel" value="<?php if(isset($_POST['tel']) && !isset($errors['tel'])) echo $_POST['tel']; ?>" name="tel" />
            <div class="valid-feedback">Numéro de téléphone valide</div>
            <div class="invalid-feedback"><?php if(isset($errors['tel'])) echo $errors['tel'] . $_POST['tel']; ?></div>
        </div>

        <div class="form-group">
            <input class="form-control" type="submit" id="submit" name="submit" value="Envoyer"/>
            <div class="invalid-feedback"></div>
        </div>

    </fieldset>
</form>

</body>
</html>
