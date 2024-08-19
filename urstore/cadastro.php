<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Cadastro de Camiseta</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container'>
		<fieldset>
			<legend><h1>Formulário - Cadastro de Camiseta</h1></legend>
			
			<form action="action_camiseta.php" method="post" id='form-contato' enctype='multipart/form-data'>
				<div class="row">
					<label for="nome">Selecionar Imagem</label>
			      	<div class="col-md-2">
					    <a href="#" class="thumbnail">
					      <img src="fotos/padrao.jpg" height="190" width="150" id="foto-camiseta">
					    </a>
				  	</div>
				  	<input type="file" name="foto" id="foto" value="foto" >
			  	</div>

			    <div class="form-group">
			      <label for="nome">Nome</label>
			      <input type="text" class="form-control" id="nome" name="nome" placeholder="Infome o Nome">
			      <span class='msg-erro msg-nome'></span>
			    </div>

			    <div class="form-group">
			      <label for="descricao">Descrição</label>
			      <input type="text" class="form-control" id="desc" name="descricao" placeholder="Informe a Descrição">
			      <span class='msg-erro msg-desc'></span>
			    </div>

			    <div class="form-group">
			      <label for="genero">Gênero</label>
			      <input type="genero" class="form-control" id="genero" maxlength="9" name="genero" placeholder="Informe o Gênero">
			      <span class='msg-erro msg-gen'></span>
			    </div>
				
			    <div class="form-group">
			      <label for="preco">Preço</label>
			      <input type="preco" class="form-control" id="preco" maxlength="12" name="preco" placeholder="Informe o Valor">
			      <span class='msg-erro msg-preco'></span>
			    </div>

			    <div class="form-group">
			      <label for="tamanho">Tamanho</label>
			      <input type="tamanho" class="form-control" id="tam" maxlength="2" name="tamanho" placeholder="Informe o Tamanho">
			      <span class='msg-erro msg-tamanho'></span>
			    </div>

			    <div class="form-group">
			      <label for="status">Status</label>
			      <select class="form-control" name="status" id="status">
				    <option value="">Selecione o Status</option>
				    <option value="Ativo">Ativo</option>
				    <option value="Inativo">Inativo</option>
				  </select>
				  <span class='msg-erro msg-status'></span>
			    </div>

			    <input type="hidden" name="acao" value="incluir">
			    <button type="submit" class="btn btn-primary" id='botao'> 
			      Gravar
			    </button>
			    <a href='lista_camisetas.php' class="btn btn-danger">Cancelar</a>
			</form>
		</fieldset>
	</div>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>