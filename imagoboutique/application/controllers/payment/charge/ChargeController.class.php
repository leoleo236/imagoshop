<?php

class ChargeController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
   
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
        
        $orders =  json_decode($_POST['orders']);
        $totalAmount = 0;
        $teeModel = new TeeModel();

        foreach($orders as $order) 
        {
            $tee = $teeModel->findOneTee($order->teeId);
            $order->safePrice = $tee['SalePrice'];
            $totalAmount += ($order->safePrice*$order->quantity);
        }

        require_once('vendor/autoload.php');

        \Stripe\Stripe::setApiKey('sk_test_WvJOfwZp9WEwNygwuHXgiwLX
        ');

        $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

        $email = $_SESSION['user']['email'];
        $token = $_POST['stripeToken'];
        //var_dump($totalAmount);

        try {
            $customer = \Stripe\Customer::create(array(
                "email" => $email,
                "source" => $token
            ));

            $charge = \Stripe\Charge::create(array(
                "amount" => $totalAmount*100,
                "currency" => 'eur',
                "description" => 'mon site',
                "customer" => $customer->id
            ));

            $orderModel = new OrderModel();

            $orderModel->saveOrder($orders, $_SESSION['user']['id']);

            $http->redirectTo('/payment/success?id='.$_POST['stripeToken']);
        }  

        catch (Exception $error) {
            $errorMessage = "Le paiement a échoué";
            
            if($error->httpStatus == 402) {
                $errorMessage = "Votre carte a malheureusement été refusé merci de tester une autre carte";
            } 

            else {
                $errorMessage = "le paiement a échoué a malheureusement échoué, merci de tester ultérieurment"; 
            }

            return ['errorMessage' => $errorMessage];
        }   
    }
}