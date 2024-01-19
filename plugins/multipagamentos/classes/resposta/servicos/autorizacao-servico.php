<?php

    include('classes/requisicao/application.php');

    class AutorizacaoServico { 
        
        public function RequisicaoTeste($application){              
            
            echo json_encode($application);
    
            $url = "https://api.intermediador.sandbox.yapay.com.br/api/v3/transactions/payment";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $application);
            
           

            $resposta = curl_exec($ch);
    
            if($erro = curl_error($ch)){
                echo $erro;
                return;
            }
    
            $retorno = json_decode($resposta, true);
            print_r($retorno);
            curl_close($ch); 
            return $retorno;                
        }
    }


?>