<?php
	session_start();

	require 'conexao.php';

	// Atribui uma conexão PDO
	$conexao = conexao::getInstance();
	
	$email  = (isset($_POST['email'])) ? $_POST['email'] : '';
	$senha  = (isset($_POST['senha'])) ? $_POST['senha'] : '';

	
		$conexao = conexao::getInstance();
		$sql = "SELECT * FROM usuarios WHERE email = '$email' && senha = '$senha' LIMIT 1";
		$stm = $conexao->prepare($sql);
		$stm->execute();
		$usuario = $stm->fetch(PDO::FETCH_OBJ);
	

    if(empty($usuario)){
		$_SESSION['loginErro'] = "Usuário ou senha inválido";
		header("Location: login.php");
	}elseif(isset($usuario)){
		$_SESSION['usuarioId'] = $usuario->id;
		$_SESSION['usuarioNome'] = $usuario->nome;
		$_SESSION['usuarioNiveisAcessoId'] = $usuario->niveis_acesso_id;
		$_SESSION['usuarioEmail'] = $usuario->email;
		$_SESSION['usuarioSenha'] = $usuario->senha;
        header("Location: administrativo.php");
	}else{
		$_SESSION['loginErro'] = "Usuário ou senha inválido";
		header("Location: lista_camisetas.php");
	}


?>

