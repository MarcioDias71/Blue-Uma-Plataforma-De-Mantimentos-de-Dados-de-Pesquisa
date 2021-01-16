<?php
include('../server.php');

if (!isset($_SESSION['email'])) {
	$_SESSION['msg'] = "Você deve fazer login primeiro";
	echo $_SESSION['msg'];
	header('location: ../login.php');
}

$separaigual = explode("?", $_SERVER["REQUEST_URI"]);
$idprojeto = $separaigual[1];

$fotoC = base64_encode("foto");
$artigoC = base64_encode("artigo");
$relatorioC = base64_encode("relatorio");
$A1C = base64_encode("autor1");
$A2C = base64_encode("autor2");
$A3C = base64_encode("autor3");
$OC = base64_encode("orientador");
$CoC = base64_encode("coorientador");

$keyAcess = $db->prepare("SELECT * FROM projetos WHERE idProjeto= :idProjeto AND ID = :idUs");
$keyAcess->bindValue(':idProjeto', base64_decode($idprojeto));
$keyAcess->bindValue(':idUs', $idUsuario);
$keyAcess->execute();

foreach ($keyAcess as $rowkeyAcess) {
	$idprjdec = $rowkeyAcess['idProjeto'];
	$_SESSION['nomeProjeto'] = $rowkeyAcess['nomeProjeto'];
	$_SESSION['instituicao'] = $rowkeyAcess['instituicao'];
	$_SESSION['dataIn'] = $rowkeyAcess['dataProjeto'];
	$_SESSION['aplicacao'] = $rowkeyAcess['areaAplicacao'];
	$_SESSION['resumo'] = $rowkeyAcess['resumo'];
	$_SESSION['keyWord'] = $rowkeyAcess['palavraChave'];
	$idU = $rowkeyAcess['ID'];
}

if (isset($idU)) {
	if ($idUsuario != $idU) {
		echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\");
		if(a == true){
		window.location.href = \"../index.php\";
		}else{ window.location.href = \"../index.php\"; }
		</script>";
	}
} else {
	echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\");
		if(a == true){
		window.location.href = \"../index.php\";
		}else{ window.location.href = \"../index.php\"; }
		</script>";
}

$_SESSION['idPage'] = $idprjdec;

/* FOTO */

$confImg = $db->prepare("SELECT * FROM upfotos WHERE idProjeto = :idDecod ");
$confImg->bindValue(':idDecod', $idprjdec);
$confImg->execute();

foreach ($confImg as $rI) {
	$_SESSION['idFoto'] = $rI['idFoto'];
	$_SESSION['nomeFoto'] = $rI['nomeFoto'];
	$_SESSION['dataImg'] = $rI['DataHora'];
}

/* ARTIGO */

$confDocs1 = $db->prepare("SELECT * FROM updocs WHERE idProjeto = :idDecod1 AND tipoArquivo = 'artigo'");
$confDocs1->bindValue(':idDecod1', $idprjdec);
$confDocs1->execute();

foreach ($confDocs1 as $rD1) {
	$_SESSION['idArt'] = $rD1['idDoc'];
	$_SESSION['nomeArtigo'] = $rD1['nomeDoc'];
	$_SESSION['dataArtigo'] = $rD1['DataHora'];
}

/* RELATORIO */

$confDocs2 = $db->prepare("SELECT * FROM updocs WHERE idProjeto = :idDecod2 AND tipoArquivo = 'relatorio'");
$confDocs2->bindValue(':idDecod2', $idprjdec);
$confDocs2->execute();

foreach ($confDocs2 as $rD2) {
	$_SESSION['idRel'] = $rD2['idDoc'];
	$_SESSION['nomeRelatorio'] = $rD2['nomeDoc'];
	$_SESSION['dataRelatorio'] = $rD2['DataHora'];
}

/* SELECIONANDO CONTEUDOS */

$a1 = SelectAutor($idprjdec, "A1", "Autor 1");
$a2 = SelectAutor($idprjdec, "A2", "Autor 2");
$a3 = SelectAutor($idprjdec, "A3", "Autor 3");
$co = SelectAutor($idprjdec, "Coorientador", "Coorientador");
$o = SelectAutor($idprjdec, "Orientador", "Orientador");

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../styles/edit.css">
	<link rel="icon" href="../Vetores/Logo.svg">

	<title>Editar Projeto</title>
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

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

					<a href="../index.php">	<h1> Blue</h1></a>
				</div>
			</div>
	</div>


	</header>
	<div class="container">
		<div class="row">
			<div class="col-md-10 seusdados">

				<h2 id="titleedit" >Editar Projeto</h2>
				<hr>

				<?php if (count($errorsEdit) > 0) : ?>
					<div class="error">
						<?php foreach ($errorsEdit as $error) : ?>
							<p><?php echo $error ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<form method="post" action="<?php echo "EditProjeto.php?$idprojeto" ?>" enctype="multipart/form-data">

					<div class="form-group">
						<br><label>Nome do Projeto: </label><br>
						<input type="text" name="nomeProjeto" class="form-control" placeholder="Projeto" required value="<?php echo $_SESSION['nomeProjeto']; ?>">
					</div>
					<div>
						<br><label>Instituição: </label><br>
						<input type="text" name="instituicao" class="form-control"  placeholder="Instituição" required value="<?php echo $_SESSION['instituicao']; ?>">
					</div>
					<div class="form-group">
						<br><label>Data de Início do Projeto: </label><br>
						<input type="date" name="dataIn" class="form-control"  placeholder="Data de início do Projeto" required value="<?php echo $_SESSION['dataIn']; ?>">
					</div>
					<div class="form-group">
						<br><label>Área de Aplicação: </label><br>
						<input type="text" name="aplicacao" class="form-control" placeholder="Área de Aplicação" required value="<?php echo $_SESSION['aplicacao']; ?>">
					</div>
					<div class="form-group">
						<br><label>Resumo: </label><br>
						<textarea name="resumo" cols="75" rows="10" class="form-control"  placeholder="Escreva seu Resumo de até 2000 caracteres" required><?php echo $_SESSION['resumo']; ?></textarea>
					</div>
					<div class="form-group">
						<br><label>Palavra-Chave: </label><br>
						<input type="text" name="keyword" class="form-control"  placeholder="Palavra-Chave" required value="<?php echo $_SESSION['keyWord']; ?>">
					</div>

					<!-- foto -->

					<h2>Anexos</h2>
					<hr>

					<?php if (isset($_SESSION['nomeFoto'])) : ?>
						<br>
						<label for="img">Imagem do Projeto</label>

						<div > <button id="btnDelFoto" class="float-right" ><img src="../Vetores/apagar.svg" alt="" width="20" heigh="auto"></button> <img src="upload/imgs/<?php echo $_SESSION['nomeFoto'];  ?>" id="img" class="centerize" alt="IMAGEM" width="" height="">

					</div>


						<?php
						$idFotobase = base64_encode($_SESSION['idFoto']);
						echo "
			<script>

			var botaoF = document.querySelector(\"#btnDelFoto\");
			botaoF.addEventListener(\"click\", function (){
				event.preventDefault();
	let b = window.confirm(\"Tem certeza que deseja excluir o arquivo?\");
	if(b == true){
		window.location.href = \"delProjeto.php?$fotoC?$idFotobase\";
	}
});


</script>
";
						?>


						<br>
						<br>
					<?php else : ?>
						<p><strong>Você ainda não adicionou uma Imagem, insira! </strong></p><br>
					<?php endif; ?>
					<label for="arquivoFoto02" class="btnupload centerize">Upload</label>
					<input type="file" id="arquivoFoto02" class="btnup" name="arquivoFoto2" accept=".png,.gif, .jpg, .jpeg">
					<p id="NOMEARF" class="nomerarq"></p>
					<br><br>

					<?php echo "
					<script>


					$('#arquivoFoto02').on('change',function() {

						// var fileUpload    = $(\"#ContentPlaceHolder1_FileUpload_mediaFile\").get(0);
						var fileUpload = $('#arquivoFoto02').get(0);
						var files         =  fileUpload.files;
						var mediafilename = \"\";

						for (var i = 0; i < files.length; i++) {
							mediafilename = files[i].name; }

					document.getElementById(\"NOMEARF\").innerHTML =\"Foto selecionada: \"+mediafilename;
				});

					</script>
					";
					?>

					<!-- artigo -->


					<?php if (isset($_SESSION['nomeArtigo'])) {

						$extensao = strtolower(substr($_SESSION['nomeArtigo'], -4));
						if ($extensao == ".pdf") { ?>
							<label for="art">Artigo Do Projeto</label>
							<div>

								<button id="btnDelArt1" class="float-right"><img src="../Vetores/apagar.svg" alt="" width="20" heigh="auto"></button><br>
								<embed src="upload/docs/artigo/<?php echo $_SESSION['nomeArtigo']; ?>" id="art" type="application/pdf" class="centerize" width="" height="" />
							</div>
							<!-- del -->



							<?php
							$idArtigobase = base64_encode($_SESSION['idArt']);
							echo "
				<script>

				var botaoA1 = document.querySelector(\"#btnDelArt1\");
				botaoA1.addEventListener(\"click\", function (){
					event.preventDefault();
					let b = window.confirm(\"Tem certeza que deseja excluir o arquivo?\");
					if(b == true){
						window.location.href = \"delProjeto.php?$artigoC?$idArtigobase\";
					}
				});


				</script>
				";
							?>







						<?php } else if ($extensao == ".odt") { ?>
							<p>Artigo: <strong><?php echo $_SESSION['nomeArtigo']; ?></strong></p>
							<!-- del -->

							<button id="btnDelArt2">excluir</button><br>

							<?php
							$idArtigobase = base64_encode($_SESSION['idArt']);
							echo "
				<script>

				var botaoA2 = document.querySelector(\"#btnDelArt2\");
				botaoA2.addEventListener(\"click\", function (){
					event.preventDefault();
					let b = window.confirm(\"Tem certeza que deseja excluir o arquivo?\");
					if(b == true){
						window.location.href = \"delProjeto.php?$artigoC?$idArtigobase\";
					}
				});


				</script>
				";
							?>

						<?php }
					} else { ?>
						<p><strong>Você ainda não adicionou um Artigo, insira! </strong></p><br>
					<?php } ?>
					<br><label for="arquivoDoc12" class="btnupload centerize">Upload</label>
					<input type="file" id="arquivoDoc12" name="arquivoDoc12" class="btnup " accept=".pdf, .odt">
					<p id="NOMEARA" class="nomerarq"></p>
					<br><br>
					<?php echo "
					<script>


					$('#arquivoDoc12').on('change',function() {

						// var fileUpload    = $(\"#ContentPlaceHolder1_FileUpload_mediaFile\").get(0);
						var fileUpload = $('#arquivoDoc12').get(0);
						var files         =  fileUpload.files;
						var mediafilename = \"\";

						for (var i = 0; i < files.length; i++) {
							mediafilename = files[i].name; }

					document.getElementById(\"NOMEARA\").innerHTML =\"Arquivo selecionado: \"+mediafilename;
				});

					</script>
					";
					?>
					<!-- relatorio -->

					<?php
					if (isset($_SESSION['nomeRelatorio'])) {

						$extensao = strtolower(substr($_SESSION['nomeRelatorio'], -4));
						if ($extensao == ".pdf") { ?>
							<label for="rel">Relatório do Projeto</label>
							<div>
								<button id="btnDelRel1" class="float-right"><img src="../Vetores/apagar.svg" alt="" width="20" heigh="auto"></button><br>
								<embed src="upload/docs/relatorio/<?php echo $_SESSION['nomeRelatorio']; ?>" id="rel" type="application/pdf" class="centerize" width="" height="" /><br>

							</div>
							<!-- del -->


							<?php
							$idRelbase = base64_encode($_SESSION['idRel']);
							echo "
				<script>

				var botaoR1 = document.querySelector(\"#btnDelRel1\");
				botaoR1.addEventListener(\"click\", function (){
					event.preventDefault();
					let b = window.confirm(\"Tem certeza que deseja excluir o arquivo?\");
					if(b == true){
						window.location.href = \"delProjeto.php?$relatorioC?$idRelbase\";
					}
				});


				</script>
				";
							?>


						<?php } else if ($extensao == ".odt") { ?>
							<p>Relatório: <strong><?php echo $_SESSION['nomeRelatorio']; ?></strong> </p>
							<!-- del -->

							<button id="btnDelRel2">excluir</button><br>

							<?php
							$idRelbase = base64_encode($_SESSION['idRel']);
							echo "
				<script>

				var botaoR2 = document.querySelector(\"#btnDelRel2\");
				botaoR2.addEventListener(\"click\", function (){
					event.preventDefault();
					let b = window.confirm(\"Tem certeza que deseja excluir o arquivo?\");
					if(b == true){
						window.location.href = \"delProjeto.php?$relatorioC?$idRelbase\";
					}
				});


				</script>
				";
							?>



						<?php }
					} else { ?>
						<p><strong>Você ainda não adicionou um Relatório, insira! </strong></p><br>
					<?php } ?>
					<label for="arquivoDoc22" class="btnupload centerize">Upload</label>
					<input type="file" name="arquivoDoc22"  id="arquivoDoc22" class="btnup" accept=".pdf, .odt">
					<p id="NOMEAR" class="nomerarq"></p>
					<br><br>
					<?php echo "
					<script>


					$('#arquivoDoc22').on('change',function() {

						// var fileUpload    = $(\"#ContentPlaceHolder1_FileUpload_mediaFile\").get(0);
						var fileUpload = $('#arquivoDoc22').get(0);
						var files         =  fileUpload.files;
						var mediafilename = \"\";

						for (var i = 0; i < files.length; i++) {
							mediafilename = files[i].name; }

					document.getElementById(\"NOMEAR\").innerHTML =\"Arquivo selecionado: \"+mediafilename;
				});

					</script>
					";
					?>


					<h2>Autores do Projeto</h2>
					<hr>
					<br>
					<h2>Autor 1 </h2>
					<br>

					<div class="form-group">
						<br><label>Nome Do Autor: </label><br>
						<input type="text" name="nomeA1" class="form-control"  placeholder="Nome Completo do Autor" required value="<?php echo $_SESSION['nomeA1']; ?>">
					</div>

					<div class="form-group">

						<br><label>Idade: </label><br>
						<input type="number" min="5" max="70" class="form-control"  name="idadeA1" placeholder="Idade do Autor" required value="<?php echo $_SESSION['idadeA1']; ?>">
					</div>

					<div class="form-group">

						<br><label>Email: </label><br>
						<input type="email" name="emailA1" class="form-control"  placeholder="E-mail do Autor" required value="<?php echo $_SESSION['emailA1']; ?>">
					</div>

					<div class="form-group">

						<br><label>Currículo Lattes: </label><br>
						<input type="text" name="lattesA1" class="form-control"  placeholder="Currículo Lattes do Autor" value="<?php echo $_SESSION['lattesA1']; ?>">
					</div>



					<br>


					<div class="">
						<div class="FloatLeft">

							<h2 class="">Autor 2 </h2>
						</div>
						<?php if (isset($_SESSION['nomeA2'])) { ?>
							<div class="FloatLeftXA">

								<button id="btnDelA2" class=""><img src="../Vetores/apagar.svg" alt="" width="20" heigh="auto"></button>
							</div>
						</div>


						<?php
						$idA2base = base64_encode($_SESSION['idA2']);
						echo "
			<script>

			var botaoAt2 = document.querySelector(\"#btnDelA2\");
botaoAt2.addEventListener(\"click\", function (){
	event.preventDefault();
	let b = window.confirm(\"Tem certeza que deseja excluir o Autor?\");
	if(b == true){
		window.location.href = \"delProjeto.php?$A2C?$idA2base\";
	}
});


</script>
";
						?>

						<br><br>

					<?php } ?>
					<br>

					<div class="form-group">

						<br><label>Nome Do Autor: </label><br>
						<input type="text" name="nomeA2" class="form-control"  placeholder="Nome Completo do Autor" value="<?php if ($a2) {
																											echo $_SESSION['nomeA2'];
																										} ?>">
					</div>

					<div class="form-group">

						<br><label>Idade: </label><br>
						<input type="number" min="5" max="70" class="form-control"  name="idadeA2" placeholder="Idade do Autor" value="<?php if ($a2) {
																														echo $_SESSION['idadeA2'];
																													} ?>">
					</div>

					<div class="form-group">

						<br><label>Email: </label><br>
						<input type="email" name="emailA2" class="form-control"  placeholder="E-mail do Autor" value="<?php if ($a2) {
																									echo $_SESSION['emailA2'];
																								} ?>">
					</div>

					<div class="form-group">

						<br><label>Currículo Lattes: </label><br>
						<input type="text" name="lattesA2" class="form-control"  placeholder="Currículo Lattes do Autor" value="<?php if ($a2) {
																												echo $_SESSION['lattesA2'];
																											} ?>">
					</div>


					<br>


					<div class="">
						<div class="FloatLeft">
						<h2>Autor 3 </h2>
						</div>
						<?php if (isset($_SESSION['nomeA3'])) { ?>
							<div class="FloatLeftXA">

								<button id="btnDelA3" class=""><img src="../Vetores/apagar.svg" alt="" width="20" heigh="auto"></button>
							</div>
						</div>
						<?php
						$idA3base = base64_encode($_SESSION['idA3']);
						echo "
			<script>

			var botaoA3 = document.querySelector(\"#btnDelA3\");
			botaoA3.addEventListener(\"click\", function (){
				event.preventDefault();
				let b = window.confirm(\"Tem certeza que deseja excluir o Autor?\");
				if(b == true){
					window.location.href = \"delProjeto.php?$A3C?$idA3base\";
				}
			});


			</script>
			";
						?>

						<br><br>
					<?php } ?>
					<br>

					<div class="form-group">

						<br><label>Nome Do Autor: </label><br>
						<input type="text" name="nomeA3" class="form-control"  placeholder="Nome Completo do Autor" value="<?php if ($a3) {
																											echo $_SESSION['nomeA3'];
																										} ?>">
					</div>

					<div class="form-group">

						<br><label>Idade: </label><br>
						<input type="number" min="5" class="form-control"  max="70" name="idadeA3" placeholder="Idade do Autor" value="<?php if ($a3) {
																														echo $_SESSION['idadeA3'];
																													} ?>">
					</div>

					<div class="form-group">

						<br><label>Email: </label><br>
						<input type="email" name="emailA3" class="form-control"  placeholder="E-mail do Autor" value="<?php if ($a3) {
																									echo $_SESSION['emailA3'];
																								} ?>">
					</div>

					<div class="form-group">

						<br><label>Currículo Lattes: </label><br>
						<input type="text" name="lattesA3" class="form-control"  placeholder="Currículo Lattes do Autor" value="<?php if ($a3) {
																												echo $_SESSION['lattesA3'];
																											} ?>">
					</div>



					<br>
					<h2>Orientador(a) </h2>
					<br>

					<div class="form-group">

						<br><label>Nome Do Orientador(a): </label><br>
						<input type="text" name="nomeO" class="form-control"  placeholder="Nome Completo do Orientador(a)" required value="<?php echo $_SESSION['nomeOrientador']; ?>">
					</div>

					<div class="form-group">

						<br><label>Idade: </label><br>
						<input type="number" min="5" max="70" class="form-control"  name="idadeO" placeholder="Idade do Orientador(a)" required value="<?php echo $_SESSION['idadeOrientador']; ?>">
					</div>

					<div class="form-group">

						<br><label>Email: </label><br>
						<input type="email" name="emailO" class="form-control"  placeholder="E-mail do Orientador(a)" required value="<?php echo $_SESSION['emailOrientador']; ?>">
					</div>

					<div class="form-group">

						<br><label>Currículo Lattes: </label><br>
						<input type="text" name="lattesO" class="form-control"  placeholder="Currículo Lattes do Orientador(a)" value="<?php echo $_SESSION['lattesOrientador']; ?>">
					</div>



					<br>

					<div>

						<div class="FloatLeft">

							<h2>Coorientador(a) </h2>
						</div>
							<?php if (isset($_SESSION['nomeCoorientador'])) { 	?>
							<div class="FloatLeftXAC">

								<button id="btnDelCo"><img src="../Vetores/apagar.svg" alt="" width="20" heigh="auto"></button><br>
							</div>
						</div>

						<?php

						$idCobase = base64_encode($_SESSION['idCoorientador']);

						echo "
<script>

var botaoCo = document.querySelector(\"#btnDelCo\");
botaoCo.addEventListener(\"click\", function (){
	event.preventDefault();
	let b = window.confirm(\"Tem certeza que deseja excluir o Coorientador?\");
	if(b == true){
		window.location.href = \"delProjeto.php?$CoC?$idCobase\";
	}
});


</script>
";

						?>

						<br><br>

					<?php } ?>
					<br>

					<div class="form-group">

						<br><label>Nome Do Coorientador(a): </label><br>
						<input type="text" name="nomeCo" placeholder="Nome Completo do Coorientador(a)" class="form-control"  value="<?php if ($co) {
																													echo $_SESSION['nomeCoorientador'];
																												} ?>">
					</div>

					<div class="form-group">

						<br><label>Idade: </label><br>
						<input type="number" min="5" max="70" name="idadeCo" class="form-control"  placeholder="Idade do Coorientador(a)" value="<?php if ($co) {
																																echo $_SESSION['idadeCoorientador'];
																															} ?>">
					</div>

					<div class="form-group">

						<br><label>Email: </label><br>
						<input type="email" name="emailCo" class="form-control"  placeholder="E-mail do Coorientador(a)" value="<?php if ($co) {
																												echo $_SESSION['emailCoorientador'];
																											} ?>">
					</div>

					<div class="form-group">

						<br><label>Currículo Lattes: </label><br>
						<input type="text" name="lattesCo" class="form-control" placeholder="Currículo Lattes do Coorientador(a)" value="<?php if ($co) {
																														echo $_SESSION['lattesCoorientador'];
																													} ?>">
					</div>



					<div>
						<br><button type="submit" class="buttom" name="upd_Projeto">Salvar Dados</button>
					</div>


				</form>

				<!-- <p><a href="../index.php">Voltar</a></p> -->
			</div>
		</div>
	</div>
	</div>
<script src="../js/bootstrapjquery.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="../js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
   $('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);
        return (code == 13) ? false : true;
   });
});
</script>
</body>

</html>
