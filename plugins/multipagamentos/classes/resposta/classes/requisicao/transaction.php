<?php
    class Transaction {
        public $available_payment_methods; //String
        public $customer_ip; //String
        public $shipping_type; //String
        public $shipping_price; //String
        public $price_discount; //String
        public $url_notification; //String
        public $free; //String       

        //response
        public string $order_number;   
        public string $transaction_id; //int
        public string $status_name; 
        public int $status_id; //int
        public $token_transaction; 
        public Payment $payment; //Payment
        public Customer $customer; //Customer

    }
?>


