<?php
include('server.php');

if (!session_id()) {
	session_start();
} else {
	session_regenerate_id(true);
}

if (!isset($_SESSION['email'])) {
	$_SESSION['msg'] = "Você deve fazer login primeiro";
	echo $_SESSION['msg'];
	header('location: main.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['email']);
	header("location: login.php");
}

// destruindo sessoes

if (isset($_SESSION['nomeFoto'])) {
	unset($_SESSION['idFoto']);
	unset($_SESSION['nomeFoto']);
	unset($_SESSION['dataImg']);
}
if (isset($_SESSION['nomeRelatorio'])) {
	unset($_SESSION['idRel']);
	unset($_SESSION['nomeRelatorio']);
	unset($_SESSION['dataRelatorio']);
}
if (isset($_SESSION['nomeArtigo'])) {
	unset($_SESSION['idArt']);
	unset($_SESSION['nomeArtigo']);
	unset($_SESSION['dataArtigo']);
}
if (isset($_SESSION['nomeProjeto'])) {
	unset($_SESSION['nomeProjeto']);
	unset($_SESSION['instituicao']);
	unset($_SESSION['dataIn']);
	unset($_SESSION['aplicacao']);
	unset($_SESSION['resumo']);
	unset($_SESSION['keyWord']);
}
if (isset($_SESSION['nomeA1'])) {
	unset($_SESSION['nomeA1']);
	unset($_SESSION['idadeA1']);
	unset($_SESSION['emailA1']);
	unset($_SESSION['lattesA1']);
}
if (isset($_SESSION['nomeA2'])) {
	unset($_SESSION['nomeA2']);
	unset($_SESSION['idadeA2']);
	unset($_SESSION['emailA2']);
	unset($_SESSION['lattesA2']);
}
if (isset($_SESSION['nomeA3'])) {
	unset($_SESSION['nomeA3']);
	unset($_SESSION['idadeA3']);
	unset($_SESSION['emailA3']);
	unset($_SESSION['lattesA3']);
}
if (isset($_SESSION['nomeO'])) {
	unset($_SESSION['nomeO']);
	unset($_SESSION['idadeO']);
	unset($_SESSION['emailO']);
	unset($_SESSION['lattesO']);
}
if (isset($_SESSION['nomeCo'])) {
	unset($_SESSION['nomeCo']);
	unset($_SESSION['idadeCo']);
	unset($_SESSION['emailCo']);
	unset($_SESSION['lattesCo']);
}
if (isset($_SESSION['nomeOrientador'])) {
	unset($_SESSION['nomeOrientador']);
	unset($_SESSION['idadeOrientador']);
	unset($_SESSION['emailOrientador']);
	unset($_SESSION['lattesOrientador']);
}
if (isset($_SESSION['nomeCoorientador'])) {
	unset($_SESSION['nomeCoorientador']);
	unset($_SESSION['idadeCoorientador']);
	unset($_SESSION['emailCoorientador']);
	unset($_SESSION['lattesCoorientador']);
}


$result = $db->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
$result->bindValue(':email', $_SESSION['email']);
$result->bindValue(':senha', $_SESSION['senha']);
$result->execute();

if ($result) {

	foreach ($result as $row) {
		$idUser = $row['ID'];
		$nome = $row['nome'];
		$email = $row['email'];
		$senha = $row['senha'];
	}
}


// Definindo se há projetos existentes
$files = $db->prepare("SELECT * FROM projetos WHERE ID = (SELECT ID FROM usuarios WHERE email = :email)");
$files->bindValue(':email', $email);
$files->execute();
$countProjeto = $files->rowCount();

?>

<!DOCTYPE html>
<html>

<head>
	<title>Blue</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="styles/index.css">

	<link rel="stylesheet" href="css/bootstrap.min.css">

	<link rel="icon" href="Vetores/Logo.svg">
</head>

	<body>

		<header class="cabecalho">
				<div class="logotitle">

				<div class="logo">

			<figure >
				<img src="Vetores/Logo.svg" width="" height="" class="d-inline-block align-top" alt="" class="img-fluid">
			</figure>
			</div>
					<div class="titlec" >
							<h1 class="titlec"> Blue </h1>
					</div>
				</div>
			<?php echo "<div class=\"nomeUser\"><p><strong> $nome </strong></p></div>"; ?>
			<div class="">

			<a href="index.php?logout='1'">
					<img src="Vetores/logout.svg" alt="sair" width="35px" height="auto" class="img-fluid float-right imagec logout">
			</a>
		</div>
		</header>

		<div class="container-fluid">



			<?php if (isset($_SESSION['email'])) : ?>

				<?php
				if ($countProjeto) :

					$control = 0;



					foreach ($files as $row) {

						//Definindo autores
						$auth = $db->prepare("SELECT NomeAutor FROM autor WHERE cargo !='Orientador' AND cargo !='Coorientador' AND idProjeto = $row[idProjeto]");
						$auth->execute();
						$countAuth = $auth->rowCount();



						$idProj = base64_encode($row['idProjeto']);

						$confImg = $db->prepare("SELECT * FROM upfotos WHERE idProjeto = :idProj ");
						$confImg->bindValue(':idProj', base64_decode($idProj));
						$confImg->execute();

						foreach ($confImg as $rI) {
							$nomeFoto = $rI['nomeFoto'];
							$dataIn = $rI['DataHora'];
						}

						//Projetos
						// echo $nomeFoto;
						echo "

							<div class=\"row\">
								<div class=\"col-md-12 \">
									<div class=\"caixaproj\">

										<figure class=\"profile float-left\">
										";
						if (isset($nomeFoto)) {
							echo "
									<img src=\"upload/upload/imgs/$nomeFoto\" alt=\"img\" >
								";
							$nomeFoto = null;
						} else {
							echo "
									<img src=\"Vetores/profile.svg\" alt=\"img\">
								";
						}

						echo "
										</figure>

										<a href=\"upload/ShowProjeto.php?$idProj\">
										<p class=\"titleproj float-left \">$row[nomeProjeto]</p>
										</a>

										<p class=\"autproj\">
										Autores:
										";
						/* Busca autors */
						foreach ($auth as $rowA) {
							echo "<br> $rowA[NomeAutor] ";
						}

						echo "

										</p>
											<div class=\"caixaicons\">
											<figure class=\"float-right logoexcluir\">
											<button id=\"delet$control\" class=\"btnexcluir\">
											<img src=\"Vetores/excluir.svg\" alt=\"ALT\" widht=\"70px\" height=\"70px\"  class=\"float-right\">
											</button>
											</figure>
										<figure class=\"float-right logoedit\">
											<a href=\"upload/EditProjeto.php?$idProj\">
												<img src=\"Vetores/editar.svg\" alt=\"EDIT\" widht=\"70px\" height=\"70px\" class=\"float-right\">
											</a>
										</figure>

										</div>
									</div>
								</div>
							</div>

							<script>
								var botaoPrj = document.querySelector(\"#delet$control\");

								botaoPrj.addEventListener(\"click\", function (){
								event.preventDefault();

								let b = window.confirm(\"Tem certeza que deseja excluir o Projeto $row[nomeProjeto]?\");

								if(b == true){
								window.location.href = \"upload/delProjeto.php?$idProj\";
								}
								});
							</script>

							";

						$control++;
					}

					echo "

						<div class=\"col-md-12\">
							<div class=\"caixamais\">
									<a href=\"upload/AddProjeto.php\"><img src=\"Vetores/mais.svg\" alt=\"mais\"></a>
							</div>
							<div class=\"sair\">
								<a href=\"index.php?logout='1'\"><img src=\"Vetores/logout.svg\" alt=\"delet\" height=\"auto\" class=\"img-fluid \"></a>
							</div>
						</div>
						";

				//Caso sem projeto

				else :
					echo "
							<div class=\"row\">

									<div class=\"caixa\">
										<h1 class=\"text-center frase\">Vamos criar ou adicionar um projeto</h1>

										<figure class=\"float-right seta\">
										<img src=\"Vetores/arrown.svg\" alt=\"seta\" id=\"imgseta\" class=\"img-fluid\">
										</figure>

										<figure class=\"maisicon\">
											<a href=\"upload/AddProjeto.php\">
											<img src=\"Vetores/mais.svg\" alt=\"mais\" width=\"\" height=\"\">
											</a>
										</figure>

									</div>
									<div class=\"sair\">
										<a href=\"index.php?logout='1'\"><img src=\"Vetores/logout.svg\" alt=\"delet\" height=\"auto\" class=\"img-fluid \"></a>
									</div>
							</div>
						</div>
							";
				endif;
				?>

			<?php endif ?>


		</div>
		</div>

		<div class="spaceX"></div>

		<script src="js/bootstrapjquery.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
