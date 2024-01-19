<?php 

    include("classes/resposta/payment.php");
    include("classes/resposta/customer.php");

    class Transaction {
        public string $order_number; 
        public string $free; 
        public string $transaction_id; //int
        public string $status_name; 
        public int $status_id; //int
        public $token_transaction; 
        public Payment $payment; //Payment
        public Customer $customer; //Customer
    }
?>