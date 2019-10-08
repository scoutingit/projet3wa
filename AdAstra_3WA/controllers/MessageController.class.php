<?php

class MessageController{
    
    public function __construct(array $array){
        if(isset($array["selectAll"])){//select message
            $this->SelectAll();
        }
        else if(isset($array["name"]) && !empty($array["name"])){//create
            $this->CreateNewMessage();
        }
        else if(isset($array["del"])){//delete message
            $this->DeleteNewMessage();
        }
        else if(isset($array["sendMail"])){//sendmail
            $this->SendNewMail($array);
        }
    }
    
    private function SelectAll(){
        $result = new Message();
        echo json_encode($result->GetMessage());
    }
    
    private function CreateNewMessage(){
        $result = new Message();
        if(is_numeric($result->CreateMessage())){
            echo json_encode("<span>Message envoyé!</span>");
        }
        else{
            echo json_encode("Erreur lors de l'envoi.");
        }
    }
    
    private function DeleteNewMessage(){
        $result = new Message();
        if(is_numeric($result->DeleteMessage())){
            echo json_encode("done");
        }
        else{
            echo json_encode("Erreur lors de la suppression.");
        }   
    }
    
    private function SendNewMail($array){
        //update statut message
        $updateState = new Message();
        $updateState->SetStatut(1,$array["messId"]);
        
        $newMail = new SendMail();
        $newMail->NewMail($array["mail"],"contact@adastra.com",$array["message"],$array["messId"],$array["userId"]);
        
        echo json_encode("done");
    }
}