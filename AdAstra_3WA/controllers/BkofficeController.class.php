<?php

class BkofficeController{
    
    public function ShowPage($getPage,$formVal){
        $page = $getPage;
        $pageTitle = "Administration";
        $pageDescription = "";
        if($formVal){
            $result = new LoginUser();
            if($result->NewLog($_POST["name"],$_POST["passe"]) == true){
                $_SESSION["logged"] = true;
                echo json_encode("done");
            }
            else{
                echo json_encode("Identifiants incorrects.");
            }
            die;
        }
        require_once 'views/layout.html';
    }
}