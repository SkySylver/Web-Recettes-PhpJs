<?php
require $_SERVER["DOCUMENT_ROOT"].'/Projet/class/User.php';
session_start();
if(\App\isConnected()) Header('Location:home.php');

if(isset($_POST['submit'])){
    if(isset($_POST['login']) && isset($_POST['password'])) {
        if(\App\existUser($_POST['login'], $_POST['password'])){
            \App\User::_load($_POST['login']);

            Header('Location:home.php');
        }
        else $errors['login'] = 'Identifiant ou mot de passe invalide';
    }
    else $errors['login'] = 'Identifiant ou mot de passe invalide';
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php $title = 'Connexion'; require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/header.php'; ?>
    <style>
        #submit:hover{
            background-color: purple;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/nav.php'; ?>
<form method="post" action="#" class="col-8 mx-auto mb-5">

<?php
    if(isset($errors['login'])) echo '<p style="color: red;">' .$errors['login'] .'</p>';
?>
    <legend class="text-center">Connexion</legend>
    <div class="form-group">
        <label for="login">Login</label>
        <input class="form-control" id="login" type="text" name="login" required/>
    </div>
    <div class="form-group">
        <label for="login">Mot de passe</label>
        <input class="form-control" type="password" name="password" required/>
    </div>
    <div class="form-group">
        <input class="form-control" type="submit" name="submit" id="submit" value="Envoyer" required/>
    </div>
</form>


<div id="Recettes" class="container">
</div>
</body>
</html>
