<?php
class SendMail{
    private $headers;
    private $obj;
    private $back_ligne;
    private $result;
    
    public function NewMail($mailto,$mailfrom,$message,$contactId,$userId){
        $message = htmlspecialchars($message);
        $mailto = htmlspecialchars($mailto);
        
    	if(!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mailto)){// On filtre les serveurs qui rencontrent des bogues.
    		$this->back_ligne = "\r\n";
    	}
    	else{
    		$this->back_ligne = "\n";
    	}
    	$this->obj = "Votre demande d'information - Ad Astra";
    	$this->messContent= "<html><body>".$message."</body></html>";
    	// Always set content-type when sending HTML email
    	$this->headers = "MIME-Version: 1.0" .$this->back_ligne;
    	$this->headers .= "Content-type:text/html;charset=UTF-8".$this->back_ligne;
    	$this->headers .= 'From: <'.$mailfrom.'>' .$this->back_ligne;
    	//envoi
    	mail($mailto,$this->obj,$this->messContent,$this->headers);
    	
    	$this->RecMail($message,$contactId,$userId);
    }
    
    private function RecMail($message,$contactId,$userId){
        $message = htmlspecialchars($message);
        
        if(!$this->AnswerExist($contactId)){
            $bdd = new Database();
            $this->result = $bdd->prepare('INSERT INTO mails(contactId, userId, mailMessage, mailDate) VALUES(?,?,?,NOW())', 
            array($contactId,$userId,$message));
        }
    }
    
    private function AnswerExist($contactId){
        $bdd = new Database();
        $this->result = $bdd->query('SELECT * FROM mails WHERE contactId = ?', array($contactId));
        
        return $this->result;
    }
}