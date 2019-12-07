<?php
namespace App;

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
        // TODO: Implement __destruct() method.
    }


    function disconnect(){
        unset($_SESSION['user']);
        $this->__destruct();
    }

    function register(){
        $json = json_encode(array('login' => $this->_login, 'password' => $this->_password, 'name' => $this->_name, 'surname' => $this->_surname, 'sexe' => $this->_sexe, 'mail' => $this->_mail,'naissance' => $this->_naissance, 'tel' => $this->_tel, 'number' => $this->_number, 'street' => $this->_street, 'city' => $this->_city, 'CP' => $this->_CP));
        file_put_contents(DIR .$this->_login .'.json', $json);
        $this->login();
    }

    function login(){
        $_SESSION['user'] = $this;
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
    public function setPassword($password): void
    {
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getSexe(): string
    {
        return $this->_sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe(string $sexe): void
    {
        $this->_sexe = $sexe;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->_surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->_surname = $surname;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->_mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->_mail = $mail;
    }

    /**
     * @return string
     */
    public function getNaissance(): string
    {
        return $this->_naissance;
    }

    /**
     * @param string $naissance
     */
    public function setNaissance(string $naissance): void
    {
        $this->_naissance = $naissance;
    }

    /**
     * @return string
     */
    public function getTel(): string
    {
        return $this->_tel;
    }

    /**
     * @param string $tel
     */
    public function setTel(string $tel): void
    {
        $this->_tel = $tel;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->_number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->_number = $number;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->_street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->_street = $street;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->_city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->_city = $city;
    }

    /**
     * @return string
     */
    public function getCP(): string
    {
        return $this->_CP;
    }

    /**
     * @param string $CP
     */
    public function setCP(string $CP): void
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
