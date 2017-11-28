<?php
	session_start();
	ini_set('default_charset','UTF-8');

	$strNomeServer = "localhost";
	$strNomeUsuario = "root";
	$strSenha = "usbw";
	$strDBnome = "Educatio";

	//Cria conexão
	$conn = new mysqli($strNomeServer, $strNomeUsuario, $strSenha);
	//Verifica conexão
	if ($conn->connect_error) {
   		die("Falha na conexão: " . $conn->connect_error."<br>");
	}

	//Variável para verificar o Campus dos departamentos
	$strCampi = $_GET['strCampi'];
	$strSQL = $conn->query("SELECT id, nome FROM `Educatio`.`campi` WHERE nome ='".$strCampi."'");
	while($arrLinha = $strSQL->fetch_assoc()) {
		$intIdCampi = $arrLinha['id'];
	}

	//Função de exclusão de departamento
	function excluirDepartamento($strVar) {

		//Cria conexão
		$conn = new mysqli('localhost', 'root', "usbw");
		//Verifica conexão
		if ($conn->connect_error) {
			die("Falha na conexão: " . $conn->connect_error."<br>");
		}

		//Parâmetro em SQL  		
		@$strSQL = "UPDATE `Educatio`.`deptos` SET ativo = 'N' WHERE nome = '".$strVar."'";
		
		//Verifica se o Departamento foi "excluido"
		 if ($conn->query($strSQL) === TRUE) {
			echo "<script>
					alert('Deparatamento deletado com sucesso');
					window.location.href ='../../Entrada/gerencia-web-interface-coordenador.php?acao=removerDepartamento'
				</script>";
		} else {
			echo "<script>alert('Erro deletando o Departamento: ".$conn->error."')</script>";
		}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Excluir Departamento</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<!-- CSS do Bootstrap -->
	  <link href="../../../Estaticos/Bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	  <link href="../../../Estaticos/Bootstrap/css/bootstrap.css" rel="stylesheet"/>

	  <!-- Arquivos js -->
	  <script src="../../../Estaticos/Bootstrap/js/popper.js"></script>
	  <script src="../../../Estaticos/Bootstrap/js/jquery-3.2.1.js" type="text/javascript"></script>
	  <script src="../../../Estaticos/Bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

	  <!-- Fontes e icones -->
	  <link href="../../../Estaticos/Bootstrap/css/nucleo-icons.css" rel="stylesheet">
	  <link href="https://fonts.googleapis.com/css?family=Abel|Inconsolata" rel="stylesheet">

	  <style type="text/css">
        .text-center{
           font-family: 'Abel', sans-serif;
           color: #d8ac29;
        }
        .fonteTexto{
           font-family: 'Inconsolata', monospace;
           font-size: 16px;
        }
        .btn-info {
          background-color: #162e87;
          border-color: #162e87;
          color: #FFFFFF;
          opacity: 1;
          filter: alpha(opacity=100);
        }
        .btn-info:hover, .btn-info:focus, .btn-info:active, .btn-info.active, .show > .btn-info.dropdown-toggle {
          background-color: #11277a;
          color: #FFFFFF;
          border-color: #11277a;
        }
      </style>


</head>
<body>
<?php require "../../Menu-Rodape-Secundarios/caso-2/gerencia-web-menu-interface-coordenador.php"; ?>
<div class="wrapper">
	<div class="container">
		<div class="col-md-8 ml-auto mr-auto">

			<h1 class="text-center">Excluir Departamento</h1>

			<form action="" method="POST" class="contact-form">

			<div class="input-group">
					<span class="input-group-addon"><i class="nc-icon nc-bank"></i></span>
					<input type="text" name="Opc" id="txt_consulta" placeholder="Digite o Nome do Departamento que será Excluído" class="form-control" required='required'>
				</div>							
				
				<table class="table table-hover" required='required' id="tabela">
					<!-- Pega os dados do banco e coloca no select -->
					<?php $strSQL = $conn->query("SELECT id, nome, idCampi, ativo FROM `Educatio`.`deptos` WHERE idCampi = '".$intIdCampi."'"); ?>	
					<?php while($arrLinha = $strSQL->fetch_assoc()) { ?>
						<?php if ($arrLinha['ativo'] != 'N') {?>	
							<?php echo "<tr value='".$arrLinha['nome']."' onclick('document.getElementById('txt_consulta').value = document.getElementById(this).innerHTML')><th>".$arrLinha['nome']."</th>";?>
					<?php }} ?>
				</table>

				<!-- Filtro da Tabela -->
				<script>
 					$('input#txt_consulta').quicksearch('table#tabela tbody tr');
				</script>
				
				<!-- Função de clique na tabela -->
				<script>
					$(document.getElementById("tabela")).ready(function() {
						$('tr').click(function () { 
							document.getElementById("txt_consulta").value = $(this).attr("value");
						});
					});
				</script>

				<div class="row">
					<div class="col-md-4 ml-auto mr-auto">
						<input type="submit" name="Excluir" value="Excluir" class="btn btn-info">
						<button class="btn btn-info" onClick="window.location.href ='../../Entrada/gerencia-web-interface-coordenador.php?acao=removerDepartamento'">Voltar</button>
					</div>
				</div>	

			</form>

		</div>
	</div>
	<?php require "../../Menu-Rodape-Secundarios/caso-1/gerencia-web-rodape-caso-2.php"; ?>
</div>

</body>
</html>
<?php

	//Recebe o Dado do Form
	@$strOpc = $_POST['Opc'];
	$intId = 0;

	//Pega o id com departamento escolhido
	$strSQL = $conn->query("SELECT id,ativo FROM `Educatio`.`deptos` WHERE nome ='".$strOpc."'");	
	while($arrLinha2 = $strSQL->fetch_assoc()) {
		if ($arrLinha2['ativo'] != 'N') {
			$intId = $arrLinha2['id'];
		}
	}

	//Verifica se o botão Excluir foi clicado
	if (isset($_POST['Excluir'])) {
		
		//Parâmetro em SQL
		$strSQL = "SELECT nome FROM `Educatio`.`cursos` WHERE idDepto = '".$intId."' AND ativo = 'S'";
		$strSQL1 = "SELECT nome FROM `Educatio`.`funcionario` WHERE idDepto = '".$intId."' AND ativo = 'S'";

		//Verifica se existem funcionarios ou cursos ativos no dpartamento
		if(mysqli_num_rows($conn->query($strSQL)) != 0 || mysqli_num_rows($conn->query($strSQL1)) != 0){
			echo "<script>alert('Não foi possível excluir o Departamento. Existem Cursos ativos nele.);</script>";
		}else{
			excluirDepartamento($strOpc);
		}	
	}
	
	//Fecha a conexão
	$conn->close();

?>