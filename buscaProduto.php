<?php
error_reporting(0);

include_once "./includes/connection.php";

session_start();

if(!$_SESSION["Apelido"]){
    header("location: index.php");
    return;
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>:: E-Commerce Maneiro ::</title>
</head>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
select,input[type=text],input[type=email] {
	width: 250px;
	text-align: left;
}

#wrapper {
	display: block;
	width: 30%;
	background: #fff;
	margin: 0 auto;
	padding: 10px 17px;
	-webkit-box-shadow: 2px 2px 3px -1px rgba(0, 0, 0, 0.35);
}

#wrapper2 {
	display: none;
	width: 30%;
	background: #fff;
	margin: 0 auto;
	padding: 10px 17px;
	-webkit-box-shadow: 2px 2px 3px -1px rgba(0, 0, 0, 0.35);
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://tablesorter.com/__jquery.tablesorter.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		
		$("#BtnPesquisar").on("click", function(){
			$.ajax({
				method: "POST",
				url: "function.php",
				data: { 
						acao : "PesquisarProduto",
						NmProduto : $("#NmProduto").val(),						
						DscProduto : $("#DscProduto").val()						
					}
			}).done(function( vlrRetorno ) {
				
				if(vlrRetorno){
					
					$("#wrapper2").html(vlrRetorno).show();					
					
				}else{
					alert("Produto não encontrado.");
				}
			  });			
		});
	
	
		$("#btnLimpar").click(function(){
		
			$("#NmProduto").val(""),
			$("#DscProduto").val("")
			$("#wrapper2").hide();
		});
	});
	
</script>
<body>
<?php include './includes/menu.php';?>
<h1>E-Commerce Maneiro...</h1>
<div id ="wrapper">		
	<table id="keywords">
		<tr align="left">
			<td nowrap>Nome produto:</td>
			<td><input type="text" name="NmProduto" id="NmProduto" /></td>
		</tr>				
		<tr align="left">
			<td nowrap>Descrição:</td>
			<td><textarea rows="3" cols="28" id="DscProduto" name="DscProduto"></textarea></td>
		</tr>
		<tr align="left">
			<td colspan="2"><input type="button" name="BtnPesquisar" id="BtnPesquisar" value="Pesquisar" />
			<input type="button" id="btnLimpar" value="Limpar"/></td>
		</tr>			
	</table>
</div>

<div id="wrapper2"></div>
</body>
</html>
