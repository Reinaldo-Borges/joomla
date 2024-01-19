<?php
    class Payment {
        public string $payment_method_id; 
        public string $card_name; 
        public string $card_number; 
        public string $card_expdate_month; 
        public string $card_expdate_year; 
        public string $card_cvv; 
        public string $split; 

        //response
        public string $price_payment; 
        public string $price_original; 
        public string $payment_response; 
        public string $payment_response_code; 
        public string $url_payment; 
        public string $qrcode_path; 
        public string $qrcode_original_path; 
        public string $tid; 
        public string $brand_tid;     
        public string $payment_method_name; 
        public string $linha_digitavel; //array( undefined )
        public string $card_token; 
       
    }
?>