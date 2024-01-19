<?php

    function validaCPF($cpf) {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
    
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;    
    }

    function validaEmail($email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            return false;

        return true;       
    }

    function validaCartao($numeroCartao)
    {
        $numeroCartao = preg_replace( '/[^0-9]/is', '', $numeroCartao );

        $number = substr($numeroCartao, 0, -1);
        $doubles = [];

        for ($i = 0, $t = strlen($number); $i < $t; ++$i) {
            $doubles[] = substr($number, $i, 1) * ($i % 2 == 0? 2: 1);
        }

        $sum = 0;

        foreach ($doubles as $double) {
            for ($i = 0, $t = strlen($double); $i < $t; ++$i) {
                $sum += (int) substr($double, $i, 1);
            }
        }

        return substr($numeroCartao, -1, 1) == (10-$sum%10)%10;
    }

    