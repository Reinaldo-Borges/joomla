<?php 
    class Payment {
        public string $price_payment; 
        public string $price_original; 
        public string $payment_response; 
        public string $payment_response_code; 
        public string $url_payment; 
        public string $qrcode_path; 
        public string $qrcode_original_path; 
        public string $tid; 
        public string $brand_tid; 
        public int $split; //int
        public int $payment_method_id; //int
        public string $payment_method_name; 
        public string $linha_digitavel; //array( undefined )
        public string $card_token; 
       
       }
?>