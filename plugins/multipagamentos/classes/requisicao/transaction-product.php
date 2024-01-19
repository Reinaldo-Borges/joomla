<?php

    class Transaction_Product {
        public $description; //String
        public $quantity; //String
        public $price_unit; //String
        public $code; //String
        public $sku_code; //String
        public $extra; //String   

        function __construct($description, $quantity, $price_unit,$code, $sku_code, $extra){
            $this->description = $description;
            $this->quantity = $quantity;
            $this->price_unit = $price_unit;
            $this->code = $code;
            $this->sku_code = $sku_code;
            $this->extra = $extra;             
        }
   }

?>