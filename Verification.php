<?php
include('server.php');
include('send/Send.php');

if (!isset($_SESSION['email'])) {
	$_SESSION['msg'] = "Você deve fazer login primeiro";
	header('location: register.php');
}


if(empty($_SESSION['cod'])){
	$_SESSION['cod']=strtoupper(substr(bin2hex(random_bytes(4)), 1));
	$codigo = $_SESSION['cod'];
	Send($codigo);
}
// echo $_SESSION['cod'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verification</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/verification.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

	<link rel="icon" href="Vetores/Logo.svg">
</head>
<body>

<div class="container-fluid">
<div class="row fundotop">
        <div class="col-md-12 ">
    <div class="topo"> <span class="texto">BLUE</span> </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-12 caixacas">

        <div class="seusdados">
        <h4 class="textt"> Verifique o seu endereço de email  <?php echo $_SESSION['email'];?></h4>
        <form  method="post" action="Verification.php">

            <div class="form-group">

				<label for="verify">Insira o código de verificação:</label>

				<input type="text" name="verify" id="verify" required placeholder=" <?php if(!empty($txtVerify)){echo $txtVerify;} ?>" class="form-control"></input>

            </div>

        <button type="Submit" class="enviar" name="verifica" id="enviar">Enviar</button>
		</form>
		<p>
		<a href="register.php">Voltar</a>
		</p>

            </div>
        </div>
    </div>
</div>
<!-- Jquery têm que ficar acima do bootstrap -->
<script src="js/bootstrapjquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php

?>

</body>
</html>
