<?php

class UpdateController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        /*  Méthode appelée en cas de requête HTTP GET
        L'argument $http est un objet permettant de faire des redirections etc.
        L'argument $queryFields contient l'équivalent de $_GET en PHP natif.   */


        if(empty($_SESSION) == true || $_SESSION['user']['role'] != "admin" ) {
            $http->redirectTo('/');
            /*  Empêche l'accès aux fonctions admin lorsque 
            l'utilisateur n'est pas admin */
        }
        

        $id = $_GET['id'];

        $teeModel = new TeeModel();
        $tee = $teeModel->findOneTee($id); 

        return [
            'tee'=>$tee
        ];

    }

    public function httpPostMethod(Http $http, array $formFields)
    {
    /*  Méthode appelée en cas de requête HTTP POST
        
    L'argument $http est un objet permettant de faire des redirections etc.
    L'argument $formFields contient l'équivalent de $_POST en PHP natif.    */


        var_dump($_POST);
        var_dump($_FILES);
        $url = 'application/www/images/tee/';
        $fileName = $_FILES['tee_pict']['name'];
        $id = $_POST['teeId'];

        $teeModel = new TeeModel();
        $tee = $teeModel->findOneTee($id); 

        if ($_FILES['tee_pict']['size'] > 0 ) {
            $http->moveUploadedFile('tee_pict', '/images/tee'); 
            unlink($url.$tee['Photo']);
        } else {
            $fileName = $tee['Photo'];
        }

        $teeModel->updateTee($id, $_POST, $fileName);
        $http->redirectTo('/admin');
    }
}