<?php
require $_SERVER["DOCUMENT_ROOT"].'/Projet/class/User.php';
require $_SERVER["DOCUMENT_ROOT"].'/Projet/class/Panier.php';
session_start();
    use App\User;
    use App\Panier;
    use function App\isConnected;

    if(!isset($_SESSION['panier'])) $_SESSION['panier'] = new Panier();
    $pan = $_SESSION['panier'];

?>

<!DOCTYPE html>
<html>
<head>
<?php $title='Panier'; require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/header.php'; ?>
<script src="inc/js/Panier.js" type="text/javascript"></script>
</head>

<?php require $_SERVER["DOCUMENT_ROOT"].'/Projet/inc/php/nav.php'; ?>
<body>

<?php $pan->afficher(-1); ?>
<button onclick="AjouterPanier(1);">ffff</button>
</body>

</html>