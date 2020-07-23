<?php

class DeleteController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
    /*  Méthode appelée en cas de requête HTTP GET
        
    L'argument $http est un objet permettant de faire des redirections etc.
    L'argument $queryFields contient l'équivalent de $_GET en PHP natif.    */


        if(empty($_SESSION) == true || $_SESSION['user']['role'] != "admin" ) {
            $http->redirectTo('/');
            /*  Empêche l'accès aux fonctions admin lorsque 
            l'utilisateur n'est pas admin */
        }
        
        
        $id = $_GET['id'];
        $url = 'application/www/images/tee/';

        $teeModel = new TeeModel();
        $tee = $teeModel->findOneTee($id);

        if (file_exists ( $url.$tee['Photo'])) {
            unlink($url.$tee['Photo']);
        }
        
        $teeModel->deleteTee($id);

        $http->redirectTo('/admin');

    }

    public function httpPostMethod(Http $http, array $formFields)
    {
    /*  Méthode appelée en cas de requête HTTP POST
        
    L'argument $http est un objet permettant de faire des redirections etc.
    L'argument $formFields contient l'équivalent de $_POST en PHP natif.    */
    }
}