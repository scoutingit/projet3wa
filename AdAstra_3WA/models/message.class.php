<?php

class Message{
    private $result;

    public function GetMessage(){
        $bdd = new Database();
        $this->result = $bdd->query('SELECT messages.contactId,contactName,contactLname,contactDate,contactDestination,contactMail,contactMessage,contactState, mails.mailMessage, mails.mailDate, users.userId, users.userName
        FROM messages
        LEFT JOIN mails ON messages.contactId = mails.contactId 
        LEFT JOIN users ON mails.userId = users.userId 
        ORDER BY contactDate ASC, contactState ASC', array());
        return $this->result;
    }
    
    public function CreateMessage(){
        $scArray = array (htmlspecialchars(ucfirst($_POST["name"])),
            htmlspecialchars(ucfirst($_POST["lname"])),
            htmlspecialchars(str_replace(array("\n","\r",PHP_EOL),'',$_POST["mail"])),
            htmlspecialchars($_POST["message"]),
            htmlspecialchars(ucfirst($_POST["destination"])),0);
        $bdd = new Database();
        foreach($_POST as $value){
            $value = htmlspecialchars($value);
        }
        $this->result = $bdd->prepare('INSERT INTO messages(contactName, contactLname,contactMail,contactMessage,contactDestination,contactState,contactDate) VALUES(?,?,?,?,?,?,NOW())', $scArray);
        return $this->result;
    }
    
    public function DeleteMessage(){
        $this->DeleteMailMessage($_POST["delId"]);
        $bdd = new Database();
        $this->result = $bdd->prepare('DELETE FROM messages WHERE contactId = ?', array($_POST["delId"]));
        return $this->result;
    }
    
    private function DeleteMailMessage($delId){
        $bdd = new Database();
        $this->result = $bdd->prepare('DELETE FROM mails WHERE contactId = ?', array($delId));
    }
    
    public function SetStatut($messState,$messId){
        $bdd = new Database();
        $this->result = $bdd->prepare('UPDATE messages SET contactState = ? WHERE contactId = ?', array($messState,$messId));
        return $this->result;
    }
}