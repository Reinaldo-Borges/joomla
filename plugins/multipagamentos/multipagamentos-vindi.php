<?php 

    defined('_JEXEC') or die;

    class MultiPagamentosVindi{

        public function efetuarVenda($dados_da_compra){

            $payload = json_encode($dados_da_compra); 

            $url = "https://api.intermediador.sandbox.yapay.com.br/api/v3/transactions/payment";        
            
            $ch = curl_init();    
            curl_setopt($ch, CURLOPT_URL, $url);   
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
           
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);   
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                        array('Content-Type:application/json',
                              'Content-Length: ' . strlen($payload))
                        );
            
            $resposta = curl_exec($ch);
        
            if($erro = curl_error($ch)){
                echo $erro;
                return;
            }
        
            $retorno = json_decode($resposta, true);   
            curl_close($ch); 
            echo json_encode($retorno);  
        }       
    }