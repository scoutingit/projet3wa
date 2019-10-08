<?php

class ErrorController{
    
    public function ShowPage(){
        $page = "Erreur 404";
        $pageTitle = "Erreur 404";
        $pageDescription = "Erreur lors de la requête.";
        require_once 'views/error.html';
    }
}