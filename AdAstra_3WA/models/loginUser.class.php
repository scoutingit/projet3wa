<?php
class LoginUser{
    private $userName;
    private $userPass;
    private $result;

    public function NewLog($user,$pass){
        $this->userName = htmlspecialchars($user);
        $this->userPass = hash('sha512',$pass);
        
        $bdd = new Database();
        $this->result = $bdd->query('SELECT * FROM users WHERE userName = ?  AND userPass = ?', array($this->userName,$this->userPass));
        
        return $this->result;
    }
}