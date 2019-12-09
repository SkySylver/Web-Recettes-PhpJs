<?php
namespace App;

require_once $_SERVER["DOCUMENT_ROOT"].'/Projet/class/Panier.php';
use App\Panier;
const DIR = 'users/';
class User
{

    private $_login;
    private $_password;
    private $_name='', $_surname='', $_mail='', $_naissance='', $_tel='', $_number='', $_street='', $_city='', $_CP='', $_sexe ='';


    /**
     * Constructeur
     *  Si nombre argument = 1
     *      Charge un utilisateur a partir de son fichier utilisateur.json
     *
     *  Si nombre argument = 2
     *      Construit un utilisateur avec login et mot de passe (haché)
     *
     */
    public function __construct(){

        $cpt = func_num_args();
        $args = func_get_args();


        switch($cpt){
            case '1':
                $this->_login = $args[0];
                $path = DIR . $args[0] . '.json';
                if (file_exists($path)) {
                    $json = file_get_contents($path);
                    $data = json_decode($json,true);

                    $this->_password = password_hash($data['password'],PASSWORD_DEFAULT);
                    $this->_name = $data['name'];
                    $this->_surname = $data['surname'];
                    $this->_mail = $data['mail'];
                    $this->_naissance = $data['naissance'];
                    $this->_tel = $data['tel'];
                    $this->_number = $data['number'];
                    $this->_street = $data['street'];
                    $this->_city = $data['city'];
                    $this->_CP = $data['CP'];
                    $this->_sexe = $data['sexe'];
                }
                break;

            case '2':
                $this->_login = $args[0];
                $this->_password = password_hash($args[1],PASSWORD_DEFAULT);
                break;
        }


    }


    /**
     * Destructeur
     */
    function _destruct(){
        unset($_SESSION['user']);
    }

    /**
     * Déconnecte l'utilisateur et vide la session
     */
    function disconnect(){

        if(isset($_SESSION['panier'])) unset($_SESSION['panier']);
        $this->_destruct();
    }

    /**
     * Sauvegarde/met à jour les données de l'utilisateur
     * Et le charge dans la session
     */
    function register(){
        $json = json_encode(array('login' => $this->_login, 'password' => $this->_password, 'name' => $this->_name, 'surname' => $this->_surname, 'sexe' => $this->_sexe, 'mail' => $this->_mail,'naissance' => $this->_naissance, 'tel' => $this->_tel, 'number' => $this->_number, 'street' => $this->_street, 'city' => $this->_city, 'CP' => $this->_CP));
        file_put_contents(DIR .$this->_login .'.json', $json);
        $this->login();
    }

    /**
     * Met User dans la sessions $_SESSION['user']
     * Et charge le panier de celui-ci + Le met a jour
     */
    function login(){
        $_SESSION['user'] = $this;
        if(!isset($_SESSION['panier'])) $_SESSION['panier'] = new Panier();
        $_SESSION['panier']->MajFile();
    }


    /**
     * @return Login de l'utilisateur
     */
    public function getLogin()
    {
        return $this->_login;
    }

    /**
     * @return Le mot de passe chiffré de l'utilisateur
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param $password : Nouveau mot de passe chiffré
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return Genre de User
     */
    public function getSexe()
    {
        return $this->_sexe;
    }

    /**
     * @param $sexe : Nouveau genre de la personne
     */
    public function setSexe($sexe)
    {
        $this->_sexe = $sexe;
    }

    /**
     * @return Nom de la personne
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param $name : Nouveau nom de l'utilisateur
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return Prénom de User
     */
    public function getSurname()
    {
        return $this->_surname;
    }

    /**
     * @param $surname : Nouveau prénom
     */
    public function setSurname($surname)
    {
        $this->_surname = $surname;
    }

    /**
     * @return Email de User
     */
    public function getMail()
    {
        return $this->_mail;
    }

    /**
     * @param $mail : Nouvelle adresse mail de User
     */
    public function setMail($mail)
    {
        $this->_mail = $mail;
    }

    /**
     * @return Date de naissance
     */
    public function getNaissance()
    {
        return $this->_naissance;
    }

    /**
     * @param $naissance : Nouvelle date de naissance
     */
    public function setNaissance($naissance)
    {
        $this->_naissance = $naissance;
    }

    /**
     * @return
     */
    public function getTel()
    {
        return $this->_tel;
    }

    /**
     * @param $tel
     */
    public function setTel($tel)
    {
        $this->_tel = $tel;
    }

    /**
     * @return
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * @param $number
     */
    public function setNumber($number)
    {
        $this->_number = $number;
    }

    /**
     * @return
     */
    public function getStreet()
    {
        return $this->_street;
    }

    /**
     * @param $street
     */
    public function setStreet($street)
    {
        $this->_street = $street;
    }

    /**
     * @return
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * @param $city
     */
    public function setCity($city)
    {
        $this->_city = $city;
    }

    /**
     * @return
     */
    public function getCP()
    {
        return $this->_CP;
    }

    /**
     * @param $CP
     */
    public function setCP($CP)
    {
        $this->_CP = $CP;
    }
}


function existUser($login, $password){

    $path = 'users/' .$login .'.json';
    if(file_exists($path)){
        $cont = file_get_contents($path);
        $data = json_decode($cont, true);
        if(password_verify($password, $data['password'])) return true;
        else return false;
    }
    else return false;
}

function isConnected(){
    if (session_status() == PHP_SESSION_NONE) return false;
    if (isset($_SESSION['user'])) return true;
    else return false;
}
