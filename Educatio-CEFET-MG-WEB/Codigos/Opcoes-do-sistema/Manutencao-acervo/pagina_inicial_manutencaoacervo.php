<!DOCTYPE html>
<html>
<head>
	
	<!-- CSS do Bootstrap -->

	<!-- CSS do grupo -->
	 <link href="../Opcoes-do-sistema/Manutencao-acervo/pagina_inicial.css" rel="stylesheet" />

	<!-- Arquivos js -->

	<!-- Fontes e icones -->

		<script type="text/javascript">
		function func1(){
			window.location.href="../Opcoes-do-sistema/Manutencao-acervo/menu_switch_obras.php"
		}


    	function enviaFormulario(valor, valor2){
				document.querySelector("#valorCPFID").value = valor;
				document.querySelector("#valorCPFID2").value = valor2;
				document.querySelector("#formulario").submit();
			
			}
			
			//funcao utilizada para apagar um input
			function Apaga(id){
				document.querySelector("#" +id).value = "";
			}
			
			//funcao utilizada para fazer uma requisicao a pagina ProcuraAlunos.php, esta que devolvera alguns dados de TODOS os alunos e estes dados 
			//serao mostrados na tabela
			function escreveNomes(str){
				if (str.length == 0){
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("tabela").innerHTML = this.responseText;
						}
					};
					xmlhttp.open("GET", "../Opcoes-do-sistema/Manutencao-acervo/lista_inteligente_acervo.php?q=mostrar", true);
					xmlhttp.send();
				}
			}''
			
			//funcao utilizada para fazer uma requisicao a pagina ProcuraAlunos.php, onde serao pesquisados os alunos que possuam 'str' em seu nome/cpf, 
			//e alguns dados desses alunos serao devolvidos e mostrados na tabela
			function mostraAlunos(str, tipo) {
				str = str.toString();
				if (str.length == 0) { 
					escreveNomes(str);
					return;
				} else {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("tabela").innerHTML = this.responseText;
						}
					};
					xmlhttp.open("GET", "../Opcoes-do-sistema/Manutencao-acervo/lista_inteligente_acervo.php?q=" + str + "&tipo=" + tipo, true);
					xmlhttp.send();
				}
			}
	</script>

	<title></title>
</head>
<body onload = "escreveNomes('')">

	<div class="wrapper">
		<div class="title" style="text-align: center;">
			<h1><b>Manutenção de Acervo</b></h1>
		</div>
			<p id="p1">Crie, edite e exclua obras do acervo</p>
		<div class="container">
			<h5>Pesquise obras no acervo</h5>
	  			<form method = "POST" action = "../Opcoes-do-sistema/Manutencao-acervo/selecionaqualeditar.php" id="formulario">
					<!-- A funcao Apaga() serve para sempre que um input text for focado, o outro input text apagar, assim prevenindo erros -->
					<section class = "TamanhoDosCampos" id = "DIVentradaNomeID">
						<!-- Input para pesquisar pelo nome do aluno. A funcao escreveNomes() eh chamada sempre que ele for focado para assim enviar o valor "" 
						(nulo) e mostrar a tabela com todos os alunos. A funcao mostraAlunos() eh utilizada para escrever a tabela com os alunos pesquisados -->
						<input type = "text" class = "form-control" name = "entradaNome" id = "entradaNomeID" placeholder = "Digite o nome" 
						onfocus = "Apaga('entradaCPFID') ; escreveNomes(this.value)" onkeyup="mostraAlunos(this.value,'nome')">
						<p>
					</section>
					
					<!-- Input para pesquisar pelo CPF do aluno -->
					
					
					<!-- Input do tipo hidden utilizado para armazenar o numero de CPF do aluno em que o usuario clicar, e entao ser enviado para a pagina 
					de alteracao -->
					<div class = "TamanhoDosCampos">
						<input type = "hidden" class = "form-control" name = "valorCPF" id = "valorCPFID" >
					</div>
					<div class = "TamanhoDosCampos">
						<input type = "hidden" class = "form-control" name = "valorCPF2" id = "valorCPFID2" >
					</div>
				</form>
			
			<!-- tabela com os alunos -->
				<div class = "TamanhoDosCampos">
					<table id="tabela" class = "table table-hover"></table>
				</div>	
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-body">	
							<h5 class="card-title">Crie uma nova obra</h5>
							<p>Crie um novo livro, academico, midia ou periodico</p>
							<button type="button" class="btn btn-neutral btn-lg" onclick="func1()">Criar Obra</button>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Edite obras</h5>
							<p>Pesquise as obras existentes no acervo e edite suas propriedades como nome, numero de paginas e autor da obra</p>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Exclua obras</h5>
							<p>Delete obras que você não quer mais no acervo, use a ferramenta de pesquisa e clique em excluir para apagar uma obra e todos os dados relacionados a ela</p>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>

</body>
</html>