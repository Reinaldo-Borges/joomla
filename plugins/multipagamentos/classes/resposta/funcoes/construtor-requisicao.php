<?php
   
    include('classes/requisicao/application.php');

    class Construtor{

        function ConstrutirRequisicao($customer, $transaction_product, $transaction, $transaction_trace, $payment){ 
            
            $application = new Application;
            $application->token_account = '3da8a93deb29cd8';
            $application->customer = $customer;       
            $application->transaction_product = $transaction_product;
            $application->transaction = $transaction;
            $application->transaction_trace = $transaction_trace;
            $application->payment = $payment;
    
            return $application;
        }
    }


?>