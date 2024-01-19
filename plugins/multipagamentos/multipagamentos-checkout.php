<?php

    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Origin: *");    
    
    require('classes/requisicao/requisicao-base.php'); 
    require('classes/requisicao/contacts.php');    
    require('classes/requisicao/addresses.php');
    require('classes/requisicao/customer.php');
    require('classes/requisicao/payment.php');
    require('classes/requisicao/transaction-product.php');
    require('classes/requisicao/transaction.php');
    require('classes/requisicao/transaction-trace.php');    
    require('classes/requisicao/application.php');   
    require('classes/resposta/response.php');    
    require('classes/resposta/message-response.php');  

    require('enum/metodopagamento-enum.php'); 

    require('multipagamentos-vindi.php');
    require('funcoes/validador.php');   

    $nomeCliente = $_POST['nome'];
    $email = $_POST['email'];
    $emailConfirmacao = $_POST['email-confirmacao'];
    $cpf = $_POST['cpf'];
    $celular = $_POST['celular'];
    $cartaoNome = $_POST['cartao-nome'];
    $cartaoNumero = $_POST['cartao-numero'];
    $cartaoMes = $_POST['cartao-mes'];
    $cartaoAno = $_POST['cartao-ano'];
    $cartaoCvv = $_POST['cartao-cvv'];
    $split = $_POST['cartao-parcela'];
    $flagSalvaDados = $_POST['flagSalvaDados'];

    $metodoPagamento = $_POST['metodoPagamento'];

    if(validar()) return;

    $contatoCliente = new Contacts('Celular', $celular);
    $enderecoCliente = new Addresses("B", "17000-000","Av Esmeralda","101","A","Jd Esmeralda","Marilia","SP"); 
    $cliente = new Customer([$contatoCliente], [$enderecoCliente], $nomeCliente, "21/05/1941", $cpf, $email);  
    $payment = paymentBuilder($metodoPagamento);
    $produto = new Transaction_Product("Camiseta Tony Stark", "1", "130.00", "1", "0001", "There's not extra information"); 
    $transacao = transactionBuilder($metodoPagamento);
    $dataTransacao = new Transaction_trace("03/11/2023"); 
    $application = new Application("3da8a93deb29cd8", $cliente, [$produto], $transacao, $dataTransacao, $payment);
 
    $servico = new MultiPagamentosVindi;
    $servico->efetuarVenda($application);

    function paymentBuilder($metodoPagamento){

        switch ($metodoPagamento) {
            case 3:
                return Payment::CartaoDeCredito(MetodoPagamento::CartaoDeCredito, $GLOBALS["cartaoNome"], $GLOBALS["cartaoNumero"], $GLOBALS["cartaoMes"], $GLOBALS["cartaoAno"], $GLOBALS["cartaoCvv"], $GLOBALS["split"]);                
            case 27:
                return Payment::Pix(MetodoPagamento::Pix, 1);   
            case 6:
                return Payment::Boleto(MetodoPagamento::Boleto);             
            default:
               echo "Método de pagamento indisponível!";
        }
    }

    function transactionBuilder($metodoPagamento){
        switch ($metodoPagamento) {
            case 3:
            case 6:
                return Transaction::CartaoDeCredito("2,3,4,5,6,7,14,15,16,18,19,21,22,23", "", "Sedex", "12", "", "http://www.loja.com.br/notificacao", "Good");                
            case 27:
                return Transaction::Pix("Sedex", "12", "", "http://www.loja.com.br/notificacao", "Good");   
            default:
               echo "Método de pagamento indisponível!";
        }
    }

    function validar(){
        $error = "";
        $isError = false;
        
        if(!validaCPF($GLOBALS['cpf'])){
           $error = " - O CPF e invalido!";    
           $isError = true;                   
        }
        if(!validaEmail($GLOBALS['email'])){
            $error = $error." - O EMAIL e invalido!";    
            $isError = true;  
        }
        if(!validaCartao($GLOBALS['cartaoNumero'])){
            $error = $error." - O numero do cartao e invalido!";    
            $isError = true;  
        }
   
        if($isError){
            $response  = new Response($error);         
            echo json_encode($response);  
        }

        return $isError;
    }   

?>