<?php include('server.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Blue Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/login.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

	<link rel="icon" href="Vetores/Logo.svg">
</head>


	<body>
<div class="container-fluid">
  <div class="row fundotop">

  <div class="col-md-12">

<div class="topo"> <h1 class="texto">Login</h1> </div>
</div>
</div>

    <div class="row">



  <div class="col-md-12 caixacas" >

        <div class="seusdados">

        <form method="post" action="login.php">

          <div class="form-group">
                <label for="email">Email:</label> <br>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" required></input> <br>
            </div>
            <div class="form-group">


                <label for="senha">Senha:</label> <br>
                <input type="password" name="password" id="password" class="form-control" required></input> <br>

                <?php if (count($errors) > 0) : ?>
                  <div class="error">
                    <?php foreach ($errors as $error) : ?>
                      <?php echo "<p style='color:red'>$error</p>"; ?>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

            </div>



        <a href="register.php">Não é cadastrado ainda? Cadastra-se</a><br><br>
		<button type="Submit" class="buttom"  id="cadastrar" name="login_user">Fazer login</button>

        </form>

            </div>
        </div>
    </div>
</div>

<script src="js/bootstrapjquery.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
