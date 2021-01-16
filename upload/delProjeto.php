<?php

$separaigual = explode("?", $_SERVER["REQUEST_URI"]);
if(!empty($separaigual[1])&&(!isset($separaigual[2]))){
    $idprojeto = $separaigual[1];
    $idprjdec = base64_decode($idprojeto);
    ApagarProjeto($idprjdec);
} 
else if((!empty($separaigual[1]))&&!empty($separaigual[2])){
    $tipoArq1 = $separaigual[1];
    $tipoArq = base64_decode($tipoArq1);
    $idArquivo1 = $separaigual[2];
    $idArquivo = base64_decode($idArquivo1);
    if($tipoArq=="relatorio"){
        
        ApagarArquivo($tipoArq,$idArquivo);
 }
    if(($tipoArq=="foto")||($tipoArq=="artigo")||($tipoArq=="relatorio")){
        ApagarArquivo($tipoArq,$idArquivo);
    } 
    if(($tipoArq=="autor2")||($tipoArq=="autor3")||($tipoArq=="coorientador")){
        ApagarAutor($idArquivo);
    }else{
        // header('location: ../index.php');
    }
}else{ header('location: ../index.php');}


// #######################################
// ######### ApagarProjeto ###############
// #######################################


function ApagarProjeto($idprjdec){

include("funcao.php");
include('../conexao.php');

if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
	$senhaU = $_SESSION['senha'];

	$ConfIdUser1=$db->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
	$ConfIdUser1->bindValue(':email',$email);
	$ConfIdUser1->bindValue(':senha',$senhaU);
	$ConfIdUser1->execute();

	foreach($ConfIdUser1 as $rCI){
		$idUsuario = $rCI['ID'];
	}
}

$ConfUser = $db->prepare("SELECT * FROM projetos WHERE idProjeto= :idProjeto AND ID = :idUs");
$ConfUser->bindValue(':idProjeto',$idprjdec);
$ConfUser->bindValue(':idUs',$idUsuario);
$ConfUser->execute();

foreach($ConfUser as $ConfU){
	$idprjdec= $ConfU['idProjeto'];
	$idU = $ConfU['ID'];
}

if(isset($idU)){
	if($idUsuario != $idU){
		echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\"); 
		if(a == true){		
		window.location.href = \"../index.php\";
		}else{ window.location.href = \"../index.php\"; }
		</script>";
	}else{
        // EXCLUIR PROJETO
        
        /* Foto */
        $SelecFoto = $db->prepare("SELECT * FROM upfotos WHERE idProjeto = :idProjeto");
        $SelecFoto->bindValue(':idProjeto' , $idprjdec);
        $SelecFoto->execute();

        foreach($SelecFoto as $sF){
            $nomeF=$sF['nomeFoto'];
            $idFoto=$sF['idFoto'];
        }
    /* Artigo */
        $SelecArt = $db->prepare("SELECT * FROM upDocs WHERE idProjeto = :idProjeto AND tipoArquivo = 'artigo'");
        $SelecArt->bindValue(':idProjeto' , $idprjdec);
        $SelecArt->execute();

        foreach($SelecArt as $sA){
            $nomeA=$sA['nomeDoc'];
            $idArtigo=$sA['idDoc'];
        }
    /* Relatorio */
        $SelecRel = $db->prepare("SELECT * FROM upDocs WHERE idProjeto = :idProjeto AND tipoArquivo = 'relatorio'");
        $SelecRel->bindValue(':idProjeto' , $idprjdec);
        $SelecRel->execute();

        foreach($SelecRel as $sR){
            $nomeR=$sR['nomeDoc'];
            $idRel=$sR['idDoc'];
        }

    /* DELETANDO ARQUIVOS */

    if(isset($nomeF)){
        DeletarArquivo("Foto", $nomeF, $idFoto); 
    }
    if(isset($nomeA)){
        DeletarArquivo("Artigo", $nomeA, $idArtigo);
    }
    if(isset($nomeR)){
        DeletarArquivo("Relatorio", $nomeR, $idRel);
    }

    /* DELETANDO AUTORES */

    $DelAutores = $db->prepare("DELETE FROM autor WHERE idProjeto= :idProjeto");
    $DelAutores->bindValue(':idProjeto' , $idprjdec);
    $DelAutores->execute();

    /* DELETANDO Projeto */

    DeletarProjeto($idprjdec,$idUsuario);

    header('location: ../index.php');
    }
}else{
	echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\"); 
		if(a == true){		
		window.location.href = \"../index.php\";
		}else{ window.location.href = \"../index.php\"; }
		</script>";
}

}

// #######################################
// ######### ApagarAutor  ################
// #######################################


function ApagarAutor($idAutor){
    include("funcao.php");
    include('../conexao.php');
 
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        $senhaU = $_SESSION['senha'];
    
        $ConfIdUser1=$db->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
        $ConfIdUser1->bindValue(':email',$email);
        $ConfIdUser1->bindValue(':senha',$senhaU);
        $ConfIdUser1->execute();
    
        foreach($ConfIdUser1 as $rCI){
            $idUsuario = $rCI['ID'];
        }
    }
    
    $ConfUser = $db->prepare("SELECT * FROM autor WHERE idAutor= :idAutor");
    $ConfUser->bindValue(':idAutor' , $idAutor);
    $ConfUser->execute();
    
    foreach($ConfUser as $ConfU){
        $idprj= $ConfU['idProjeto'];
    }

    if(isset($idprj)){
        $ConfUser = $db->prepare("SELECT * FROM projetos WHERE idProjeto= :idProjeto AND ID = :idUs");
        $ConfUser->bindValue(':idProjeto',$idprj);
        $ConfUser->bindValue(':idUs',$idUsuario);
        $ConfUser->execute();

        foreach($ConfUser as $ConfU){
            $idprjdec= $ConfU['idProjeto'];
            $idU = $ConfU['ID'];
        }

    }
    
    if(isset($idU)){
        if($idUsuario != $idU){
            echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\"); 
            if(a == true){		
            window.location.href = \"../index.php\";
            }else{ window.location.href = \"../index.php\"; }
            </script>";
        }else{
            /* DELETANDO AUTORES */
            $DelAutores = $db->prepare("DELETE FROM autor WHERE idAutor= :idAutor");
            $DelAutores->bindValue(':idAutor' , $idAutor);
            $DelAutores->execute();

            header('location: ../index.php');
        }
    }else{
        echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\"); 
            if(a == true){		
            window.location.href = \"../index.php\";
            }else{ window.location.href = \"../index.php\"; }
            </script>";
    }
    
}


// #######################################
// ######### ApagarArquivo  ##############
// #######################################

function ApagarArquivo($tipo, $idArquivo){

    include("funcao.php");
    include('../conexao.php');

    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        $senhaU = $_SESSION['senha'];
    
        $ConfIdUser1=$db->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
        $ConfIdUser1->bindValue(':email',$email);
        $ConfIdUser1->bindValue(':senha',$senhaU);
        $ConfIdUser1->execute();
    
        foreach($ConfIdUser1 as $rCI){
            $idUsuario = $rCI['ID'];
        }
    }
    if($tipo == "foto"){
        $ConfUser = $db->prepare("SELECT * FROM upfotos WHERE idFoto= :idDoc");
        $ConfUser->bindValue(':idDoc' , $idArquivo);
        $ConfUser->execute();

        foreach($ConfUser as $ConfU){
            $idprj= $ConfU['idProjeto'];
            $nomeF=$ConfU['nomeFoto'];
            $idFoto=$ConfU['idFoto'];
        }
    }
    if($tipo == "artigo"){
        $ConfUser = $db->prepare("SELECT * FROM updocs WHERE idDoc= :idDoc AND tipoArquivo = 'artigo'");
        $ConfUser->bindValue(':idDoc' , $idArquivo);
        $ConfUser->execute();

        foreach($ConfUser as $ConfU){
            $idprj= $ConfU['idProjeto'];
            $nomeA= $ConfU['nomeDoc'];
            $idArtigo= $ConfU['idDoc'];
        }
    }
    if($tipo == "relatorio"){
        $ConfUser = $db->prepare("SELECT * FROM updocs WHERE idDoc= :idDoc AND tipoArquivo = 'relatorio'");
        $ConfUser->bindValue(':idDoc' , $idArquivo);
        $ConfUser->execute();

        foreach($ConfUser as $ConfU){
            $idprj= $ConfU['idProjeto'];
            $nomeR=$ConfU['nomeDoc'];
            $idRel=$ConfU['idDoc'];
        }
    }
   

    if(isset($idprj)){
        $ConfUser = $db->prepare("SELECT * FROM projetos WHERE idProjeto= :idProjeto AND ID = :idUs");
        $ConfUser->bindValue(':idProjeto',$idprj);
        $ConfUser->bindValue(':idUs',$idUsuario);
        $ConfUser->execute();

        foreach($ConfUser as $ConfU){
            $idprjdec= $ConfU['idProjeto'];
            $idU = $ConfU['ID'];
        }

    }
    if(isset($idU)){
        if($idUsuario != $idU){
            echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\"); 
            if(a == true){		
                window.location.href = \"../index.php\";
            }else{ window.location.href = \"../index.php\"; }
            </script>";
        }else{
            /* Foto */
            if($tipo == "foto"){
                if(isset($nomeF)){
                    DeletarArquivo("Foto", $nomeF, $idFoto); 
                    header('location: ../index.php');
                }
            }
    
            /* Artigo */
            if($tipo == "artigo"){
                
                if(isset($nomeA)){
                    DeletarArquivo("Artigo", $nomeA, $idArtigo);
                    header('location: ../index.php');
                }
                
            }
            
            /* Relatorio */
            if($tipo == "relatorio"){        
                if(isset($nomeR)){
                    DeletarArquivo("Relatorio", $nomeR, $idRel);
                    header('location: ../index.php');
                }
                
            }
        }
        }else{
                echo "<script> let a = window.confirm(\"Você precisa de permissão para acessar esse arquivo\"); 
                    if(a == true){		
                    window.location.href = \"../index.php\";
                    }else{ window.location.href = \"../index.php\"; }
                    </script>";
        }
    }

    

?>