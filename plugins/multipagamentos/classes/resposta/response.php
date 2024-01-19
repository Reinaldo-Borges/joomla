<?php

    class Response{
        public $message_response;

        function __construct($message){
            $this->message_response = new Message_Response($message);            
        }
    }