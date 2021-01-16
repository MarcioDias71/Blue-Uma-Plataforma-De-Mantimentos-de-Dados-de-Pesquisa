<?php
include('../server.php');

if (!isset($_SESSION['email'])) {
	$_SESSION['msg'] = "Você deve fazer login primeiro";
	echo $_SESSION['msg'];
	header('location: ../login.php');
}
// conferir ids
$separaigual = explode("?", $_SERVER["REQUEST_URI"]);
$idprojeto = $separaigual[1];

$filesEdition = $db->prepare("SELECT * FROM projetos WHERE idProjeto= :idProjeto AND ID = :idUs");
$filesEdition->bindValue(':idProjeto',base64_decode($idprojeto));
$filesEdition->bindValue(':idUs',$idUsuario);
$filesEdition->execute();

foreach($filesEdition as $row){
	$idDecode = $row['idProjeto'];
	$_SESSION['nomeProjeto'] = $row['nomeProjeto'];
	$_SESSION['instituicao'] = $row['instituicao'];
	$_SESSION['dataIn'] = $row['dataProjeto'];
	$_SESSION['aplicacao'] = $row['areaAplicacao'];
	$_SESSION['resumo'] = $row['resumo'];
	$_SESSION['keyWord'] = $row['palavraChave'];
	$idU = $row['ID'];
}

if(isset($idU)){
	if($idUsuario != $idU){
		echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\");
		if(a == true){
		window.location.href = \"../index.php\";
		}else{ window.location.href = \"../index.php\"; }
		</script>";
	}
}else{
	echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\");
		if(a == true){
		window.location.href = \"../index.php\";
		}else{ window.location.href = \"../index.php\"; }
		</script>";
}



$confImg = $db->prepare("SELECT * FROM upfotos WHERE idProjeto = :idDecod ");
$confImg->bindValue(':idDecod',$idDecode);
$confImg->execute();

foreach($confImg as $rI){
	$_SESSION['nomeFoto'] = $rI['nomeFoto'];
	$_SESSION['dataImg'] = $rI['DataHora'];
}


$confDocs1 = $db->prepare("SELECT * FROM updocs WHERE idProjeto = :idDecod1 AND tipoArquivo = 'artigo'");
$confDocs1->bindValue(':idDecod1',$idDecode);
$confDocs1->execute();

foreach($confDocs1 as $rD1){
	$_SESSION['nomeArtigo'] = $rD1['nomeDoc'];
	$_SESSION['dataArtigo'] = $rD1['DataHora'];
}

$confDocs2 = $db->prepare("SELECT * FROM updocs WHERE idProjeto = :idDecod2 AND tipoArquivo = 'relatorio'");
$confDocs2->bindValue(':idDecod2',$idDecode);
$confDocs2->execute();

foreach($confDocs2 as $rD2){
	$_SESSION['nomeRelatorio'] = $rD2['nomeDoc'];
	$_SESSION['dataRelatorio'] = $rD2['DataHora'];
}

$a1=SelectAutor($idDecode,"A1", "Autor 1");
$a2=SelectAutor($idDecode,"A2", "Autor 2");
$a3=SelectAutor($idDecode,"A3", "Autor 3");
$co=SelectAutor($idDecode,"Co", "Coorientador");
$o=SelectAutor($idDecode,"O", "Orientador");


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../styles/showproj.css">
	<link rel="icon" href="../Vetores/Logo.svg">

	<title><?php if(isset($_SESSION['nomeProjeto'])){ echo $_SESSION['nomeProjeto']; }else{ echo "Blue";} ?></title>
</head>

<body>

	<header class="cabecalho">
			<div class="logotitle">

			<div class="logo">

		<figure >
			<a href="../index.php">	<img src="../Vetores/Logo.svg" width="" height="" class="d-inline-block align-top" alt="" class="img-fluid"> </a>
		</figure>
		</div>
				<div class="titlec" >

					<a href="../index.php">	<h1 class="titlec"> Blue </h1></a>
				</div>
			</div>
	</div>


	</header>

	<div class="container">
		<div class="row">
			 <div class="col-sm-12">

				 <div class="cabe">
<?php
if(isset($_SESSION['nomeFoto'])):
?>

<div>
	<figure class="figura">

		<a href="upload/imgs/<?php echo $_SESSION['nomeFoto'];  ?>" download><img src="upload/imgs/<?php echo $_SESSION['nomeFoto'];  ?>" alt="IMAGEM" ></a> <br><br>

	</figure>
</div>

<?php
else:
?>

<div>
	<figure class="figura">
		<img src="../Vetores/profile.svg" alt="img" class="">
	</figure>
</div>

<?php
endif;
?>
			 <div class="txtcabecalho ">

				 <p class = "titulo"><strong><?php echo $_SESSION['nomeProjeto'] ?></strong></p>
				<br>
				 <p><strong> Data de início do Projeto: </strong><?php echo date('d-m-Y', strtotime($_SESSION['dataIn'])); ?></p>
				 <p><strong> Instituição: </strong><?php echo $_SESSION['instituicao'] ?></p>
				 <p><strong> Aplicação: </strong><?php echo $_SESSION['aplicacao'] ?></p>
				</div>
			</div>
			</div>
			<div class="col-sm-12">

				<div class="caixaresumo">

					<div> <p><strong> Resumo: </strong><br><?php echo $_SESSION['resumo'] ?></p> </div>
					<div> <p><strong> Palavra-Chave: </strong><?php echo $_SESSION['keyWord'] ?></p> </div>
				</div>
			</div>


	<div class="col-sm-12">
		<div class="centerize">

			<?php
if(isset($_SESSION['nomeArtigo'])){

	$extensao = strtolower(substr($_SESSION['nomeArtigo'],-4));
	if($extensao == ".pdf"){ ?>

				<div class="artigo">
					<label for="art" class="">Artigo do Projeto</label>
					<embed src="upload/docs/artigo/<?php echo $_SESSION['nomeArtigo']; ?>"  id="art" type="application/pdf" width="" height=""/><br>

					<?php }
	else if($extensao == ".odt"){ ?>
		<p>Artigo: <strong><?php echo $_SESSION['nomeArtigo']; ?></strong></p>
		<?php } ?>

			<a href="upload/docs/artigo/<?php echo $_SESSION['nomeArtigo']; ?>" class=""download><img src="../Vetores/cloud.svg" alt="" width="30px" height="auto">  Dowload</a>

				</div>

	<?php
}else{
	// echo "<div class=\"centerize\"></div>";
}
?>


<?php
if(isset($_SESSION['nomeRelatorio'])){

	$extensao = strtolower(substr($_SESSION['nomeRelatorio'],-4));

	if($extensao == ".pdf"){ ?>
	<div class="relatorio">
		<label for="rel" class="">Relatório do Projeto</label>
		<embed src="upload/docs/relatorio/<?php echo $_SESSION['nomeRelatorio']; ?>" id="rel" class="" type="application/pdf" width="" height=""/>

		<?php }
	else if($extensao == ".odt"){ ?>
		<p>Relatório: <strong><?php echo $_SESSION['nomeRelatorio']; ?></strong> </p>
		<?php } ?>


			<br><a href="upload/docs/relatorio/<?php echo $_SESSION['nomeRelatorio']; ?>" class="" download> <img src="../Vetores/cloud.svg" alt="" width="30px" height="auto">  Dowload</a>


		</div>
		<?php
}else{
	// echo "<div class=\"centerize \"> </div>";
}
?>

	</div>
	</div>
<div class="autores col-sm-12">

	<h2>Autores do projeto</h2>
	<hr>
	<?php if(isset($_SESSION['nomeA1'])): ?>
		<div> <p> Nome do Autor   1: <?php echo $_SESSION['nomeA1'] ?></p> </div>
		<div> <p> Idade do Autor  1: <?php echo $_SESSION['idadeA1'] ?></p> </div>
		<div> <p> Email do Autor  1: <?php echo $_SESSION['emailA1'] ?></p> </div>
		<div> <p> Lattes do Autor 1: <?php echo $_SESSION['lattesA1'] ?></p> </div>
		<hr>
		<?php
endif;
?>
<?php if(isset($_SESSION['nomeA2'])): ?>
	<div> <p> Nome do Autor   2: <?php echo $_SESSION['nomeA2'] ?></p> </div>
	<div> <p> Idade do Autor  2: <?php echo $_SESSION['idadeA2'] ?></p> </div>
	<div> <p> Email do Autor  2: <?php echo $_SESSION['emailA2'] ?></p> </div>
	<div> <p> Lattes do Autor 2: <?php echo $_SESSION['lattesA2'] ?></p> </div>
	<hr>
	<?php endif; ?>
	<?php if(isset($_SESSION['nomeA3'])): ?>
		<div> <p> Nome do Autor   3: <?php echo $_SESSION['nomeA3'] ?></p> </div>
		<div> <p> Idade do Autor  3: <?php echo $_SESSION['idadeA3'] ?></p> </div>
		<div> <p> Email do Autor  3: <?php echo $_SESSION['emailA3'] ?></p> </div>
		<div> <p> Lattes do Autor 3: <?php echo $_SESSION['lattesA3'] ?></p> </div>
		<hr>
		<?php endif; ?>
		<?php if(isset($_SESSION['nomeO'])): ?>
			<div> <p> Nome   do Orientador: <?php echo $_SESSION['nomeO'] ?></p> </div>
			<div> <p> Idade  do Orientador: <?php echo $_SESSION['idadeO'] ?></p> </div>
			<div> <p> Email  do Orientador: <?php echo $_SESSION['emailO'] ?></p> </div>
			<div> <p> Lattes do Orientador: <?php echo $_SESSION['lattesO'] ?></p> </div>
			<hr>
			<?php endif; ?>
			<?php if(isset($_SESSION['nomeCo'])): ?>
				<div> <p> Nome   do Coorientador: <?php echo $_SESSION['nomeCo'] ?></p> </div>
				<div> <p> Idade  do Coorientador: <?php echo $_SESSION['idadeCo'] ?></p> </div>
				<div> <p> Email  do Coorientador: <?php echo $_SESSION['emailCo'] ?></p> </div>
				<div> <p> Lattes do Coorientador: <?php echo $_SESSION['lattesCo'] ?></p> </div>
				<?php endif; ?>

				<!-- -->

			</div>

			</div>
		</div>

		<script src="../js/bootstrapjquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</body>
	</html>
