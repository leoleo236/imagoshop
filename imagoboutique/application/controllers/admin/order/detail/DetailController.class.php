<?php

class DetailController
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

    	$orderModel = new OrderModel();
        $orderdetails = $orderModel->getAllOrderDetail($_GET['id']);

        return ['orderdetail' => $orderdetails];
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
    /*  Méthode appelée en cas de requête HTTP POST
        
    L'argument $http est un objet permettant de faire des redirections etc.
    L'argument $formFields contient l'équivalent de $_POST en PHP natif.    */
    }
}