<?php
if(!session_id()){
    session_start();
} else {
    session_regenerate_id(true);
}
// Funçao que pega os dados dos autores do banco de dados e insere em sessões 
function SelectAutor($idProjeto, $cargo, $cargoIn){
    include("../conexao.php");

    $autorEdition = $db->prepare("SELECT * FROM autor WHERE idProjeto= :idPrj AND cargo = :cargo");
    $autorEdition->bindValue(':idPrj',$idProjeto);
    $autorEdition->bindValue(':cargo',$cargoIn);
    $autorEdition->execute();

    foreach($autorEdition as $rA){
        $_SESSION['id'.$cargo] = $rA['idAutor'];
        $_SESSION['nome'.$cargo] = $rA['nomeAutor'];
        $_SESSION['idade'.$cargo] = $rA['idade'];
        $_SESSION['email'.$cargo] = $rA['email'];
        $_SESSION['cargo'.$cargo] = $rA['cargo'];
        $_SESSION['lattes'.$cargo] = $rA['lattes']; 
        $_SESSION['idProjeto'.$cargo] = $rA['idProjeto']; 
    }

    if(($cargo == "A1")&&(!empty($_SESSION['nome'.$cargo]))){
        $valuesA1 = [$_SESSION['id'.$cargo],$_SESSION['nome'.$cargo], $_SESSION['idade'.$cargo],$_SESSION['email'.$cargo],$_SESSION['cargo'.$cargo],$_SESSION['lattes'.$cargo],$_SESSION['idProjeto'.$cargo]];

        return $valuesA1;
    }

    else if(($cargo == "A2")&&(!empty($_SESSION['nome'.$cargo]))){
        $valuesA2= [$_SESSION['id'.$cargo],$_SESSION['nome'.$cargo], $_SESSION['idade'.$cargo],$_SESSION['email'.$cargo],$_SESSION['cargo'.$cargo],$_SESSION['lattes'.$cargo],$_SESSION['idProjeto'.$cargo]];
        
        return $valuesA2;
    }

    else if(($cargo == "A3")&&(!empty($_SESSION['nome'.$cargo]))){
        $valuesA3= [$_SESSION['id'.$cargo],$_SESSION['nome'.$cargo], $_SESSION['idade'.$cargo],$_SESSION['email'.$cargo],$_SESSION['cargo'.$cargo],$_SESSION['lattes'.$cargo],$_SESSION['idProjeto'.$cargo]];
        
        return $valuesA3;
    }

    else if((($cargo == "Coorientador")&&(!empty($_SESSION['nome'.$cargo])))&&(($cargo == "Coorientador")&&(!empty($_SESSION['nome'.$cargo])))){
        $valuesCo= [$_SESSION['id'.$cargo],$_SESSION['nome'.$cargo], $_SESSION['idade'.$cargo],$_SESSION['email'.$cargo],$_SESSION['cargo'.$cargo],$_SESSION['lattes'.$cargo],$_SESSION['idProjeto'.$cargo]];
        
        return $valuesCo;
    }

    else if((($cargo == "Orientador")&&(!empty($_SESSION['nome'.$cargo])))&&(($cargo == "Orientador")&&(!empty($_SESSION['nome'.$cargo])))){
        $valuesO = [$_SESSION['id'.$cargo],$_SESSION['nome'.$cargo], $_SESSION['idade'.$cargo],$_SESSION['email'.$cargo],$_SESSION['cargo'.$cargo],$_SESSION['lattes'.$cargo],$_SESSION['idProjeto'.$cargo]];
        
        return $valuesO;
    }

    else{ return null;}

}

// Função que apaga dados de um determinado autor
function DeletarAutor($idProjeto){
    include("../conexao.php");

    $deleteAutor = $db->prepare("DELETE * FROM autor WHERE idProjeto= :idProjeto");
    $deleteAutor->bindValue(':idProjeto',$idProjeto);
    $deleteAutor->execute();
}
// Função que deleta  um arquivo
function DeletarArquivo($tipo, $nome, $id){
    include("../conexao.php");

    if($tipo=="Foto"){
        $deleteArquivo = $db->prepare("DELETE FROM upfotos WHERE idFoto= :idFoto");
        $deleteArquivo->bindValue(':idFoto' , $id);
        $deleteArquivo->execute();

        array_map('unlink', glob("upload/imgs/$nome")); 
        
    }

    else if($tipo=="Artigo"){
        $deleteArquivo = $db->prepare("DELETE FROM updocs WHERE idDoc= :idArt");
        $deleteArquivo->bindValue(':idArt' , $id);
        $deleteArquivo->execute();

        array_map('unlink', glob("upload/docs/artigo/$nome")); 
    }

    else if($tipo=="Relatorio"){
        $deleteArquivo = $db->prepare("DELETE FROM updocs WHERE idDoc= :idRel");
        $deleteArquivo->bindValue(':idRel' , $id);
        $deleteArquivo->execute();
        
        array_map('unlink', glob("upload/docs/relatorio/$nome")); 

    }
}

// Função que deleta um projeto através do ID
function DeletarProjeto($idProjeto,$idUser){
    include("../conexao.php");
    
    $deleteProjeto = $db->prepare("DELETE FROM projetos WHERE idProjeto= :idProjeto AND ID = :ID");
    $deleteProjeto->bindValue(':idProjeto' , $idProjeto);
    $deleteProjeto->bindValue(':ID' , $idUser);
    $deleteProjeto->execute();
}

// Função que atualiza os dados do Projeto
function UpdateProjeto($idPrj,$nomeProjeto,$instituicao,$area,$resumo,$keyword,$dataIn){
    include("../conexao.php");
    $updateProjeto = $db->prepare("UPDATE projetos SET nomeProjeto = :nomeProjeto , instituicao = :instituicao, dataProjeto = :dataProjeto , areaAplicacao = :area , resumo = :resumo , palavraChave = :keyword  WHERE idProjeto = :idProjeto");
    $updateProjeto->bindValue(':nomeProjeto' , $nomeProjeto);
    $updateProjeto->bindValue(':instituicao' , $instituicao);
    $updateProjeto->bindValue(':dataProjeto' , $dataIn);
    $updateProjeto->bindValue(':area' , $area);
    $updateProjeto->bindValue(':resumo' , $resumo);
    $updateProjeto->bindValue(':keyword' , $keyword);
    $updateProjeto->bindValue(':idProjeto' , $idPrj);
    $updateProjeto->execute();  

}
// Função que atualiza um arquivo , seja ele foto relatório ou artigo
function UpdateArquivo($idPrj, $nomeProjeto, $nomeArquivo, $delArquivo, $tipo, $tamanho, $nomeTemp){
    include("../conexao.php");
    
    $error = array();
    
    if($tipo == "foto"){
    
    $arquivo = $nomeArquivo;
	$_UP['pasta'] = 'upload/imgs/';
	$_UP['tamanho'] = 5000000; 
	$_UP['extensoesImg'] = array('.png', '.jpg', 'jpeg', '.gif');
	$_UP['renomeia'] = true;
        
	$extensao = strtolower(substr($nomeArquivo,-4));
	if(array_search($extensao, $_UP['extensoesImg'])=== false){		
	}
	else if ($_UP['tamanho'] < $tamanho){
    }
	else{
		if($_UP['renomeia'] == true){
            $str = 'a1b2c3d4e5f';
            $key = str_shuffle($str);
			$projeto = $nomeProjeto;
			$nome_final = $projeto."-".$key."-".$nomeArquivo;
		}else{
			$nome_final = $nomeArquivo;
		}
		if(move_uploaded_file($nomeTemp, $_UP['pasta']. $nome_final)){
            $updateImg = $db->prepare("UPDATE upfotos SET nomeFoto = :nomeArquivo , DataHora = NOW() WHERE idProjeto = :idProjeto ");
            $updateImg->bindValue(':nomeArquivo' , $nome_final);
            $updateImg->bindValue(':idProjeto' , $idPrj);
            $updateImg->execute();    
    
            array_map('unlink', glob("upload/imgs/$delArquivo"));
		}else{
		}
	}
    }

    else if($tipo == "artigo"){
    $arquivo = $nomeArquivo;
	$_UP['pastaDoc1'] = 'upload/docs/artigo/';
	$_UP['tamanhoDoc1'] = 30000000; 
	$_UP['extensoesDoc1'] = array('.pdf', '.odt');
	$_UP['renomeiaDoc1'] = true;


	$extensaodoc = strtolower(substr($nomeArquivo,-4));
	if(array_search($extensaodoc, $_UP['extensoesDoc1'])=== false){		
	}
	else if ($_UP['tamanhoDoc1'] < $tamanho){
	}
	else{
		if($_UP['renomeiaDoc1'] == true){
			$str = 'a1b2c3d4e5f';
            $key = str_shuffle($str);
			$projeto = $nomeProjeto;
			$nome_finalDoc1 = $projeto."-".$key."-".$nomeArquivo;
		}else{
			$nome_finalDoc1 = $nomeArquivo;
		}
		if(move_uploaded_file($nomeTemp, $_UP['pastaDoc1']. $nome_finalDoc1)){
            $updateDoc1 = $db->prepare("UPDATE updocs SET nomeDoc = :nomeArquivo , DataHora = NOW() WHERE idProjeto = :idProjeto AND tipoArquivo = :tipoD1 ");
            $updateDoc1->bindValue(':nomeArquivo' , $nome_finalDoc1);
            $updateDoc1->bindValue(':tipoD1' , "artigo");
            $updateDoc1->bindValue(':idProjeto' , $idPrj);
            $updateDoc1->execute();  
            array_map('unlink', glob("upload/docs/artigo/$delArquivo"));
		}else{
		}
	}
    }
    
    else if($tipo == "relatorio"){
        
	$arquivo = $nomeArquivo;
	$_UP['pastaDoc2'] = 'upload/docs/relatorio/';
	$_UP['tamanhoDoc2'] = 30000000; 
	$_UP['extensoesDoc2'] = array('.pdf', '.odt');
	$_UP['renomeiaDoc2'] = true;

	$extensaodoc2 = strtolower(substr($nomeArquivo,-4));
	if(array_search($extensaodoc2, $_UP['extensoesDoc2'])=== false){		
	}
	else if ($_UP['tamanhoDoc2'] < $tamanho){
	}
	else{
		if($_UP['renomeiaDoc2'] == true){
            $str = 'a1b2c3d4e5f';
            $key = str_shuffle($str);
			$projeto = $nomeProjeto;
			$nome_finalDoc2 = $projeto."-".$key."-".$nomeArquivo;
		}else{
			$nome_finalDoc2 = $nomeArquivo;
		}
		if(move_uploaded_file($nomeTemp, $_UP['pastaDoc2']. $nome_finalDoc2)){
		$updateDoc2 = $db->prepare("UPDATE updocs SET nomeDoc = :nomeArquivo , DataHora = NOW() WHERE idProjeto = :idProjeto AND tipoArquivo = :tipoD2 ");
        $updateDoc2->bindValue(':nomeArquivo' , $nome_finalDoc2);
        $updateDoc2->bindValue(':tipoD2' , "relatorio");
        $updateDoc2->bindValue(':idProjeto' , $idPrj);
        $updateDoc2->execute();    
        
        array_map('unlink', glob("upload/docs/relatorio/$delArquivo"));
		}else{
		}
	}
    }

    else{ return null; }

}

//Função que atualiza os valores dos dados dos autores no banco de dados

function UpdateAutor($idPrj,$nomeAutor, $idade, $email, $cargo, $lattes){
    include("../conexao.php");
    if(empty($lattes)){ $lattes="-"; }
    $updateAutor = $db->prepare("UPDATE autor SET nomeAutor = :nomeAutor  , idade = :idade, email = :email , lattes = :lattes WHERE idProjeto = :idProjeto AND cargo = :cargo ");
    $updateAutor->bindValue(':nomeAutor' , $nomeAutor);
    $updateAutor->bindValue(':idade' , $idade);
    $updateAutor->bindValue(':email' , $email);
    $updateAutor->bindValue(':cargo' , $cargo);
    $updateAutor->bindValue(':lattes' , $lattes);
    $updateAutor->bindValue(':idProjeto' , $idPrj);
    $updateAutor->execute();
}


//Função que insere arquivos no Banco de dados e na pasta correspondente

function InsereArquivo($idProjeto, $nomeProjeto, $nomeArquivo, $tipo, $tamanho, $nomeTemp){

    include("../conexao.php");
    
    if($tipo == "foto"){
    
    $arquivo = $nomeArquivo;
	$_UP['pasta'] = 'upload/imgs/';
	$_UP['tamanho'] = 5000000; 
	$_UP['extensoesImg'] = array('.png', '.jpg', 'jpeg', '.gif');
	$_UP['renomeia'] = true;
        
	$extensao = strtolower(substr($nomeArquivo,-4));
	if(array_search($extensao, $_UP['extensoesImg'])=== false){		
        
	}
	else if ($_UP['tamanho'] < $tamanho){
        	
    }
	else{
		if($_UP['renomeia'] == true){
			$str = 'a1b2c3d4e5f';
            $key = str_shuffle($str);
			$projeto = $nomeProjeto;
			$nome_final = $projeto."-".$key."-".$nomeArquivo;
		}else{
			$nome_final = $nomeArquivo;
		}
		if(move_uploaded_file($nomeTemp, $_UP['pasta']. $nome_final)){
			$ins = $db->prepare("INSERT INTO upfotos (nomeFoto,DataHora,idProjeto) VALUES (:nome, NOW(),:idPrj)");
			$ins->bindValue(':nome', $nome_final);
			$ins->bindValue(':idPrj', $idProjeto);
			$ins->execute();
		}else{
           
		}
    }
   
    }

    else if($tipo == "artigo"){
    $arquivo = $nomeArquivo;
	$_UP['pastaDoc1'] = 'upload/docs/artigo/';
	$_UP['tamanhoDoc1'] = 30000000; 
	$_UP['extensoesDoc1'] = array('.pdf', '.odt');
	$_UP['renomeiaDoc1'] = true;


	$extensaodoc = strtolower(substr($nomeArquivo,-4));
	if(array_search($extensaodoc, $_UP['extensoesDoc1'])=== false){		
	}
	else if ($_UP['tamanhoDoc1'] < $tamanho){
	}
	else{
		if($_UP['renomeiaDoc1'] == true){
            $str = 'a1b2c3d4e5f';
            $key = str_shuffle($str);
			$projeto = $nomeProjeto;
			$nome_finalDoc1 = $projeto."-".$key."-".$nomeArquivo;
		}else{
			$nome_finalDoc1 = $nomeArquivo;
		}
		if(move_uploaded_file($nomeTemp, $_UP['pastaDoc1']. $nome_finalDoc1)){
			$ins = $db->prepare("INSERT INTO updocs (nomeDoc,DataHora,tipoArquivo,idProjeto) VALUES (:nomeDoc1, NOW(),'artigo',:idPrj)");
			$ins->bindValue(':nomeDoc1', $nome_finalDoc1);
			$ins->bindValue(':idPrj', $idProjeto);
			$ins->execute();
		}else{
		}
	}
    }
    
    else if($tipo == "relatorio"){
        
	$arquivo = $nomeArquivo;
	$_UP['pastaDoc2'] = 'upload/docs/relatorio/';
	$_UP['tamanhoDoc2'] = 30000000; 
	$_UP['extensoesDoc2'] = array('.pdf', '.odt');
	$_UP['renomeiaDoc2'] = true;

	$extensaodoc2 = strtolower(substr($nomeArquivo,-4));
	if(array_search($extensaodoc2, $_UP['extensoesDoc2'])=== false){		
	}
	else if ($_UP['tamanhoDoc2'] < $tamanho){
	}
	else{
		if($_UP['renomeiaDoc2'] == true){
			$str = 'a1b2c3d4e5f';
            $key = str_shuffle($str);
			$projeto = $nomeProjeto;
			$nome_finalDoc2 = $projeto."-".$key."-".$nomeArquivo;
		}else{
			$nome_finalDoc2 = $nomeArquivo;
		}
		if(move_uploaded_file($nomeTemp, $_UP['pastaDoc2']. $nome_finalDoc2)){
			$ins = $db->prepare("INSERT INTO updocs (nomeDoc,DataHora,tipoArquivo,idProjeto) VALUES (:nomeDoc2, NOW(),'relatorio',:idPrj)");
			$ins->bindValue(':nomeDoc2', $nome_finalDoc2);
			$ins->bindValue(':idPrj', $idProjeto);
			$ins->execute();
		}else{
            
		}
	}
    }
    else{ return null; }
 
}

function InsereAutor($idPrj, $nomeAutor, $idade, $email, $cargo, $lattes){
    include("../conexao.php");
    if(empty($lattes)){ $lattes="-"; }
    $insAutor = $db->prepare("INSERT INTO autor (nomeAutor, idade, email, cargo, lattes, idProjeto) VALUES(:nomeAutor, :idade, :email, :cargo, :lattes, :idProjeto)");

    $insAutor->bindValue(':nomeAutor' , $nomeAutor);
    $insAutor->bindValue(':idade' , $idade);
    $insAutor->bindValue(':email' , $email);
    $insAutor->bindValue(':cargo' , $cargo);
    $insAutor->bindValue(':lattes' , $lattes);
    $insAutor->bindValue(':idProjeto' , $idPrj);
    $insAutor->execute();
}

function contains_number($string){
    $number = is_numeric(filter_var($string, FILTER_SANITIZE_NUMBER_INT));

    if($number == true){
        return true;
    }else { return null; }
 }


?>