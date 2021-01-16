<?php include('server.php');
if(isset($_SESSION['cod'])){
	$_SESSION['cod']="";
} //Limpa o cod captcha

?>
<!DOCTYPE html>
<html>
<head>
    <title>Blue Cadastro</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/cadastro.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

	<link rel="icon" href="Vetores/Logo.svg">
</head>
<body>
<div class="container-fluid">
<div class="row fundotop">
        <div class="col-md-12 ">


    <div class="topo"> <span class="texto">CADASTRO</span> </div>
        </div>
</div>
    <div class="row">
        <div class="col-md-12 caixacas">


        <div class="seusdados">
     <h1 id="titleform" >Seus Dados </h1>
        <form method="post" action="register.php">

            <div class="form-group">

                <label for="nome">Nome Completo:</label>
                <input type="text" name="nome" id="nome" class="form-control"  value="<?php echo $username; ?>" required placeholder="<?php if(!empty($txtNome)){echo $txtNome;} ?>"></input>
            </div>

            <div class="form-group">


                <label for="email">Email:</label>
				<input type="email" name="email" id="email" class="form-control" value="<?php if(empty($txtEmail)){echo $email;}?>" required placeholder="<?php if(!empty($txtEmail)){echo $txtEmail;}else{echo "example@dominio.com";}  ?>"></input>
            </div>
            <div class="form-group">


                <label for="senha">Senha:</label>
				<input type="password" name="password_1" id="senha" class="form-control" required	placeholder=" <?php if(!empty($txtSenha)){echo $txtSenha;} ?>"></input>
            </div>
            <div class="form-group">


                <label for="confirmsenha">Confirmar Senha:</label>
                <input type="password" name="password_2" id="confirmarsenha" class="form-control" required  placeholder=" <?php if(!empty($txtSenha)){echo $txtSenha;} ?>"> </input>
            </div>
            <div class="form-group">

               <figure class="imagemcap">

			   <img src="captcha/captcha.php" alt="#CAPTCHA_ERROR" class="imagemcap">

                </figure>
        </div>
            <div class="form-group">


            <label for="captcha">Código captcha:</label>
            <input type="captcha" name="captcha" id="captcha" class="form-control" required placeholder=" <?php if(!empty($txtCaptcha)){echo $txtCaptcha;}else{echo "Código Captcha";} ?>"> </input>
		</div>


        <a href="login.php">Já é cadastrado? Logar</a>
        <button type="Submit" class="buttom" name="reg_user">Salvar Cadastro</button>
        </form>

            </div>
        </div>
    </div>
</div>

<script src="js/bootstrapjquery.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>


</html>
