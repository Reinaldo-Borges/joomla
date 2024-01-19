<?php

    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Origin: *");    
    
    include('classes/requisicao/customer.php');
    include('classes/requisicao/contacts.php');
    include('classes/requisicao/payment.php');
    include('classes/requisicao/transaction-product.php');
    include('classes/requisicao/transaction.php');
    include('classes/requisicao/transaction-trace.php');
    include('classes/requisicao/addresses.php');
    include('classes/requisicao/application.php');

    include('servicos/autorizacao-servico.php');

    include('funcoes/construtor.php');

   

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

    $contatoCliente = new Contacts;
    $contatoCliente->number_contact = '132132131231';
    $contatoCliente->type_contact = 'Celular';

    $enderecoCliente = new Addresses;
    $enderecoCliente->type_address = "B";
    $enderecoCliente->postal_code = "17000-000";
    $enderecoCliente->street = "Av Esmeralda";
    $enderecoCliente->number = "101";
    $enderecoCliente->completion = "A";
    $enderecoCliente->neighborhood = "Jd Esmeralda";
    $enderecoCliente->city = "Marilia";
    $enderecoCliente->state = "SP";


    $cliente = new Customer;
    $cliente->name = "STEPHEN STRANGE"; //$nomeCliente;
    $cliente->email = "stephen.strange@avengers.com"; //$email;
    $cliente->cpf = "50235335142"; //$cpf;
    $cliente->contacts = [$contatoCliente];
    $cliente->addresses = [$enderecoCliente];
    $cliente->birth_date = "21/05/1941";


    $payment = new Payment;
    $payment->payment_method_id = 3;
    $payment->card_name = "STEPHEN STRANGE";// $cartaoNome;
    $payment->card_number = "4111111111111111"; //$cartaoNumero;
    $payment->card_expdate_month = "1"; //$cartaoMes;
    $payment->card_expdate_year = "2024"; //$cartaoAno;
    $payment->card_cvv = "644"; //$cartaoCvv;  
    $payment->split = "1"; //$split; 

    $produto = new Transaction_Product;
    $produto->description = "Camiseta Tony Stark";
    $produto->quantity = "1";
    $produto->price_unit = "130.00";
    $produto->code = "1";
    $produto->sku_code = "0001";
    $produto->extra= "There's not extra information";

    $transacao = new Transaction;
    $transacao->available_payment_methods = "2,3,4,5,6,7,14,15,16,18,19,21,22,23";
    $transacao->customer_ip = "";
    $transacao->shipping_type = "Sedex";
    $transacao->shipping_price = "12";
    $transacao->price_discount = "";
    $transacao->url_notification = "http://www.loja.com.br/notificacao";
    $transacao->free = "Good";

    $dataTransacao = new Transaction_trace();
    $dataTransacao->estimated_date = "03/11/2023";  
  

    //$construtor = new Construtor;

    $application = new Application;
    $application->token_account = '3da8a93deb29cd8';
    $application->customer = $cliente;       
    $application->transaction_product = [$produto];
    $application->transaction = $transacao;
    $application->transaction_trace = $dataTransacao;
    $application->payment = $payment;
  

    //$application = $construtor->ConstrutirRequisicao($client, $produto, $transacao, $dataTransacao, $cartao);  
    echo json_encode($application);
    
    $url = "https://api.intermediador.sandbox.yapay.com.br/api/v3/transactions/payment";
    
    $ch = curl_init();    
    curl_setopt($ch, CURLOPT_URL, $url);   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($application));   
    
    $resposta = curl_exec($ch);

    if($erro = curl_error($ch)){
        echo $erro;
        return;
    }

    $retorno = json_decode($resposta, true);
    //print_r($retorno);
    curl_close($ch); 
    echo json_encode($retorno);

    //solicitarAprovacao($application);

    // function salvarDadosCompra($client, $cartao){
    // }

    // function solicitarAprovacao($application){  
    //     $servico = new AutorizacaoServico;
    //     $resposta = $servico->RequisicaoTeste($application);

    //     echo json_encode($resposta);
    // } 


?>