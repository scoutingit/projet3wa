<?php

class HomeController{
    public function ShowPage($getPage){
        $page = $getPage;
        $pageTitle = ucfirst($getPage);
        $pageDescription = "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.";
        require_once 'views/layout.html';
    }
}