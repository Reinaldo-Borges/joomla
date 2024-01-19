<?php 

    include("classes/resposta/message-response.php");
    include("classes/resposta/erro/error-response.php");
    include("classes/resposta/erro/additional-data.php");

    class Application {
        public Message_Response $message_response; //Message_response
        public Error_Response $error_response; //Error_response
        public Additional_Data $additional_data; //Additional_data    
    }
?>