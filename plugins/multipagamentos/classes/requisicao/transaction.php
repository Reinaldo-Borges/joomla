<?php   

    class Transaction {
        public $available_payment_methods; //String
        public $customer_ip; //String
        public $shipping_type; //String
        public $shipping_price; //String
        public $price_discount; //String
        public $url_notification; //String
        public $free; //String

        function __construct(){                       
        }
        
        private function Default($available_payment_methods, $customer_ip, $shipping_type, $shipping_price, $price_discount, $url_notification, $free){
            $instance = new self();
            $instance->available_payment_methods = $available_payment_methods;
            $instance->customer_ip = $customer_ip;
            $instance->shipping_type = $shipping_type;
            $instance->shipping_price = $shipping_price;
            $instance->price_discount = $price_discount;
            $instance->url_notification = $url_notification;
            $instance->free = $free;   
            return  $instance;          
        }

        public static function CartaoDeCredito($available_payment_methods, $customer_ip, $shipping_type, $shipping_price, $price_discount, $url_notification, $free){
            $instance = self::Default($available_payment_methods, $customer_ip, $shipping_type, $shipping_price, $price_discount, $url_notification, $free);
          
            return  $instance;          
        }

        public static function Boleto($available_payment_methods, $customer_ip, $shipping_type, $shipping_price, $price_discount, $url_notification, $free){
            $instance = self::Default($available_payment_methods, $customer_ip, $shipping_type, $shipping_price, $price_discount, $url_notification, $free);
          
            return  $instance;          
        }

        public static function Pix($shipping_type, $shipping_price, $price_discount, $url_notification, $free){
            $instance = new self();        
            $instance->shipping_type = $shipping_type;
            $instance->shipping_price = $shipping_price;
            $instance->price_discount = $price_discount;
            $instance->url_notification = $url_notification;  
            $instance->free = $free;   
            return  $instance;          
        }
    }
?>


