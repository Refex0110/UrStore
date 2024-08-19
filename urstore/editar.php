<?php
require 'conexao.php';

// Recebe o id da camiseta da camiseta via GET
$id_camiseta = (isset($_GET['id'])) ? $_GET['id'] : '';

// Valida se existe um id e se ele é numérico
if (!empty($id_camiseta) && is_numeric($id_camiseta)):

	// Captura os dados da camiseta solicitada
	$conexao = conexao::getInstance();
	$sql = 'SELECT id, nome, genero, descricao, preco, tamanho, status, data_upload, imagem FROM tab_camisetas WHERE id = :id';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(':id', $id_camiseta);
	$stm->execute();
	$camiseta = $stm->fetch(PDO::FETCH_OBJ);

	if(!empty($camiseta)):

		// Formata a data no formato nacional
		$array_data     = explode('-', $camiseta->data_upload);
		$data_formatada = $array_data[2] . '/' . $array_data[1] . '/' . $array_data[0];

	endif;

endif;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Edição de Camisetas</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container'>
		<fieldset>
			<legend><h1>Formulário - Edição de Camisetas</h1></legend>
			
			<?php if(empty($camiseta)):?>
				<h3 class="text-center text-danger">Camiseta não encontrada!</h3>
			<?php else: ?>
				<form action="action_camiseta.php" method="post" id='form-contato' enctype='multipart/form-data'>
					<div class="row">
						<label for="nome">Alterar Imagem</label>
				      	<div class="col-md-2">
						    <a href="#" class="thumbnail">
						      <img src="fotos/<?=$camiseta->imagem?>" height="190" width="150" id="foto-camiseta">
						    </a>
					  	</div>
					  	<input type="file" name="foto" id="foto" value="foto" >
				  	</div>

			    <div class="form-group">
			      <label for="nome">Nome</label>
			      <input type="text" class="form-control" id="nome" name="nome" placeholder="Infome o Nome" value="<?=$camiseta->nome?>">
			      <span class='msg-erro msg-nome'></span>
			    </div>

			    <div class="form-group">
			      <label for="descricao">Descrição</label>
			      <input type="text" class="form-control" id="desc" name="descricao" placeholder="Informe a Descrição" value="<?=$camiseta->descricao?>">
			      <span class='msg-erro msg-desc'></span>
			    </div>

			    <div class="form-group">
			      <label for="genero">Gênero</label>
			      <input type="genero" class="form-control" id="genero" maxlength="9" name="genero" placeholder="Informe o Gênero" value="<?=$camiseta->genero?>">
			      <span class='msg-erro msg-gen'></span>
			    </div>

			    <div class="form-group">
			      <label for="preco">Preço</label>
			      <input type="preco" class="form-control" id="preco" maxlength="12" name="preco" placeholder="Informe o Valor" value="<?=$camiseta->preco?>">
			      <span class='msg-erro msg-preco'></span>
			    </div>

			    <div class="form-group">
			      <label for="tamanho">Tamanho</label>
			      <input type="tamanho" class="form-control" id="tam" maxlength="2" name="tamanho" placeholder="Informe o Tamanho" value="<?=$camiseta->tamanho?>">
			      <span class='msg-erro msg-tamanho'></span>
			    </div>

				    <div class="form-group">
				      <label for="status">Status</label>
				      <select class="form-control" name="status" id="status">
					    <option value="<?=$camiseta->status?>"><?=$camiseta->status?></option>
					    <option value="Ativo">Ativo</option>
					    <option value="Inativo">Inativo</option>
					  </select>
					  <span class='msg-erro msg-status'></span>
				    </div>

				    <input type="hidden" name="acao" value="editar">
				    <input type="hidden" name="id" value="<?=$camiseta->id?>">
				    <input type="hidden" name="imagem_atual" value="<?=$camiseta->imagem?>">
				    <button type="submit" class="btn btn-primary" id='botao'> 
				      Gravar
				    </button>
				    <a href='index.php' class="btn btn-danger">Cancelar</a>
				</form>
			<?php endif; ?>
		</fieldset>

	</div>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>