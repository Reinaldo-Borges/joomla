<?php     

    class Customer extends RequisicaoBase {
        public $contacts; //array( Contacts )
        public $addresses; //array( Addresses )
        public $name; //String
        public $birth_date; //String
        public $cpf; //String
        public $email; //String    

        function __construct($contacts, $addresses, $name,$birth_date, $cpf, $email){
            $this->contacts = $contacts;
            $this->addresses = $addresses;
            $this->name = $name;
            $this->birth_date = $birth_date;
            $this->cpf = $this->LimparFormatacao($cpf);
            $this->email = $email;          
        }
   }

?>


