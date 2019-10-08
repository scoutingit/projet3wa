<?php

class UnlogController{

    public function UnlogUser(){
        session_destroy();
        unset($_SESSION);
        header('Location: home/');
    }
}