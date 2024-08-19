<?php
	require 'conexao.php';
	
 	session_start();
	if (isset($_SESSION['usuarioNome'])){

		// Recebe o termo de pesquisa se existir
		$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';

		// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
		if (empty($termo)):

			$conexao = conexao::getInstance();
			$sql = 'SELECT id, nome, genero, preco, descricao, tamanho, imagem, status FROM tab_camisetas';
			$stm = $conexao->prepare($sql);
			$stm->execute();
			$camisetas = $stm->fetchAll(PDO::FETCH_OBJ);

		else:

			// Executa uma consulta baseada no termo de pesquisa passado como parâmetro
			$conexao = conexao::getInstance();
			$sql = 'SELECT id, nome, genero, preco,  descricao, status, tamanho, imagem FROM tab_camisetas WHERE nome LIKE :nome OR genero LIKE :genero';
			$stm = $conexao->prepare($sql);
			$stm->bindValue(':nome', $termo.'%');
			$stm->bindValue(':genero', $termo.'%');
			$stm->execute();
			$camisetas = $stm->fetchAll(PDO::FETCH_OBJ);

		endif;


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Listagem de Camisetas</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container'>
		<fieldset>

			<!-- Cabeçalho da Listagem -->
			<legend><h1>Listagem de Camisetas</h1></legend>

			<!-- Formulário de Pesquisa -->
			<form action="" method="get" id='form-contato' class="form-horizontal col-md-10">
				<label class="col-md-2 control-label" for="termo">Pesquisar</label>
				<div class='col-md-7'>
			    	<input type="text" class="form-control" id="termo" name="termo" placeholder="Infome o Nome">
				</div>
			    <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
			    <a href='index.php' class="btn btn-primary btn-sm" >Ver Todas</a>
				<a href='administrativo.php' class="btn btn-danger btn-sm">Voltar</a>
			</form>

			<!-- Link para página de cadastro -->
			<a href='cadastro.php' class="btn btn-success pull-right">Cadastrar Camiseta</a>
			
			<div class='clearfix'></div>

			<?php if(!empty($camisetas)):?>
				

				<!-- Tabela de Camisetas -->
				<table class="table table-striped">
					<tr class='active'>
						<th>Foto</th>
						<th>Nome</th>
						<th>Preco</th>
						<th>Gênero</th>
						<th>Status</th>
						<th>Ação</th>
					</tr>
					<?php foreach($camisetas as $camiseta):?>
						<tr>
						<td><img src='fotos/<?=$camiseta->imagem ?>' height='40' width='40'></td>
							<td><?=$camiseta->nome ?></td>
							<td><?=$camiseta->preco ?></td>
							<td><?=$camiseta->genero ?></td>
							<td><?=$camiseta->status ?></td>
							<td>
								<a href='editar.php?id=<?=$camiseta->id?>' class="btn btn-primary">Editar</a>
								<a href='javascript:void(0)' class="btn btn-danger link_exclusao" rel="<?=$camiseta->id?>">Excluir</a>
							</td>
						</tr>	
					<?php endforeach;?>
				</table>

			<?php else: ?>

				<!-- Mensagem caso não exista camisetas ou não encontrado  -->
				<h3 class="text-center text-primary">Não existem camisetas cadastradas!</h3>
			<?php endif; ?>
		</fieldset>
	</div>
	
	<script type="text/javascript" src="js/custom.js"></script>
	
</body>
</html>

<?php
	} else
		header("Location: login.php");
?>