<?php      

    class Payment extends RequisicaoBase {
        public string $payment_method_id; 
        public string $card_name; 
        public string $card_number; 
        public string $card_expdate_month; 
        public string $card_expdate_year; 
        public string $card_cvv; 
        public string $split; 

        public function __construct() {}
    
        public static function CartaoDeCredito( $payment_method_id, $card_name, $card_number,$card_expdate_month, $card_expdate_year, $card_cvv, $split ) {
            $instance = new self();
            $instance->payment_method_id = $payment_method_id;
            $instance->card_name = $card_name;
            $instance->card_number =  $instance->LimparFormatacao($card_number);
            $instance->card_expdate_month = $card_expdate_month;
            $instance->card_expdate_year = $card_expdate_year;
            $instance->card_cvv = $card_cvv;  
            $instance->split = $split;  
            return $instance;
        }
    
        public static function Pix( $payment_method_id, $split) {
            $instance = new self();
            $instance->payment_method_id = $payment_method_id;
            $instance->split = $split; 
            return $instance;
        }

        public static function Boleto( $payment_method_id) {
            $instance = new self();
            $instance->payment_method_id = $payment_method_id;         
            return $instance;
        }

        
    }
?>