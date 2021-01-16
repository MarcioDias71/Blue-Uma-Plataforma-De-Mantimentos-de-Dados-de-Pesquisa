<html style="Background-color:#2D9CDB">
<div style=" background: rgba(255,255,255,0.9); border-radius: 20px; margin: 2vw; padding: 50px;">

<img src="https://ik.imagekit.io/nzb0ynspmxs/Logo_2SglDgEbx.svg" alt="Blue" style="width: 20vw; margin-left: calc(38vw - 50px)">

<h1 align="center" style="color:Blue">Olá, vamos começar!</h1><br>

<p align="justify">Bem-vinda(o) ao Blue, aqui quem fala é um de seus desenvolvedores. Está afim de testar essa ferramenta? então vamos aos primeiros passos de configurações!</p>

<p align="justify"><strong style="color:Blue">1º passo: </strong> Confira se já possui a biblioteca "PHP GD e GD2". Caso vá fazer um teste local, o XAMPP a possui como padrão em versões como a 7.4.</p>

<p align="justify"><strong style="color:Blue">2º passo: </strong> Execute o código presente em BancoDados/<a style="color: black" href="https://github.com/GabrielTeixeira28/Blue/blob/master/BancoDados/Blue.sql">Blue.sql<a/> em sua plataforma de gerenciamento de banco de dados, para o caso foi utilizado a MySQL Workbench.</p>

<p align="justify"><strong style="color:Blue">3º passo: </strong> Ainda sobre o banco de dados, acesse o código da página <a style="color: black" href="https://github.com/GabrielTeixeira28/Blue/blob/master/conexao.php">conexao.php</a> e altere o user e senha para o de seu uso, se necessário o host também!</p>

<p align="justify"><strong style="color:Blue">4º passo: </strong> Após ter seu banco de dados conectado, insira o email de emissão (este será responsável por mandar o código de verificação para os usuários) e a senha deste email nos locais indicados respectivamente por: "email-emisso" e "senhaEmail", nas linhas respectivas: 26, 27, 32. Faça isso no código do arquivo send/<a style="color: black" href="https://github.com/GabrielTeixeira28/Blue/blob/master/send/Send.php">Send.php</a>.</p>

</div>

</html>
