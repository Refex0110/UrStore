<?php
	require 'conexao.php';
	
 	$conexao = conexao::getInstance();
	$sql = 'SELECT id, nome, genero, preco, descricao, tamanho, imagem, status FROM tab_camisetas';
	$stm = $conexao->prepare($sql);
	$stm->execute();
	$camisetas = $stm->fetchAll(PDO::FETCH_OBJ);
?>
			
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue" rel="stylesheet">
    <title>Loja Urstore</title>
</head>
<header>
        <nav class="butheader">
        <img class="logo" src="imagens/logo.png" alt="">
       
         <div class="mobile-menu">
         <div class="line1"></div>
         <div class="line2"></div>
         <div class="line3"></div>
            </div>
    <ul class="nav-list">
        <li><a href="">Menus</a></li>
        <li><a href="">Catálogo</a></li>
        <li><a href="">Sobre Nós</a></li>
    </ul>

   
        </nav>
</header>
<div>
     <img class="banner"  src="imagens/banner.png" alt="Banner Inicial">
</div>

<div class="ini">
   <center> <h1 class="vitrine">✦ Conheça nossos produtos ✦</h1></center>
</div>

<div class="destq" style="margin-left: 40px">
    <h2>DESTAQUES</h2>
</div>

<div class="container">
    <?php if(!empty($camisetas)):
		foreach($camisetas as $camiseta):?>
			<div class="card"><img src='fotos/<?=$camiseta->imagem ?>' alt="">
				<h2><?=$camiseta->nome ?></h2>
				<h4><?=$camiseta->preco ?></h4>
			</div>
		<?php endforeach;
		endif;?>
</div>
<body>
</body>
</html>
