function clicou()
{
    window.alert("Ei, você clicou !!!");
}


var buttonCartao = document.getElementById("btn-cartao");
buttonCartao.addEventListener("click", function(event){    
    event.preventDefault();
    setHideClass();
   
})

var buttonDoisCartoes = document.getElementById("btn-doisCartoes");
buttonDoisCartoes.addEventListener("click", function(event){  
    event.preventDefault() ;
    setHideClass('cont-doisCartoes');
  
})

var buttonBoleto = document.getElementById("btn-boleto");
buttonBoleto.addEventListener("click", function(event){    
    event.preventDefault();
    setHideClass('cont-boleto');
 
})

var buttonPix = document.getElementById("btn-pix");
buttonPix.addEventListener("click", function(event){  
    event.preventDefault();  
    setHideClass('cont-pix');
   
})

function setHideClass(container){

    var containerCartao = document.getElementById("cont-cartao");
    var containerdoisCartoes = document.getElementById("cont-doisCartoes");
    var containerBoleto = document.getElementById("cont-boleto");
    var containerPix = document.getElementById("cont-pix");

   
    switch (container) {
    case 'cont-pix':
        containerPix.classList.replace('hide', 'show');
        containerCartao.classList.replace('show', 'hide');
        containerdoisCartoes.classList.replace('show', 'hide');
        containerBoleto.classList.replace('show', 'hide');        
        break;
    case 'cont-doisCartoes':
        containerdoisCartoes.classList.replace('hide', 'show');
        containerCartao.classList.replace('show', 'hide');        
        containerBoleto.classList.replace('show', 'hide');
        containerPix.classList.replace('show', 'hide');
        break;
    case 'cont-boleto':
        containerBoleto.classList.replace('hide', 'show');
        containerCartao.classList.replace('show', 'hide');
        containerdoisCartoes.classList.replace('show', 'hide');     
        containerPix.classList.replace('show', 'hide');
        break;
    default:
        containerCartao.classList.replace('hide', 'show');
        containerdoisCartoes.classList.replace('show', 'hide');
        containerBoleto.classList.replace('show', 'hide');
        containerPix.classList.replace('show', 'hide');
        break;
    }  
}


//Cartao

function loadParcelas(){
    var selectParcelas = document.getElementById("cartao-parcela")

    for(i = 1; i <= 12; i++)
    {
        
        var opt = document.createElement("option");
        opt.value= i;
        opt.innerHTML = calcularPagamento(300, i)

        // then append it to the select element
        selectParcelas.appendChild(opt);
    }

}

function calcularPagamento(valor, parcela) {

    //Tem que pensar na taxa do cartao
    if(parcela === 1) return 'R$ ' + valor.toFixed(2);

    var valorParcela = parseFloat(valor) / Number(parcela);  

    return parcela + ' X de R$ ' + valorParcela.toFixed(2);
}

const resposta = document.getElementById("resposta")
const form = document.getElementById("form-formapag")
form.addEventListener("submit", async event => {

    event.preventDefault();
    const formData = new FormData(form);

    const dados = await fetch('https://dev.doitright.com.br/checkout/pay.php', {
        method:'POST',
        mode:'cors',
        body: formData,
    })
    .then(response => response.json())
    .then(application => {
        resposta.value = application
       console.log(application)
    })    
 
     
  
   
})