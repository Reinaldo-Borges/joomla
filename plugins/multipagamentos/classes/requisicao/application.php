<?php
    class Application {
        public  $token_account; //String
        public  $customer; //
        public  $transaction_product; //array( Transaction_product )
        public  $transaction; //Transaction
        public  $transaction_trace; //Transaction_trace
        public  $payment; //Payment  

        function __construct($token_account, $customer , $transaction_product , $transaction , $transaction_trace, $payment){
            $this->token_account = $token_account;
            $this->customer = $customer;
            $this->transaction_product = $transaction_product;
            $this->transaction = $transaction;
            $this->transaction_trace = $transaction_trace;
            $this->payment = $payment;    
        }   
    }
?>