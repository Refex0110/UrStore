<?php
  	session_start();
	if (isset($_SESSION['usuarioNome'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Sistema de Cadastro</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container box-mensagem-crud'>
		<?php 
		require 'conexao.php';

		// Atribui uma conexão PDO
		$conexao = conexao::getInstance();

		// Recebe os dados enviados pela submissão
		$acao  = (isset($_POST['acao'])) ? $_POST['acao'] : '';
		$id    = (isset($_POST['id'])) ? $_POST['id'] : '';
		$nome  = (isset($_POST['nome'])) ? $_POST['nome'] : '';
		$descricao   = (isset($_POST['descricao'])) ? $_POST['descricao']: '';
		$genero = (isset($_POST['genero'])) ? $_POST['genero'] : '';
		$imagem_atual = (isset($_POST['imagem_atual'])) ? $_POST['imagem_atual'] : '';
		$preco = (isset($_POST['preco'])) ? $_POST['preco'] : '';
		$tamanho = (isset($_POST['tamanho'])) ? $_POST['tamanho'] : '';
		$status = (isset($_POST['status'])) ? $_POST['status'] : '';
		
		
		
		// Valida os dados recebidos
		$mensagem = '';
		if ($acao == 'editar' && $id == ''):
		    $mensagem .= '<li>ID do registros desconhecido.</li>';
	    endif;

	    // Se for ação diferente de excluir valida os dados obrigatórios
	    if ($acao != 'excluir'):
			if ($nome == '' || strlen($nome) < 3):
				$mensagem .= '<li>Favor preencher o Nome.</li>';
		    endif;

			if ($descricao == ''):
			   $mensagem .= '<li>Favor preencher a Descrição.</li>';
		    endif;

			if ($genero == ''):
				$mensagem .= '<li>Favor preencher o Gênero.</li>';
			endif;

			if ($preco == ''): 
				$mensagem .= '<li>Favor preencher o Preço.</li>';
		    endif;

			if ($tamanho == ''):
				$mensagem .= '<li>Favor preencher o Correto.</li>';		
			endif;



			if ($mensagem != ''):
				$mensagem = '<ul>' . $mensagem . '</ul>';
				echo "<div class='alert alert-danger' role='alert'>".$mensagem."</div> ";
				exit;
			endif;

		endif;	

		// Verifica se foi solicitada a inclusão de dados
		if ($acao == 'incluir'):

			$nome_imagem = 'padrao.jpg';
			if(isset($_FILES['foto']) && $_FILES['foto']['size'] > 0):  

				$extensoes_aceitas = array('bmp' ,'png', 'svg', 'jpeg', 'jpg','BMP','PNG','SVG','JPG', 'jfif');
			    $aux=explode('.', $_FILES['foto']['name']);
				$extensao =end($aux);
				//$extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));

			     // Validamos se a extensão do arquivo é aceita
			    if (array_search($extensao, $extensoes_aceitas) === false):
			       echo "<h1>Extensão Inválida!</h1>";
			       exit;
			    endif;
 
			     // Verifica se o upload foi enviado via POST   
			     if(is_uploaded_file($_FILES['foto']['tmp_name'])):  
			             
			          // Verifica se o diretório de destino existe, senão existir cria o diretório  
			          if(!file_exists("fotos")):  
			               mkdir("fotos");  
			          endif;  
			  
			          // Monta o caminho de destino com o nome do arquivo  
			          $nome_imagem = date('dmY') . '_' . $_FILES['foto']['name'];  
			            
			          // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
			          if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'.$nome_imagem)):  
			               echo "Houve um erro ao gravar arquivo na pasta de destino!";  
			          endif;  
			     endif;  
			endif;

			$sql = 'INSERT INTO tab_camisetas (nome, genero, descricao, preco, tamanho, status, imagem)
							   VALUES(:nome, :genero, :descricao, :preco, :tamanho, :status, :imagem)';

			$stm = $conexao->prepare($sql);
			$stm->bindValue(':nome', $nome);
			$stm->bindValue(':genero', $genero);
			$stm->bindValue(':descricao', $descricao);
			$stm->bindValue(':preco', $preco);
			$stm->bindValue(':tamanho', $tamanho);
			$stm->bindValue(':status', $status);
			$stm->bindValue(':imagem', $nome_imagem);
			$retorno = $stm->execute();

			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso, aguarde você está sendo redirecionado ...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='3;URL=lista_camisetas.php'>";
		endif;


		// Verifica se foi solicitada a edição de dados
		if ($acao == 'editar'):

			if(isset($_FILES['foto']) && $_FILES['foto']['size'] > 0): 

				// Verifica se a foto é diferente da padrão, se verdadeiro exclui a foto antiga da pasta
				if ($imagem_atual <> 'padrao.jpg'):
					unlink("fotos/" . $imagem_atual);
				endif;


				$extensoes_aceitas = array('bmp' ,'png', 'svg', 'jpeg', 'jpg','BMP','PNG','SVG','JPG');
			    $aux=explode('.', $_FILES['foto']['name']);
				$extensao =end($aux);
				//$extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));
				
				
				//$extensoes_aceitas = array('bmp' ,'png', 'svg', 'jpeg', 'jpg','BMP','PNG','SVG','JPG');
				//$extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));

			     // Validamos se a extensão do arquivo é aceita
			    if (array_search($extensao, $extensoes_aceitas) === false):
			       echo "<h1>Extensão Inválida!</h1>";
			       exit;
			    endif;
 
			     // Verifica se o upload foi enviado via POST   
			    if(is_uploaded_file($_FILES['foto']['tmp_name'])):  
			             
			          // Verifica se o diretório de destino existe, senão existir cria o diretório  
			          if(!file_exists("fotos")):  
			               mkdir("fotos");  
			          endif;  
			  
			          // Monta o caminho de destino com o nome do arquivo  
			          $nome_imagem = date('dmY') . '_' . $_FILES['foto']['name'];  
			            
			          // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
			          if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'.$nome_imagem)):  
			               echo "Houve um erro ao gravar arquivo na pasta de destino!";  
			          endif;  
			    endif;
			
			else:

			 	$nome_imagem = $imagem_atual;

			endif;

			$sql = 'UPDATE tab_camisetas SET nome=:nome, genero=:genero, descricao=:descricao, preco=:preco, tamanho=:tamanho, status=:status, imagem=:imagem ';
			$sql .= 'WHERE id = :id';

			$stm = $conexao->prepare($sql);
			$stm->bindValue(':nome', $nome);
			$stm->bindValue(':genero', $genero);
			$stm->bindValue(':descricao', $descricao);
			$stm->bindValue(':preco', $preco);
			$stm->bindValue(':tamanho', $tamanho);
			$stm->bindValue(':status', $status);
			$stm->bindValue(':imagem', $nome_imagem);
			$stm->bindValue(':id', $id);
			$retorno = $stm->execute();

			

			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Registro editado com sucesso, aguarde você está sendo redirecionado ...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='3;URL=lista_camisetas.php'>";
		endif;


		// Verifica se foi solicitada a exclusão dos dados
		if ($acao == 'excluir'):

			// Captura o nome da foto para excluir da pasta
			$sql = "SELECT imagem FROM tab_camisetas WHERE id = :id AND imagem <> 'padrao.jpg'";
			$stm = $conexao->prepare($sql);
			$stm->bindValue(':id', $id);
			$stm->execute();
			$camiseta = $stm->fetch(PDO::FETCH_OBJ);

			if (file_exists('fotos/' . $imagem_atual) && is_file('fotos/' . $imagem_atual)):
				unlink("fotos/" . $imagem_atual);
			endif;

			// Exclui o registro do banco de dados
			$sql = 'DELETE FROM tab_camisetas WHERE id = :id';
			$stm = $conexao->prepare($sql);
			$stm->bindValue(':id', $id);
			$retorno = $stm->execute();

			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Registro excluído com sucesso, aguarde você está sendo redirecionado ...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='3;URL=lista_camisetas.php'>";
		endif;
		?>

	</div>
</body>
</html>

<?php
	} else
		header("Location: login.php");
?>