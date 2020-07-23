<?php

class SuccessController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {

        if(empty($_SESSION) == true) {
            $http->redirectTo('/');
        }
        
    	//var_dump($_GET['id']);
        $msg = "<p>Une commande a été effectué<p><p>Email : ".$_SESSION['user']['email']." num commande :".$_GET['id'];

        mail('cast.leotimbert@gmail.com', 'commande passé num : '.$_GET['id'], $msg);

        return ['num' => $_GET['id']];
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
       	
    }
}