<?php

    class Contacts {
        public $type_contact; //String
        public $number_contact; //String   
    

        function __construct($type_contact, $number_contact){
            $this->type_contact = $type_contact;
            $this->number_contact = $number_contact;
        }

    }

?>