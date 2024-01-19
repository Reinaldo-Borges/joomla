<?php
    class RequisicaoBase{

        protected function LimparFormatacao($campoFormatado){
            return preg_replace('/[^0-9]/', '', $campoFormatado);
        }
    }