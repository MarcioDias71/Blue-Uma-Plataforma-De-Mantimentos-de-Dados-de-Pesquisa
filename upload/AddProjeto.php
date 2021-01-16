<?php
include('../server.php');

if (!isset($_SESSION['email'])) {
	$_SESSION['msg'] = "Você deve fazer login primeiro";
	echo $_SESSION['msg'];
	header('location: ../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../styles/addproj.css">
	<link rel="icon" href="../Vetores/Logo.svg">

	<title>Cadastrar Projeto</title>
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
					<a href="../index.php">	<h1 class="titlec"> Blue &nbsp</h1></a>
				</div>
			</div>
	</div>


	</header>
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-7 seusdados">

				<h2 id="titlecad">Cadastrar Projeto</h2>
				<hr>

				<?php if (count($errorsAdic) > 0) : ?>
					<div class="error">
						<?php foreach ($errorsAdic as $error) : ?>
							<p><?php echo $error ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<form method="POST" action="AddProjeto.php" enctype="multipart/form-data">

					<div class="form-group">
						<br><label>Nome do Projeto: </label><br>
						<input type="text" name="nomeProjeto" class="form-control"  placeholder="Projeto" required value="<?php echo $nomeProjeto; ?>">
					</div>
					<div class="form-group">
						<br><label>Instituição: </label><br>
						<input type="text" name="instituicao" class="form-control" placeholder="Instituição" required value="<?php echo $instituicao; ?>">
					</div>
					<div class="form-group">
						<br><label>Data de início do Projeto: </label><br>
						<input type="date" name="dataIn" class="form-control" required value="<?php echo $dataIn; ?>">
					</div>
					<div class="form-group">
						<br><label>Área de Aplicação: </label><br>
						<input type="text" name="aplicacao" placeholder="Área de Aplicação" class="form-control" required value="<?php echo $aplicacao; ?>">
					</div>
					<div>
						<div class="form-group">
							<br><label>Resumo: </label><br>
							<textarea name="resumo" cols="75" rows="10" class="form-control" placeholder="Escreva seu Resumo de até 2000 caracteres" required><?php echo "$resumo"; ?></textarea>
						</div>
						<div class="form-group">
							<br><label>Palavra-Chave: </label><br>
							<input type="text" name="keyword" class="form-control" placeholder="Palavra-Chave" required value="<?php echo $keyword; ?>">
						</div>
						<h2>Anexos</h2>
						<hr>

						<div class="form-group">
							<br><label for="lei">Imagem do Projeto </label><br>
							<br><label id="lei" for="arquivoFoto" class="btnupload">Upload</label><br>
							<input name="arquivoFoto" id="arquivoFoto" type="file" accept=".jpg, .png, .gif, .jpg" class="btnup" value="Upload"><br><br>
							<p id="NOMEARF" class="nomerarq"></p>
						</div>
						<!-- Pega o nome dos arquivos selecionados -->
						<?php echo "
						<script>


						$('#arquivoFoto').on('change',function() {

							// var fileUpload    = $(\"#ContentPlaceHolder1_FileUpload_mediaFile\").get(0);
							var fileUpload = $('#arquivoFoto').get(0);
							var files         =  fileUpload.files;
							var mediafilename = \"\";

							for (var i = 0; i < files.length; i++) {
								mediafilename = files[i].name; }

						document.getElementById(\"NOMEARF\").innerHTML =\"Foto selecionada: \"+mediafilename;
					});

						</script>
						";
						?>


						<div class="form-group">
						<br><label for="lei2">Artigo do Projeto </label><br>

							<br><label id="lei2" for="arquivoDoc1" class="btnupload">Upload </label><br>
							<input name="arquivoDoc1" id="arquivoDoc1" type="file" accept=".pdf, .odt" class="btnup"><br><br>
							<p id="NOMEARA" class="nomerarq"></p>
						</div>
						<?php echo "
						<script>


						$('#arquivoDoc1').on('change',function() {

							// var fileUpload    = $(\"#ContentPlaceHolder1_FileUpload_mediaFile\").get(0);
							var fileUpload = $('#arquivoDoc1').get(0);
							var files         =  fileUpload.files;
							var mediafilename = \"\";

							for (var i = 0; i < files.length; i++) {
								mediafilename = files[i].name; }

						document.getElementById(\"NOMEARA\").innerHTML =\"Arquivo Selecionado: \"+mediafilename;
					});

						</script>
						";	?>
						<div class="form-group">
							<br><label for="lei" >Relatório do Projeto</label>
							<br><label id="lei3" for="arquivoDoc2" class="btnupload">Upload</label><br>
							<input name="arquivoDoc2"  id="arquivoDoc2" type="file" accept=".pdf, .odt" class="btnup"><br><br>
							<p id="NOMEAR" class="nomerarq"></p>
						</div>
							<?php echo "
							<script>


		 					$('#arquivoDoc2').on('change',function() {

								var fileUpload = $('#arquivoDoc2').get(0);
								var files         =  fileUpload.files;
								var mediafilename = \"\";

								for (var i = 0; i < files.length; i++) {
								  mediafilename = files[i].name; }

							document.getElementById(\"NOMEAR\").innerHTML =\"Arquivo Selecionado: \"+mediafilename;
						});

							</script>
							";
							?>


						<br>
						<h2>Autor 1 </h2>
						<br>

						<div class="form-group">
							<br><label>Nome Do Autor: </label><br>
							<input type="text" name="nomeA1" class="form-control" placeholder="Nome Completo do Autor" required value="<?php echo $nomeA1; ?>">
						</div>

						<div class="form-group">
							<br><label>Idade: </label><br>
							<input type="number" min="5" max="70" class="form-control" name="idadeA1" placeholder="Idade do Autor" required value="<?php echo $idadeA1; ?>">
						</div>

						<div class="form-group">
							<br><label>Email: </label><br>
							<input type="email" name="emailA1" class="form-control" placeholder="E-mail do Autor" required value="<?php echo $emailA1; ?>">
						</div>

						<div class="form-group">
							<br><label>Currículo Lattes: </label><br>
							<input type="text" name="lattesA1" class="form-control" placeholder="Currículo Lattes do Autor" value="<?php echo $lattesA1; ?>">
						</div>

						<!--  -->

						<br>
						<h2>Autor 2 </h2>
						<br>

						<div class="form-group">

							<br><label>Nome Do Autor: </label><br>
							<input type="text" name="nomeA2" class="form-control" placeholder="Nome Completo do Autor" value="<?php echo $nomeA2; ?>">
						</div>

						<div class="form-group">

							<br><label>Idade: </label><br>
							<input type="number" min="5" max="70" class="form-control" name="idadeA2" placeholder="Idade do Autor" value="<?php echo $idadeA2; ?>">
						</div>

						<div class="form-group">

							<br><label>Email: </label><br>
							<input type="email" name="emailA2" class="form-control" placeholder="E-mail do Autor" value="<?php echo $emailA2; ?>">
						</div>

						<div class="form-group">

							<br><label>Currículo Lattes: </label><br>
							<input type="text" name="lattesA2" class="form-control" placeholder="Currículo Lattes do Autor" value="<?php echo $lattesA2; ?>">
						</div>

						<!--  -->

						<br>
						<h2>Autor 3 </h2>
						<br>

						<div class="form-group">

							<br><label>Nome Do Autor: </label><br>
							<input type="text" name="nomeA3" class="form-control" placeholder="Nome Completo do Autor" value="<?php echo $nomeA3; ?>">
						</div>

						<div class="form-group">

							<br><label>Idade: </label><br>
							<input type="number" min="5" max="70" class="form-control" name="idadeA3" placeholder="Idade do Autor" value="<?php echo $idadeA3; ?>">
						</div>

						<div class="form-group">

							<br><label>Email: </label><br>
							<input type="email" name="emailA3" class="form-control" placeholder="E-mail do Autor" value="<?php echo $emailA3; ?>">
						</div>

						<div class="form-group">

							<br><label>Currículo Lattes: </label><br>
							<input type="text" name="lattesA3" class="form-control" placeholder="Currículo Lattes do Autor" value="<?php echo $lattesA3; ?>">
						</div>

						<!-- -->
						<br>
						<h2>Orientador(a) </h2>
						<br>

						<div class="form-group">

							<br><label>Nome Do Orientador(a): </label><br>
							<input type="text" name="nomeO" class="form-control" placeholder="Nome Completo do Orientador(a)" required value="<?php echo $nomeO; ?>">
						</div>

						<div class="form-group">

							<br><label>Idade: </label><br>
							<input type="number" min="5" max="70" class="form-control" name="idadeO" placeholder="Idade do Orientador(a)" required value="<?php echo $idadeO; ?>">
						</div>

						<div class="form-group">

							<br><label>Email: </label><br>
							<input type="email" name="emailO" class="form-control" placeholder="E-mail do Orientador(a)" required value="<?php echo $emailO; ?>">
						</div>

						<div class="form-group">

							<br><label>Currículo Lattes </label><br>
							<input type="text" name="lattesO" class="form-control" placeholder="Currículo Lattes do Orientador(a)" value="<?php echo $lattesO; ?>">
						</div>

						<!--  -->

						<br>
						<h2>Coorientador(a) </h2>
						<br>

						<div class="form-group">

							<br><label>Nome Do Coorientador(a): </label><br>
							<input type="text" name="nomeCo" class="form-control" placeholder="Nome Completo do Coorientador(a)" value="<?php echo $nomeCo; ?>">
						</div>

						<div class="form-group">

							<br><label>Idade: </label><br>
							<input type="number" min="5" max="70" class="form-control" name="idadeCo" placeholder="Idade do Coorientador(a)" value="<?php echo $idadeCo; ?>">
						</div>

						<div class="form-group">

							<br><label>Email: </label><br>
							<input type="email" name="emailCo" class="form-control" placeholder="E-mail do Coorientador(a)" value="<?php echo $emailCo; ?>">
						</div>

						<div class="form-group">

							<br><label>Currículo Lattes: </label><br>
							<input type="text" name="lattesCo" class="form-control" placeholder="Currículo Lattes do	 Coorientador(a)" value="<?php echo $lattesCo; ?>">
						</div>

						<div class="form-group">

							<br><button type="submit"  class="btn" name="reg_Projeto">Salvar Cadastro</button>
						</div>

						<!-- <p><a href="../index.php">Voltar</a></p> -->

				</form>
			</div>
		</div>
	</div>
	</div>

	<script src="../js/bootstrapjquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>

</body>

</html>
