<?php

class DetailController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
    	if(empty($_SESSION) == true) {
            $http->redirectTo('/');
        }
        
    	$orderModel = new OrderModel();
        $orderdetails = $orderModel->getAllOrderDetail($_GET['id']);

        return ['orderdetail' => $orderdetails];
    }

    public function httpPostMethod(Http $http, array $formFields)
    {

    }
}