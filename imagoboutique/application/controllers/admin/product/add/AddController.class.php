<?php

class AddController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
    /*  Méthode appelée en cas de requête HTTP GET
        
    L'argument $http est un objet permettant de faire des redirections etc.
    L'argument $queryFields contient l'équivalent de $_GET en PHP natif.    */


        if(empty($_SESSION) == true || $_SESSION['user']['role'] != "admin" ) {
            $http->redirectTo('/');
            /*  Empêche l'accès aux fonctions admin 
            lorsque l'utilisateur n'est pas admin */
        }
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
    /*  Méthode appelée en cas de requête HTTP POST
        
    L'argument $http est un objet permettant de faire des redirections etc.
    L'argument $formFields contient l'équivalent de $_POST en PHP natif.    */


        $fileName = $_FILES['tee_pict']['name'];

        var_dump($_FILES['tee_pict']['size'] > 0);

        if ($_FILES['tee_pict']['size'] > 0 ) {
           $http->moveUploadedFile('tee_pict', '/images/tee'); 

        } else {
            $fileName = 'no-photo.png';
        }

        var_dump($fileName);
        $teeModel = new TeeModel();
        $teeModel->addTee($_POST, $fileName);
        $http->redirectTo('/admin');
    }
}