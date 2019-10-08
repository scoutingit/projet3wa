<?php
session_start();
date_default_timezone_set('Europe/Paris');
setlocale (LC_TIME, 'fr_FR.utf8','fra');

//autoload class
spl_autoload_register(function ($className) {
    if(is_file('controllers/'.ucfirst($className).'.class.php')){
        require_once('controllers/'.ucfirst($className).'.class.php');
    }
    else if(is_file('models/'.lcfirst($className).'.class.php')){
        require_once('models/'.lcfirst($className).'.class.php');
    }
});

$page = $_GET['page']??'home';

switch($page) {
    case 'home':
    case 'lune':
    case 'mars':
    case 'suborbital':
        return (new HomeController())->ShowPage($page);
        break;
    case 'bkoffice':
        return (new BkofficeController())->ShowPage($page,$_POST);
        break;
    case 'message':
        return new MessageController($_POST);
        break;
    case 'unlog':
        return (new UnlogController())->UnlogUser();
        break;
    default:
        http_response_code(404);
        return (new ErrorController())->ShowPage();
}