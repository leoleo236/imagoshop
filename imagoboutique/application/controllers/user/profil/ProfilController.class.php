<?php

class ProfilController
{
    public function httpGetMethod(Http $http, array $queryFields) {
        if(empty($_SESSION) == true) {
            $http->redirectTo('/user/login');
        }

    	$userModel = new UserModel();
        $user = $userModel->findOneUser($_SESSION['user']['id']);

        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrders();

        return [
            "user"=>$user,
            "orders"=>$orders
        ];
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
    	var_dump($_POST);

        $userModel = new UserModel();
        $userModel->changeUserProfil($_POST, $_SESSION['user']['id']);

        $http->redirectTo('/user/profil');
    }
}