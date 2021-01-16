create database Blue;
use Blue;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `senha` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`ID`) )
ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE IF NOT EXISTS `projetos` (
`idProjeto` INT(11) NOT NULL AUTO_INCREMENT,
`nomeProjeto` VARCHAR(150) NOT NULL,
`instituicao` VARCHAR(50) NOT NULL,
`dataProjeto` date NOT NULL,
`areaAplicacao` VARCHAR(45) NOT NULL,
`resumo` VARCHAR(2000) NOT NULL,
`palavraChave` VARCHAR(120) NOT NULL,
`ID` INT(11) NOT NULL,
PRIMARY KEY (`idProjeto`),   
FOREIGN KEY (`ID`)
REFERENCES usuarios (`ID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `updocs`
--

CREATE TABLE IF NOT EXISTS `updocs` (
  `idDoc` int(11) NOT NULL AUTO_INCREMENT,
  `nomeDoc` varchar(600) NOT NULL,
  `DataHora` datetime NOT NULL,
  `tipoArquivo` varchar(10) NOT NULL,
  `idProjeto` int(11) NOT NULL,
  PRIMARY KEY (`idDoc`),
  FOREIGN KEY (`idProjeto`)
  REFERENCES projetos (`idProjeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `upfotos`
--

CREATE TABLE IF NOT EXISTS `upfotos` (
  `idFoto` int(11) NOT NULL AUTO_INCREMENT,
  `nomeFoto` varchar(600) NOT NULL,
  `DataHora` datetime NOT NULL,
  `idProjeto` int(11) NOT NULL,
  PRIMARY KEY (`idFoto`),
  FOREIGN KEY (`idProjeto`)
  REFERENCES projetos (`idProjeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `autor`
--

CREATE TABLE IF NOT EXISTS `autor` (
  `idAutor` INT(11) NOT NULL AUTO_INCREMENT,
  `nomeAutor` VARCHAR(45) NOT NULL,
  `idade` INT(11) NOT NULL,
  `email` VARCHAR(75) NOT NULL,
  `cargo` VARCHAR(45) NOT NULL,
  `lattes` VARCHAR(100) NOT NULL,
  `idProjeto` INT(11) NOT NULL,
  PRIMARY KEY (`idAutor`),
    FOREIGN KEY (`idProjeto`)
    REFERENCES projetos (`idProjeto`))
DEFAULT CHARACTER SET = utf8;

-- --------------------------------------------------------
select * from usuarios;
select * from projetos;
select * from upfotos;
select * from updocs;
select * from autor;

#drop schema Blue;


select * from usuarios as U inner join projetos as P on U.ID = P.ID inner join autor as A on A.idProjeto = P.idProjeto inner join updocs as D on D.idProjeto = P.idProjeto;

