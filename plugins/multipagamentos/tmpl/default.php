  
<?php   


    include_once __DIR__ .'/payment-header.php';
    echo "<link rel='stylesheet' type='text/css' href='../media/style.css'>";
?>

<?php 

    $cartId = htmlspecialchars($_GET["cartid"]); 
    $userId = htmlspecialchars($_GET["userId"]); 
     
    function calcularPagamento(float $valor, int $parcela) {   
        //Tem que pensar na taxa do cartao
        
        if($parcela === 1) return "R$ ".sprintf("%0.2f", $valor); 
    
        $valorParcela = $valor / $parcela;  

    
        return sprintf("%dX de R$ %0.2f", $parcela, $valorParcela); 
    }

    function removerFormatacaoNumero(string $strNumero )
    {
        $strNumero = trim(substr_replace(strip_tags($strNumero), "", 0, 10));

        $vetVirgula = explode( ",", $strNumero );
        if ( count( $vetVirgula ) == 1 )
        {
            $acentos = array(".");
            $resultado = str_replace( $acentos, "", $strNumero );
            return $resultado;
        }
        else if ( count( $vetVirgula ) != 2 )
        {
            return $strNumero;
        }
    
        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );
    
        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
        $resultado = $resultado . "." . $strDecimal;
    
        return $resultado;
    
    }
    
    $mostaSegundoEmail = $userId == 0 ? true : false;   
?>

     <div class='container'>
            <form action='' id='form-formapag'>
             
                    <label> 
                        <span>Nome Completo</span>
                        <input type='text' autocomplete='off' value="<?php echo strtoupper($nomeCompleto); ?>" name='nome' id='nome'> 
                    </label> 
                    <label> 
                        <span>Email</span>
                        <input type='email' autocomplete='off' value="<?php echo strtoupper($current_user->user_email); ?>" name='email' id='email'/> 
                    </label>    
                    <?php if ($mostaSegundoEmail) { ?>
                        <label > 
                            <span>Email Confirmacao</span> 
                            <input type='email' autocomplete='off' value="<?php echo strtoupper($current_user->user_email); ?>" name='email-confirmacao' id='email-confirmacao'/> 
                        </label> 
                    <?php } ?> 
                    <label>
                        <span>CPF</span>
                        <input type='text' maxlength='14' value='502.353.351-42' name ='cpf' id='cpf' onkeydown='javascript: fMasc( this, mCPF );'>
                    </label>                  
              
                    <label>  
                        <span>Celular com DDD</span>
                        <input type='text' maxlength='14' value='(21)97909-1234' name='celular' id='celular' onkeydown='javascript: fMasc( this, mTel );'>
                    </label>  

                    <div>
                        <button class='btn' id='btn-cartao'>Cartao</button>
                        <button class='btn' id='btn-doisCartoes'>2 Cartoes</button>
                        <button class='btn' id='btn-boleto'>Boleto</button>
                        <button class='btn' id='btn-pix'>Pix</button>
                    </div>
                    <div class='checkout-bg'>
                        <div class='show' id='cont-cartao'> 
                            <label> 
                                <span>Nome no Cartao</span>
                                <input type='text' autocomplete='off' value='STEPHEN STRANGE' name='cartao-nome' id='cartao-nome'> 
                            </label> 
                            <label> 
                                <span>Numero do Cartao</span>
                                <input type='text' maxlength='19' autocomplete='off' value='4111 1111 1111 1111' name='cartao-numero' id='cartao-numero' onkeydown='javascript: fMasc( this, mCC );'> 
                            </label> 
                           
                            <div class='dados-cartao'>
                                <label> 
                                    <span>Mes</span>
                                    <select class='imobBoxTipo imobBoxTipoValor' name='cartao-mes' id='cartao-mes'>
                                        <option value='1'>01</option>
                                        <option value='2'>02</option>
                                        <option value='3'>03</option>
                                        <option value='4'>04</option>
                                        <option value='5'>05</option>
                                        <option value='6'>06</option>
                                        <option value='7'>07</option>
                                        <option value='8'>08</option>
                                        <option value='9'>09</option>
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                    </select>
                                </label> 
                            </div>
                            <div class='dados-cartao'>
                                <label> 
                                    <span>Ano</span>
                                    <select class='imobBoxTipo imobBoxTipoValor' name='cartao-ano' id='cartao-ano'>                                        
                                        <?php 
                                          $anoCorrente = date("Y");
                                          for($i = 0; $i <= 10; $i++)
                                          {   
                                        ?> 
                                    <option value="<?php echo $anoCorrente + $i?>"> <?php echo $anoCorrente + $i ?> </option>
                                    <?php }?>
                                </select>
                                </label> 
                            </div>
                            <div class='dados-cartao'>

                                <label> 
                                    <span>CVV</span>
                                    <input type='text' value='644' maxlength='3'  name='cartao-cvv' id='cartao-cvv' 
                                    onkeydown='javascript: fMasc(this, mNum);'> 
                                </label>                            
                            </div>
                           
                            <label class='parcelas'> 
                                <span>Parcelas</span>
                                <select class='select-parcelas' name='cartao-parcela' id='cartao-parcela'>
                                    <?php 
                                          for($i = 1; $i <= 12; $i++)
                                          {   
                                    ?> 
                                    <option value="<?php echo $i?>"> <?php echo calcularPagamento($total, $i) ?> </option>
                                    <?php }?>
                                </select>
                            </label> 

                            <ul class='tg-list'>                                  
                                <li class='tg-list-item'>
                                    <input class='tgl tgl-ios' name='flagSalvaDados' id='flagSalvaDados' type='checkbox'/>
                                    <label class='tgl-btn' for='flagSalvaDados'></label>
                                    <h4>Deseja salvar os dados para uma proxima compra?</h4>                                    
                                </li>                                
                            </ul>

                        </div>

                        <div class='hide' id='cont-doisCartoes'><span>Dois Cartoes</span></div>
                        <div class='hide'id='cont-boleto'><span>Boleto</span></div>
                        <div class='hide' id='cont-pix'><span>Pix</span></div>
                    </div>   
                    <div>
                        <button type='submit' class='btn-pagar' id='btn-cartao'>Pagar Agora</button>
                    </div>      
                    <div>
                        <span id='texto-aprovado' style='font-size: 40px; color: darkcyan;font-weight: bold; text-align: center;'></span> 
                        <span id='texto-reprovado' style='font-size: 40px; color: rgb(236, 21, 75);font-weight: bold; text-align: center;'></span> 
                    </div>                      
                </div>
            </form>
          
        </div>  



<?php
    include_once __DIR__ .'/payment-footer.php';
?>


