/* Atribui ao evento submit do formulário a função de validação de dados */
var form = document.getElementById("form-contato");
if (form != null && form.addEventListener) {                   
    form.addEventListener("submit", validaCadastro);
} else if (form != null && form.attachEvent) {                  
    form.attachEvent("onsubmit", validaCadastro);
}

/* Atribui ao evento keypress do input telefone a função para formatar o Telefone (00 0000-0000)*/ 
var inputPreco = document.getElementById("preco");
if (inputPreco != null && inputPreco.addEventListener) {                   
    inputPreco.addEventListener("keypress", function(){mascaraTexto(this, '###.##')});
} else if (inputPreco != null && inputPreco.attachEvent) {                  
    inputPreco.attachEvent("onkeypress", function(){mascaraTexto(this, '###.##')}); 
}

/* Atribui ao evento change do input FILE para upload da foto*/
var inputFile = document.getElementById("foto");
var foto_camiseta = document.getElementById("foto-camiseta");
if (inputFile != null && inputFile.addEventListener) {                   
    inputFile.addEventListener("change", function(){loadFoto(this, foto_camiseta)});
} else if (inputFile != null && inputFile.attachEvent) {                  
    inputFile.attachEvent("onchange", function(){loadFoto(this, foto_camiseta)});
}

/* Atribui ao evento click do link de exclusão na página de consulta a função confirmaExclusao */
var linkExclusao = document.querySelectorAll(".link_exclusao");
if (linkExclusao != null) { 
	for ( var i = 0; i < linkExclusao.length; i++ ) {
		(function(i){
			var id_camiseta = linkExclusao[i].getAttribute('rel');

			if (linkExclusao[i].addEventListener){
		    	linkExclusao[i].addEventListener("click", function(){confirmaExclusao(id_camiseta);});
			}else if (linkExclusao[i].attachEvent) { 
				linkExclusao[i].attachEvent("onclick", function(){confirmaExclusao(id_camiseta);});
			}
		})(i);
	}
}

/* Função para validar os dados antes da submissão dos dados */
function validaCadastro(evt){
	var nome = document.getElementById('nome');
	var email = document.getElementById('descricao');
	var genero = document.getElementById('genero');
	var status = document.getElementById('status');
	var preco = document.getElementById('preco');
	var tamanho  = document.getElementById('tamanho');
	var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	var contErro = 0;


	/*Validação do campo nome*/
	caixa_nome = document.querySelector('.msg-nome');
	if(nome.value == ""){
		caixa_nome.innerHTML = "Favor preencher o Nome";
		caixa_nome.style.display = 'block';
		contErro += 1;
	}else{
		caixa_nome.style.display = 'none';
	}

	/* Validação do campo descrição */
	caixa_desc = document.querySelector('.msg-desc');
	if(descricao.value == ""){
		caixa_desc.innerHTML = "Favor preencher a Descrição";
		caixa_desc.style.display = 'block';
		contErro += 1;
	}else if(filtro.test(email.value)){
		caixa_desc.style.display = 'none';
	}else{
		caixa_desc.innerHTML = "Formato da Descrição";
		caixa_desc.style.display = 'block';
		contErro += 1;
	}	

	/* Validação do campo gênero */
	caixa_gen = document.querySelector('.msg-gen');
	if(genero.value == ""){
		caixa_gen.innerHTML = "Favor preencher o Gênero";
		caixa_gen.style.display = 'block';
		contErro += 1;
	}else{
		caixa_gen.style.display = 'none';
	}

	/* Validação do campo cpf */
	caixa_preco = document.querySelector('.msg-preco');
	if(preco.value == ""){
		caixa_preco.innerHTML = "Favor preencher o preço";
		caixa_preco.style.display = 'block';
		contErro += 1;
	}else{
		caixa_preco.style.display = 'none';
	}

	/* Validação do campo telefone */
	caixa_tamanho = document.querySelector('.msg-tamanho');
	if(tamanho.value == ""){
		caixa_tamanho.innerHTML = "Favor preencher o Tamanho";
		caixa_tamanho.style.display = 'block';
		contErro += 1;
	}else{
		caixa_tamanho.style.display = 'none';
	}

	/* Validação do campo status */
	caixa_status = document.querySelector('.msg-status');
	if(status.value == ""){
		caixa_status.innerHTML = "Favor preencher o Status";
		caixa_status.style.display = 'block';
		contErro += 1;
	}else{
		caixa_status.style.display = 'none';
	}

	if(contErro > 0){
		evt.preventDefault();
	}
}

/* Função para formatar dados conforme parâmetro enviado, CPF, DATA, TELEFONE e CELULAR */
function mascaraTexto(t, mask){
	var i = t.value.length;
	var saida = mask.substring(1,0);
	var texto = mask.substring(i);

	if (texto.substring(0,1) != saida){
		t.value += texto.substring(0,1);
	}
}

/* Função para exibir a imagem selecionada no input file na tag <img>  */
function loadFoto(file, img){
    if (file.files && file.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
           img.src = e.target.result;
        }
        reader.readAsDataURL(file.files[0]);
    }
}

/* Função para exibir um alert confirmando a exclusão do registro*/
function confirmaExclusao(id){
	retorno = confirm("Deseja excluir esse Registro?")

	if (retorno){

	    //Cria um formulário
	    var formulario = document.createElement("form");
	    formulario.action = "action_camiseta.php";
	    formulario.method = "post";

		// Cria os inputs e adiciona ao formulário
	    var inputAcao = document.createElement("input");
	    inputAcao.type = "hidden";
	    inputAcao.value = "excluir";
	    inputAcao.name = "acao";
	    formulario.appendChild(inputAcao); 

	    var inputId = document.createElement("input");
	    inputId.type = "hidden";
	    inputId.value = id;
	    inputId.name = "id";
	    formulario.appendChild(inputId);

	    //Adiciona o formulário ao corpo do documento
	    document.body.appendChild(formulario);

	    //Envia o formulário
	    formulario.submit();
	}
}
