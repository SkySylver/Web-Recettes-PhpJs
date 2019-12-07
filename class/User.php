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


    public function __construct($log, $pass){
        $this->_login = $log;
        $this->_password = password_hash($pass,PASSWORD_DEFAULT);
    }


    static public function _load($log)
    {
        $instance = new User($log, '1');

        $path = DIR . $log . '.json';
        if (file_exists($path)) {
            $json = file_get_contents($path);
            $data = json_decode($json, true);

            $instance->_name= $data['name'];
            $instance->_surname= $data['surname'];
            $instance->_mail= $data['mail'];
            $instance->_naissance= $data['naissance'];
            $instance->_tel= $data['tel'];
            $instance->_number= $data['number'];
            $instance->_street= $data['street'];
            $instance->_city= $data['city'];
            $instance->_CP= $data['CP'];
            $instance->_sexe = $data['sexe'];

            $_SESSION['user'] = $instance;
        }
    }


    function __destruct(){
        unset($_SESSION['user']);
    }


    function disconnect(){
        $_SESSION['panier']->__destruct();
        $this->__destruct();
    }

    function register(){
        $json = json_encode(array('login' => $this->_login, 'password' => $this->_password, 'name' => $this->_name, 'surname' => $this->_surname, 'sexe' => $this->_sexe, 'mail' => $this->_mail,'naissance' => $this->_naissance, 'tel' => $this->_tel, 'number' => $this->_number, 'street' => $this->_street, 'city' => $this->_city, 'CP' => $this->_CP));
        file_put_contents(DIR .$this->_login .'.json', $json);
        $this->login();
    }

    function login(){
        $_SESSION['user'] = $this;
        if(!isset($_SESSION['panier'])) $_SESSION['panier'] = new Panier();
        $_SESSION['panier']->MajFile();
    }


    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->_login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->_sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->_sexe = $sexe;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->_surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->_surname = $surname;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->_mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail)
    {
        $this->_mail = $mail;
    }

    /**
     * @return string
     */
    public function getNaissance()
    {
        return $this->_naissance;
    }

    /**
     * @param string $naissance
     */
    public function setNaissance($naissance)
    {
        $this->_naissance = $naissance;
    }

    /**
     * @return string
     */
    public function getTel()
    {
        return $this->_tel;
    }

    /**
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->_tel = $tel;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->_number = $number;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->_street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->_street = $street;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->_city = $city;
    }

    /**
     * @return string
     */
    public function getCP()
    {
        return $this->_CP;
    }

    /**
     * @param string $CP
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
