<?php


class professor{

    public $intSiape;
    public $intDepto;    
    public $StringNome;
    public $StringTitulacao;   
    public $StringAtivo = "";
    public $StringHierarquia = "Professor";
    public $StringSenha;
    public $Foto;

    public $StringDeterminante;
    public $StringDeterminado;


    function adicionaProfessor($intSiape, $intDepto, $StringNome, $StringTitulacao, $StringAtivo, $StringHierarquia, $StringSenha, $Foto){

    	//Abre a conexão com o banco de dados

		$sqlConexao = mysqli_connect("localhost", "root", "usbw", "educatio");
		if (!$sqlConexao) {
			die("Conexão falhou: " . mysqli_connect_error());
		}


		$sqlAdicionaProfessor = "INSERT INTO funcionario ( idSiape, idDepto, nome, titulacao, hierarquia, senha, foto, ativo) values ( '$intSiape', '$intDepto', '$StringNome', '$StringTitulacao', '$StringHierarquia', '$StringSenha', '$Foto', '$StringAtivo')";
		if ($result = mysqli_query($sqlConexao, $sqlAdicionaProfessor)) {		
		}else{
			echo "Erro: " . $sqlAdicionaProfessor . "<br>" . $sqlConexao->error;
		}
    }

    function deletaProfessor($StringDeterminante, $StringDeterminado){

    	//Abre a conexão com o banco de dados

		$sqlConexao = mysqli_connect("localhost", "root", "usbw", "educatio");
		if (!$sqlConexao) {
			die("Conexão falhou: " . mysqli_connect_error());
		}

		$sqlDeletaProfessor = " UPDATE funcionario SET ativo = 'N' WHERE $StringDeterminante  = '$StringDeterminado'";
		if (mysqli_query($sqlConexao, $sqlDeletaProfessor)) {
			echo "profesoordeletado<br>";
		}
		else{
			echo "Erro ao deletar o professor: " . mysqli_error($sqlConexao);
		}


    }

    function alteraProfessor($StringDeterminante, $StringDeterminado, $StringCampo, $StringValor){

    	//Abre a conexão com o banco de dados

		$sqlConexao = mysqli_connect("localhost", "root", "usbw", "educatio");
		if (!$sqlConexao) {
			die("Conexão falhou: " . mysqli_connect_error());
		}

    	$sqlAlteraProfessor = " UPDATE funcionario SET $StringCampo = '$StringValor'  WHERE $StringDeterminante  = '$StringDeterminado'";
		if (mysqli_query($sqlConexao, $sqlAlteraProfessor)) {
		
		}
		else{
			echo "Erro ao alterar o professor: " . mysqli_error($sqlConexao);
		}
    }

    function pesquisaProfessor ($StringDeterminante, $StringDeterminado){

   		// Abre a conexão com o banco de dados

		$sqlConexao = mysqli_connect("localhost", "root", "usbw", "educatio");
		if (!$sqlConexao) {
			die("Conexão falhou: " . mysqli_connect_error());
		}	
	
		$sql = "SELECT * FROM funcionario WHERE $StringDeterminante = '$StringDeterminado '";

		$resultado = $sqlConexao->query($sql);	

		   session_start();

       		$row = $resultado->fetch_assoc();
    		$_SESSION['idSIAPE'] = $row["idSIAPE"];
   			$_SESSION['idDepto'] = $row["idDepto"];  
   			$_SESSION['nome'] = $row["nome"];
   			$_SESSION['titulacao'] = $row["titulacao"];  
  			$_SESSION['ativo'] = $row["ativo"];
   			$_SESSION['hierarquia'] = $row["hierarquia"];
  			$_SESSION['senha'] = $row["senha"];		    	
    	
	}	
}
	
	 session_start();
	
    $professorProf = new professor;  

    
    $professorProf -> alteraProfessor('nome', $_SESSION['nome'], 'titulacao', $_POST["titulacao"]);
    $professorProf -> alteraProfessor('nome', $_SESSION['nome'], 'idSIAPE', $_POST["idSIAPE"]);
    $professorProf -> alteraProfessor('nome', $_SESSION['nome'], 'idDepto', $_POST["idDepto"]);
    $professorProf -> alteraProfessor('nome', $_SESSION['nome'], 'senha', $_POST["senha"]);
    $professorProf -> alteraProfessor('nome', $_SESSION['nome'], 'nome', $_POST["nome"]);

	echo "<script>location.href='../../Entrada/gerencia-web-interface-coordenador.php?acao=professores';</script>";

?>