<?php

class RegisterController {
    
    public function httpGetMethod(Http $http, array $queryFields) {
/*  Méthode appelée en cas de requête HTTP GET
    	L'argument $http est un objet permettant de faire des redirections etc.
    	L'argument $queryFields contient l'équivalent de $_GET en PHP natif.   */
    }

    public function httpPostMethod(Http $http, array $formFields) {
        //var_dump($_POST);

        $userModel = new UserModel();
        $userModel->signUp(
                        $_POST['firstname'],
                        $_POST['lastname'],
                        $_POST['email'],
                        $_POST['password'],
                        $_POST['address'],
                        $_POST['city'],
                        $_POST['zip']
                    );

        $http->redirectTo('/');
/*  Méthode appelée en cas de requête HTTP POST
    	L'argument $http est un objet permettant de faire des redirections etc.
    	L'argument $formFields contient l'équivalent de $_POST en PHP natif.   */
    }
}