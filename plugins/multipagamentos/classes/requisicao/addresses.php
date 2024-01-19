<?php

    class Addresses {
        public $type_address; //String
        public $postal_code; //String
        public $street; //String
        public $number; //String
        public $completion; //String
        public $neighborhood; //String
        public $city; //String
        public $state; //String   

        function __construct($type_address, $postal_code, $street,$number, $completion, $neighborhood, $city, $state){
            $this->type_address = $type_address;
            $this->postal_code = $postal_code;
            $this->street = $street;
            $this->number = $number;
            $this->completion = $completion;
            $this->neighborhood = $neighborhood;
            $this->city = $city;
            $this->state = $state;
        }
   }

?>
