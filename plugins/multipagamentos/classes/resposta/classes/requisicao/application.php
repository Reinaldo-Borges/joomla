<?php

     include('classes/requisicao/customer.php');
     include('classes/requisicao/payment.php');
     include('classes/requisicao/transaction-product.php');
     include('classes/requisicao/transaction.php');
     include('classes/requisicao/transaction-trace.php');  

     include("classes/resposta/message-response.php");
    include("classes/resposta/data-response.php");

   
    include("classes/resposta/erro/error-response.php");
    include("classes/resposta/erro/additional-data.php");

    class Application {
        public string $token_account; //String
        public Customer $customer; //
        public $transaction_product; //array( Transaction_product )
        public Transaction $transaction; //Transaction
        public Transaction_trace $transaction_trace; //Transaction_trace
        public Payment $payment; //Payment   

        //response
        public Message_Response $message_response; 
        public Data_Response $data_response;   

        //error    
        public Error_Response $error_response; //Error_response
        public Additional_Data $additional_data; //Additional_data  
    }

?>