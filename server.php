<?php 
session_start();

include("conexao.php");
include("upload/funcao.php");

	// variaveis
	$username = "";
	$email    = "";
	$errors = array(); 


	// CADASTRA->VERIFICA
	if (isset($_POST['reg_user'])) {
		
		$username = addslashes($_POST['nome']);
		$email = addslashes($_POST['email']);
		$password_1 = addslashes($_POST['password_1']);
		$password_2 = addslashes($_POST['password_2']);
		$captcha = addslashes($_POST['captcha']);

		//Nome diferente de vazio
		if (empty($username)){ 
			$txtNome = "Requer Nome"; 
			array_push($errors, "1");
		}
		//Email diferente de vazio
		if (empty($email)){ 
			$txtEmail = "Requer Email"; 
			array_push($errors, "2");
		}
		//Analisa se ha o mesmo email cadastrado
		$emailCONF=$db->prepare("SELECT email FROM usuarios WHERE email = :email");
		$emailCONF->bindValue(':email',$email);
		$emailCONF->execute();
		$count = $emailCONF->rowCount();
		if ($count>=1) { 
			 $txtEmail = "Email já Existente"; 
			 array_push($errors, "3");
		}
		//Senha 1 diferente de vazio
		if (empty($password_1)){ 
			$txtSenha = "Requer Senha"; 
			array_push($errors, "4");
		}else {
			//Senha mais que 8 caracteres
			if(strlen($password_1)<8){ 
				$txtSenha = "Mínimo 8 caracteres"; 
				array_push($errors, "5");
			}
		}
		//Senha 1 diferente da senha 2
		if ($password_1 != $password_2){ 
			$txtSenha = "As senhas são incompatíveis"; 
			array_push($errors, "6");
		}
		//Captcha diferente de vazio
		if (empty($captcha)){ 
			$txtCaptcha = "Requer Captcha"; 
			array_push($errors, "Requer Captcha"); 
		}else {
			//Captcha incorreto
			if ($captcha != $_SESSION["captcha"]){
				$txtCaptcha = "Código Captcha Incorreto"; 
				array_push($errors, "Código Captcha Incorreto");
			}
		}
		
		if (count($errors) == 0){
			$password = md5($password_1);
			$_SESSION['email'] = $email;
			$_SESSION['nome'] = $username;
			$_SESSION['senha'] = $password;
			header('location: Verification.php');
			}
		}

						
	//VERIFY	
	if (isset($_POST['verifica'])){

		$username = $_SESSION['nome'];
		$email    = $_SESSION['email'];
		$password = $_SESSION['senha'];

		$COD = addslashes($_POST['verify']);
		
		$emailCONF=$db->prepare("SELECT email FROM usuarios WHERE email = :email");
		$emailCONF->bindValue(':email',$email);
		$emailCONF->execute();
		$count = $emailCONF->rowCount();
		//corrige erro de email ja existente
		if ($count >= 1) {
		 	array_push($errors, "Email já existente"); 
		}
		//Cod incorreto
		if ($_SESSION['cod'] != $COD) {
			$txtVerify = "Código Incorreto";
			array_push($errors, "O código é incompatível");
		}
		//Cod diferente de vazio
		if (empty($COD)) {
			$txtVerify = "Requer Código";
			array_push($errors, "Requer Código");
		}

		if (count($errors) == 0) {
			$insertValue=$db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES(:nome,:email, :senha)");
			$insertValue->bindValue(':nome',$username);
			$insertValue->bindValue(':email',$email);
			$insertValue->bindValue(':senha',$password);
			$insertValue->execute();
					
			$_SESSION['email'] = $email;
			$_SESSION['senha'] = $password;
			header('location: index.php');
		}
	
	}
	
	
	// LOGIN USER
	if (isset($_POST['login_user'])) {

		$email = addslashes($_POST['email']);
		$password = addslashes($_POST['password']);
		//Email vazio
		if (empty($email)) {
			array_push($errors, "Requer Email");
		}
		//Senha vazio
		if (empty($password)) {
			array_push($errors, "Requer Senha");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$emailCONF=$db->prepare("SELECT email FROM usuarios WHERE email = :email AND senha = :senha");
			$emailCONF->bindValue(':email',$email);
			$emailCONF->bindValue(':senha',$password);
			$emailCONF->execute();
			$count = $emailCONF->rowCount();

			if ($count == 1){ 
				$_SESSION['email']=$email;
				$_SESSION['senha'] = $password;
				header('Location: index.php');
			}else {
				array_push($errors, "E-mail incorreto ou Senha incorreta");
			}
		}
	}


// ======================== UPLOAD ========================== //
// ======================== UPLOAD ========================== //
// ======================== UPLOAD ========================== //
// ======================== UPLOAD ========================== //
// ======================== UPLOAD ========================== //
// ======================== UPLOAD ========================== //
// ======================== UPLOAD ========================== //

if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
	$senhaU = $_SESSION['senha'];

	$ConfIdUser=$db->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
	$ConfIdUser->bindValue(':email',$email);
	$ConfIdUser->bindValue(':senha',$senhaU);
	$ConfIdUser->execute();

	foreach($ConfIdUser as $rCI){
		$idUsuario = $rCI['ID'];
	}
}

#variaveis

$errorsAdic = array();
$errorsEdit = array();

$nomeProjeto = "";
$instituicao = "";
$dataIn = "";
$aplicacao= "";
$resumo = "";
$keyword = "";	

$nomeA1 = "";
$idadeA1 = "";
$emailA1 = "";
$lattesA1 = "";

$nomeA2 = "";
$idadeA2 = "";
$emailA2 = "";
$lattesA2 = "";

$nomeA3 = "";
$idadeA3 = "";
$emailA3 = "";
$lattesA3 = "";

$nomeO = "";
$idadeO = "";
$emailO = "";
$lattesO = "";

$nomeCo = "";
$idadeCo = "";
$emailCo = "";
$lattesCo = "";

// CADASTRAR PROJETO

if (isset($_POST['reg_Projeto'])) {

$nomeProjeto = $_POST['nomeProjeto'];
$instituicao = $_POST['instituicao'];
$dataIn = $_POST['dataIn'];
$aplicacao = $_POST['aplicacao'];
$resumo = $_POST['resumo'];
$keyword = $_POST['keyword'];

$nomeA1=$_POST['nomeA1'];
$idadeA1=$_POST['idadeA1'];
$emailA1=$_POST['emailA1'];
$lattesA1=$_POST['lattesA1'];

$nomeA2=$_POST['nomeA2'];
$idadeA2=$_POST['idadeA2'];
$emailA2=$_POST['emailA2'];
$lattesA2=$_POST['lattesA2'];

$nomeA3=$_POST['nomeA3'];
$idadeA3=$_POST['idadeA3'];
$emailA3=$_POST['emailA3'];
$lattesA3=$_POST['lattesA3'];	

$nomeO=$_POST['nomeO'];
$idadeO=$_POST['idadeO'];
$emailO=$_POST['emailO'];
$lattesO=$_POST['lattesO'];

$nomeCo=$_POST['nomeCo'];
$idadeCo=$_POST['idadeCo'];
$emailCo=$_POST['emailCo'];
$lattesCo=$_POST['lattesCo'];

/* Projeto */
if((empty($nomeProjeto))||(empty($instituicao))||(empty($dataIn))||(empty($aplicacao))||(empty($resumo))||(empty($keyword))){
	array_push($errorsAdic, "Algum campo dos dados do Projeto está vazio");
}

/* Autor 1 */
if((empty($nomeA1))||(empty($idadeA1))||(empty($emailA1))){
	array_push($errorsAdic, "Algum campo de Autor 1 está vazio"); 
}

/* Autor 2 */
if((!empty($nomeA2))||(!empty($idadeA2))||(!empty($emailA2))||(!empty($lattesA2))){
	if((empty($nomeA2))||(empty($idadeA2))||(empty($emailA2))){
		array_push($errorsAdic, "Algum campo de Autor 2 está vazio.");
	}
}
 
/* Autor 3 */
if((!empty($nomeA3))||(!empty($idadeA3))||(!empty($emailA3))||(!empty($lattesA3))){
	if((empty($nomeA3))||(empty($idadeA3))||(empty($emailA3))){
		array_push($errorsAdic, "Algum campo de Autor 3 está vazio");
	}
}
 
/* Orientador */
if((empty($nomeO))||(empty($idadeO))||(empty($emailO))){
	array_push($errorsAdic, "Algum campo de Orientador está vazio.");
}

/* Coorientador */
if((!empty($nomeCo))||(!empty($idadeCo))||(!empty($emailCo))||(!empty($lattesCo))){
	if((empty($nomeCo))||(empty($idadeCo))||(empty($emailCo))){
		array_push($errorsAdic, "Algum campo de Coorientador está vazio");
	}
}

// ERROR
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
// END ERROR

/* Foto */
 
 if(!empty($_FILES['arquivoFoto']['size'])){
 
	$_UP['tamanho'] = 5000000; 
	$_UP['extensoesImg'] = array('.png', '.jpg', 'jpeg', '.gif');
		
	$extensao = strtolower(substr($_FILES['arquivoFoto']['name'],-4));
	if(array_search($extensao, $_UP['extensoesImg'])=== false){		
		array_push($errorsAdic,"Extensão da Imagem é inválida ('.png','.jpg','.jpeg','.gif')");	
	}
	if ($_UP['tamanho'] < $_FILES['arquivoFoto']['size']){
		array_push($errorsAdic,"Imagem muito grande, máx. 5mb");	
	}
 
 }
  
 if(!empty($_FILES['arquivoDoc1']['size'])){
 
	$_UP['tamanhoDoc1'] = 30000000; 
	$_UP['extensoesDoc1'] = array('.pdf', '.odt');
		
	$extensao = strtolower(substr($_FILES['arquivoDoc1']['name'],-4));
	if(array_search($extensao, $_UP['extensoesDoc1'])=== false){		
		array_push($errorsAdic,"Extensão de arquivo do artigo é inválida ('.pdf', '.odt')");	
	}
	if ($_UP['tamanhoDoc1'] < $_FILES['arquivoDoc1']['size']){
		array_push($errorsAdic,"Artigo muito grande, máx. 30mb");	
	}
 
 }
  
 if(!empty($_FILES['arquivoDoc2']['size'])){
 
	$_UP['tamanhoDoc2'] = 30000000; 
	$_UP['extensoesDoc2'] = array('.pdf', '.odt');
		
	$extensao = strtolower(substr($_FILES['arquivoDoc2']['name'],-4));
	if(array_search($extensao, $_UP['extensoesDoc2'])=== false){		
		array_push($errorsAdic,"Extensão de arquivo do relatório é inválida ('.pdf', '.odt')");	
	}
	if ($_UP['tamanhoDoc2'] < $_FILES['arquivoDoc2']['size']){
		array_push($errorsAdic,"Relatório muito grande, máx. 30mb");	
	}
 
 }

 if(contains_number($nomeA1) == true){
	array_push($errorsAdic,"O campo nome de Autor 1 não pode possuir caracteres numéricos.");
 }
 if(contains_number($nomeA2) == true){
	array_push($errorsAdic,"O campo nome de Autor 2 não pode possuir caracteres numéricos.");
 }
 if(contains_number($nomeA3) == true){
	array_push($errorsAdic,"O campo nome de Autor 3 não pode possuir caracteres numéricos.");
 }
 if(contains_number($nomeO) == true){
	array_push($errorsAdic,"O campo nome de Orientador não pode possuir caracteres numéricos.");
 }
 if(contains_number($nomeCo) == true){
	array_push($errorsAdic,"O campo nome de Coorientador não pode possuir caracteres numéricos.");
 }

/* verificar se existe projeto com mesmo nome */
$con = $db->prepare("SELECT * FROM projetos WHERE nomeProjeto = :nomeProjeto AND ID = :ID");
$con->bindValue(':nomeProjeto', $nomeProjeto);
$con->bindValue(':ID', $idUsuario );
$con->execute();

$count = $con->rowCount();

if ($count>=1) { 
	array_push($errorsAdic, "Nome de Projeto já Existente");
}


if(count($errorsAdic)==0){

$Add = $db->prepare("INSERT INTO projetos (nomeProjeto, instituicao, dataProjeto, areaAplicacao, resumo, palavraChave, ID) VALUES (:nomeProjeto, :instituicao, :datein, :areaAplicacao, :resumo, :palavraChave, :idUsuario)");
$Add->bindValue(':nomeProjeto',$nomeProjeto);
$Add->bindValue(':instituicao',$instituicao);
$Add->bindValue(':datein',$dataIn);
$Add->bindValue(':areaAplicacao',$aplicacao);
$Add->bindValue(':resumo',$resumo);
$Add->bindValue(':palavraChave',$keyword);
$Add->bindValue(':idUsuario',$idUsuario);
$Add->execute();


// pegar o id que foi inserido

$conf = $db->prepare("SELECT idProjeto, nomeProjeto FROM projetos WHERE nomeProjeto = :nome AND ID = :ID");
$conf->bindValue(':nome', $nomeProjeto);
$conf->bindValue(':ID', $idUsuario);
$conf->execute();
foreach($conf as $row){
	$idProjeto = $row['idProjeto'];
	$nomeProjeto = $row['nomeProjeto'];
}

/* AUTOR 1 */
if((!empty($nomeA1))&&(!empty($idadeA1))&&(!empty($emailA1))){
	InsereAutor($idProjeto,$nomeA1, $idadeA1, $emailA1, "Autor 1", $lattesA1); 
}
/* AUTOR 2 */
if((!empty($nomeA2))&&(!empty($idadeA2))&&(!empty($emailA2))){
	InsereAutor($idProjeto,$nomeA2, $idadeA2, $emailA2, "Autor 2", $lattesA2);
}
/* AUTOR 3 */
if((!empty($nomeA3))&&(!empty($idadeA3))&&(!empty($emailA3))){
	InsereAutor($idProjeto, $nomeA3, $idadeA3, $emailA3, "Autor 3", $lattesA3);
}
/* ORIENTADOR */
if((!empty($nomeO))&&(!empty($idadeO))&&(!empty($emailO))){
	InsereAutor($idProjeto, $nomeO, $idadeO, $emailO, "Orientador", $lattesA3);
}

/* COORIENTADOR */
if((!empty($nomeCo))&&(!empty($idadeCo))&&(!empty($emailCo))){
	InsereAutor($idProjeto, $nomeCo, $idadeCo, $emailCo, "Coorientador", $lattesCo);
}

/* FOTO */
if(isset($_FILES['arquivoFoto'])){
	$nomeFoto = $_FILES['arquivoFoto']['name'];
	$nomeTempFoto = $_FILES['arquivoFoto']['tmp_name'];
	$tamanhoFoto = $_FILES['arquivoFoto']['size'];

	$error = InsereArquivo($idProjeto, $nomeProjeto , $nomeFoto , "foto", $tamanhoFoto, $nomeTempFoto);
}

/* ARTIGO */
if(isset($_FILES['arquivoDoc1'])){
	$nomeDoc1 = $_FILES['arquivoDoc1']['name'];
	$nomeTempDoc1 = $_FILES['arquivoDoc1']['tmp_name'];
	$tamanhoDoc1 = $_FILES['arquivoDoc1']['size'];

	InsereArquivo($idProjeto, $nomeProjeto, $nomeDoc1 , "artigo", $tamanhoDoc1, $nomeTempDoc1);
}

/* RELATORIO */
if(isset($_FILES['arquivoDoc2'])){
	$nomeDoc2 = $_FILES['arquivoDoc2']['name'];
	$nomeTempDoc2 = $_FILES['arquivoDoc2']['tmp_name'];
	$tamanhoDoc2 = $_FILES['arquivoDoc2']['size'];
	
	InsereArquivo($idProjeto, $nomeProjeto, $nomeDoc2 , "relatorio", $tamanhoDoc2, $nomeTempDoc2);
}

 header('location: ../index.php');

} 
}



// EDITAR PROJETO

if (isset($_POST['upd_Projeto'])) {

	$nomeProjeto = $_POST['nomeProjeto'];
	$instituicao = $_POST['instituicao'];
	$dataIn = $_POST['dataIn'];
	$aplicacao = $_POST['aplicacao'];
	$resumo = $_POST['resumo'];
	$keyword = $_POST['keyword'];
	
	$nomeA1=$_POST['nomeA1'];
	$idadeA1=$_POST['idadeA1'];
	$emailA1=$_POST['emailA1'];
	$lattesA1=$_POST['lattesA1'];
	
	$nomeA2=$_POST['nomeA2'];
	$idadeA2=$_POST['idadeA2'];
	$emailA2=$_POST['emailA2'];
	$lattesA2=$_POST['lattesA2'];
	
	$nomeA3=$_POST['nomeA3'];
	$idadeA3=$_POST['idadeA3'];
	$emailA3=$_POST['emailA3'];
	$lattesA3=$_POST['lattesA3'];	
	
	$nomeO=$_POST['nomeO'];
	$idadeO=$_POST['idadeO'];
	$emailO=$_POST['emailO'];
	$lattesO=$_POST['lattesO'];
	
	$nomeCo=$_POST['nomeCo'];
	$idadeCo=$_POST['idadeCo'];
	$emailCo=$_POST['emailCo'];
	$lattesCo=$_POST['lattesCo'];

/* Projeto */
if((empty($nomeProjeto))||(empty($instituicao))||(empty($dataIn))||(empty($aplicacao))||(empty($resumo))||(empty($keyword))){
	array_push($errorsEdit, "Algum campo dos dados do Projeto está vazio");
}

/* Autor 1 */
if((empty($nomeA1))||(empty($idadeA1))||(empty($emailA1))){
	array_push($errorsEdit, "Algum campo de Autor 1 está vazio"); 
}

/* Autor 2 */
if((!empty($nomeA2))||(!empty($idadeA2))||(!empty($emailA2))||(!empty($lattesA2))){
	if((empty($nomeA2))||(empty($idadeA2))||(empty($emailA2))){
		array_push($errorsEdit, "Algum campo de Autor 2 está vazio.");
	}
}
 
/* Autor 3 */
if((!empty($nomeA3))||(!empty($idadeA3))||(!empty($emailA3))||(!empty($lattesA3))){
	if((empty($nomeA3))||(empty($idadeA3))||(empty($emailA3))){
		array_push($errorsEdit, "Algum campo de Autor 3 está vazio");
	}
}
 
/* Orientador */
if((empty($nomeO))||(empty($idadeO))||(empty($emailO))){
	array_push($errorsEdit, "Algum campo de Orientador está vazio.");
}

/* Coorientador */
if((!empty($nomeCo))||(!empty($idadeCo))||(!empty($emailCo))||(!empty($lattesCo))){
	if((empty($nomeCo))||(empty($idadeCo))||(empty($emailCo))){
		array_push($errorsEdit, "Algum campo de Coorientador está vazio");
	}
}

// ERROR
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
// END ERROR

/* Foto */
 
 if(!empty($_FILES['arquivoFoto2']['size'])){
 
	$_UP['tamanho'] = 5000000; 
	$_UP['extensoesImg'] = array('.png', '.jpg', 'jpeg', '.gif');
		
	$extensao = strtolower(substr($_FILES['arquivoFoto2']['name'],-4));
	if(array_search($extensao, $_UP['extensoesImg'])=== false){		
		array_push($errorsEdit,"Extensão da Imagem é inválida ('.png','.jpg','.jpeg','.gif')");	
	}
	if ($_UP['tamanho'] < $_FILES['arquivoFoto2']['size']){
		array_push($errorsEdit,"Imagem muito grande, máx. 5mb");	
	}
 
 }
  
 if(!empty($_FILES['arquivoDoc12']['size'])){
 
	$_UP['tamanhoDoc1'] = 30000000; 
	$_UP['extensoesDoc1'] = array('.pdf', '.odt');
		
	$extensao = strtolower(substr($_FILES['arquivoDoc12']['name'],-4));
	if(array_search($extensao, $_UP['extensoesDoc1'])=== false){		
		array_push($errorsEdit,"Extensão de arquivo do artigo é inválida ('.pdf', '.odt')");	
	}
	if ($_UP['tamanhoDoc1'] < $_FILES['arquivoDoc12']['size']){
		array_push($errorsEdit,"Artigo muito grande, máx. 30mb");	
	}
 
 }
  
 if(!empty($_FILES['arquivoDoc22']['size'])){
 
	$_UP['tamanhoDoc2'] = 30000000; 
	$_UP['extensoesDoc2'] = array('.pdf', '.odt');
		
	$extensao = strtolower(substr($_FILES['arquivoDoc22']['name'],-4));
	if(array_search($extensao, $_UP['extensoesDoc2'])=== false){		
		array_push($errorsEdit,"Extensão de arquivo do relatório é inválida ('.pdf', '.odt')");	
	}
	if ($_UP['tamanhoDoc2'] < $_FILES['arquivoDoc22']['size']){
		array_push($errorsEdit,"Relatório muito grande, máx. 30mb");	
	}
 
 }

 if(contains_number($nomeA1) == true){
	array_push($errorsEdit,"O campo nome de Autor 1 não pode possuir caracteres numéricos.");
 }
 if(contains_number($nomeA2) == true){
	array_push($errorsEdit,"O campo nome de Autor 2 não pode possuir caracteres numéricos.");
 }
 if(contains_number($nomeA3) == true){
	array_push($errorsEdit,"O campo nome de Autor 3 não pode possuir caracteres numéricos.");
 }
 if(contains_number($nomeO) == true){
	array_push($errorsEdit,"O campo nome de Orientador não pode possuir caracteres numéricos.");
 }
 if(contains_number($nomeCo) == true){
	array_push($errorsEdit,"O campo nome de Coorientador não pode possuir caracteres numéricos.");
 }

	/* verificar se existe projeto com mesmo nome */
	$con = $db->prepare("SELECT * FROM projetos WHERE nomeProjeto = :nomeProjeto  AND idProjeto != :idProjeto AND ID = :idUSER");
	$con->bindValue(':nomeProjeto', $nomeProjeto);
	$con->bindValue(':idProjeto', $_SESSION['idPage']);
	$con->bindValue(':idUSER', $idUsuario);
	$con->execute();

	$count = $con->rowCount();

	if ($count>=1){ 
		array_push($errorsEdit, "Nome de Projeto já Existente");
	}

	if(count($errorsEdit)==0){

		UpdateProjeto($_SESSION['idPage'],$nomeProjeto,$instituicao,$aplicacao,$resumo,$keyword,$dataIn);
			
/* Autor 1 */
	if(isset($_SESSION['nomeA1'])){
		if((!empty($nomeA1))&&(!empty($idadeA1))&&(!empty($emailA1))){
			UpdateAutor($_SESSION['idPage'],$nomeA1, $idadeA1, $emailA1, "Autor 1", $lattesA1);
		}
	}else{
		if((!empty($nomeA1))&&(!empty($idadeA1))&&(!empty($emailA1))){
		InsereAutor($_SESSION['idPage'], $nomeA1, $idadeA1, $emailA1, "Autor 1", $lattesA1);
		}
	}
/* Autor 2 */
	if(isset($_SESSION['nomeA2'])){
		if((!empty($nomeA2))&&(!empty($idadeA2))&&(!empty($emailA2))){
			UpdateAutor($_SESSION['idPage'],$nomeA2, $idadeA2, $emailA2, "Autor 2", $lattesA2);	
		}
	}else{
		if((!empty($nomeA2))&&(!empty($idadeA2))&&(!empty($emailA2))){
			InsereAutor($_SESSION['idPage'], $nomeA2, $idadeA2, $emailA2, "Autor 2", $lattesA2);
		}
	}
		
/* Autor 3 */
	if(isset($_SESSION['nomeA3'])){
		if((!empty($nomeA3))&&(!empty($idadeA3))&&(!empty($emailA3))){
			UpdateAutor($_SESSION['idPage'],$nomeA3, $idadeA3, $emailA3, "Autor 3", $lattesA3);
		}
	}else{
		if((!empty($nomeA3))&&(!empty($idadeA3))&&(!empty($emailA3))){
			InsereAutor($_SESSION['idPage'], $nomeA3, $idadeA3, $emailA3, "Autor 3", $lattesA3);
		}
	}

/* Orientador */
	if(isset($_SESSION['nomeOrientador'])){
		if((!empty($nomeO))&&(!empty($idadeO))&&(!empty($emailO))){
			UpdateAutor($_SESSION['idPage'],$nomeO, $idadeO, $emailO, "Orientador", $lattesO);
		}
	}else{
		if((!empty($nomeO))&&(!empty($idadeO))&&(!empty($emailO))){
			InsereAutor($_SESSION['idPage'], $nomeO, $idadeO, $emailO, "Orientador", $lattesO);
		}
	}
/* Coorientador */

	if(isset($_SESSION['nomeCoorientador'])){ 
		if((!empty($nomeCo))&&(!empty($idadeCo))&&(!empty($emailCo))){
			UpdateAutor($_SESSION['idPage'],$nomeCo, $idadeCo, $emailCo, "Coorientador", $lattesCo);
		}
	}else{
		if((!empty($nomeCo))&&(!empty($idadeCo))&&(!empty($emailCo))){
			InsereAutor($_SESSION['idPage'], $nomeCo, $idadeCo, $emailCo, "Coorientador", $lattesCo);
		}
	}

/* Foto */

	if(isset($_SESSION['nomeFoto'])){
		if(isset($_FILES['arquivoFoto2'])){
		
			$nomeImg = $db->prepare("SELECT nomeFoto FROM upfotos WHERE idProjeto = :idDecod ");
			$nomeImg->bindValue(':idDecod',$_SESSION['idPage']);
			$nomeImg->execute();
	
			foreach($nomeImg as $dI){
				$delFoto = $dI['nomeFoto'];
			}
	
			$nomeFoto = $_FILES['arquivoFoto2']['name'];
			$nomeTempFoto = $_FILES['arquivoFoto2']['tmp_name'];
			$tamanhoFoto = $_FILES['arquivoFoto2']['size'];
	
			UpdateArquivo($_SESSION['idPage'],$nomeProjeto, $nomeFoto,$delFoto, "foto", $tamanhoFoto, $nomeTempFoto);
	
		}
	}else{
	$nomeFoto2= $_FILES['arquivoFoto2']['name'];
	$nomeTempFoto2= $_FILES['arquivoFoto2']['tmp_name'];
	$tamanhoFoto2= $_FILES['arquivoFoto2']['size'];

	InsereArquivo($_SESSION['idPage'], $nomeProjeto , $nomeFoto2 , "foto", $tamanhoFoto2, $nomeTempFoto2);
	}

/* Artigo */
	
	if(isset($_SESSION['nomeArtigo'])){
		if(isset($_FILES['arquivoDoc12'])){

			$nomeDocs1 = $db->prepare("SELECT nomeDoc FROM updocs WHERE idProjeto = :idDecod1 AND tipoArquivo = 'artigo'");
			$nomeDocs1->bindValue(':idDecod1',$_SESSION['idPage']);
			$nomeDocs1->execute();
	
			foreach($nomeDocs1 as $dD1){
				$delDoc1 = $dD1['nomeDoc'];
			}
	
			$nomeDoc1 = $_FILES['arquivoDoc12']['name'];
			$nomeTempDoc1 = $_FILES['arquivoDoc12']['tmp_name'];
			$tamanhoDoc1 = $_FILES['arquivoDoc12']['size'];
	
			UpdateArquivo($_SESSION['idPage'], $nomeProjeto, $nomeDoc1, $delDoc1, "artigo", $tamanhoDoc1, $nomeTempDoc1);
	
		}
	}else{
		$nomeDoc12= $_FILES['arquivoDoc12']['name'];
		$nomeTempDoc12= $_FILES['arquivoDoc12']['tmp_name'];
		$tamanhoDoc12= $_FILES['arquivoDoc12']['size'];
	
		InsereArquivo($_SESSION['idPage'], $nomeProjeto , $nomeDoc12 , "artigo", $tamanhoDoc12, $nomeTempDoc12);
	}

/* Relatorio */

	if(isset($_SESSION['nomeRelatorio'])){
		if(isset($_FILES['arquivoDoc22'])){
			$nomeDocs2 = $db->prepare("SELECT nomeDoc FROM updocs WHERE idProjeto = :idDecod2 AND tipoArquivo = 'relatorio'");
			$nomeDocs2->bindValue(':idDecod2',$_SESSION['idPage']);
			$nomeDocs2->execute();
			
			foreach($nomeDocs2 as $dD2){
				$delDoc2 = $dD2['nomeDoc'];
			}
	
			$nomeDoc2 = $_FILES['arquivoDoc22']['name'];
			$nomeTempDoc2 = $_FILES['arquivoDoc22']['tmp_name'];
			$tamanhoDoc2 = $_FILES['arquivoDoc22']['size'];
	
			UpdateArquivo($_SESSION['idPage'], $nomeProjeto, $nomeDoc2, $delDoc2, "relatorio", $tamanhoDoc2, $nomeTempDoc2);
	
		}
	}else{
		$nomeDoc22= $_FILES['arquivoDoc22']['name'];
		$nomeTempDoc22= $_FILES['arquivoDoc22']['tmp_name'];
		$tamanhoDoc22= $_FILES['arquivoDoc22']['size'];
	
		InsereArquivo($_SESSION['idPage'], $nomeProjeto , $nomeDoc22 , "relatorio", $tamanhoDoc22, $nomeTempDoc22);
	}
		header('location: ../index.php');
	}
}

?>

		
