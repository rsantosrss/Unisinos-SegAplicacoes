<?php
error_reporting(0);
include_once "./includes/connection.php";

session_start();

$_SESSION["Msg"] = "";	

if (! $_SESSION["Apelido"]) {
    header("location: index.php");
    return;
}

if (strtoupper($_SESSION["Apelido"]) != "ADMIN") {
    header("location: comprar.php");
}

$Action = "addProduto";

if ($_REQUEST["acao"] == 'editar') {
    
	$sql = "SELECT * FROM Produtos";
    $sql .= " WHERE CodProduto = '" . $_REQUEST["CodProduto"] . "'";

    $row = mysql_fetch_assoc(mysql_query($sql)) or die(mysql_error());
    
	$Action = "updateProduto";
}

$valueBtnSubmit = "Salvar";

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>:: E-Commerce Maneiro ::</title>
</head>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://tablesorter.com/__jquery.tablesorter.min.js"></script>
<script type="text/javascript">	
$(function(){
	  $('#keywords').tablesorter(); 
	});
	$(function(){
			$('.qtdProduto').bind('keydown',soNums); // o "#input" é o input que vc quer aplicar a funcionalidade
		});
		 
		function soNums(e){
		 
			//teclas adicionais permitidas (tab,delete,backspace,setas direita e esquerda)
			keyCodesPermitidos = new Array(8,9,37,39,46);
			 
			//numeros e 0 a 9 do teclado alfanumerico
			for(x=48;x<=57;x++){
				keyCodesPermitidos.push(x);
			}
			 
			//numeros e 0 a 9 do teclado numerico
			for(x=96;x<=105;x++){
				keyCodesPermitidos.push(x);
			}
			 
			//Pega a tecla digitada
			keyCode = e.which; 
			 
			//Verifica se a tecla digitada é permitida
			if ($.inArray(keyCode,keyCodesPermitidos) != -1){
				return true;
			}    
			return false;
		}
	
	$(document).ready(function(){
		
		$("#BtnSubmit").on("click", function(){
			
			$.ajax({
				method: "POST",
				url: "function.php",
				data: { 
						acao : $("#action").val(),
						NmProduto : $("#NmProduto").val(),
						VlrProduto : $("#VlrProduto").val(),
						DscProduto : $("#DscProduto").val(),
						QtdProduto : $("#QtdProduto").val(),
						CodProduto : $("#CodProduto").val()
					}
			}).done(function( vlrRetorno ) {
				
				if(vlrRetorno > 0){
					
					$("#action").val("updateProduto");
					
					if(!$("#CodProduto").val()){
						alert("Produto Cadastrado com sucesso");
						$("#CodProduto").val(vlrRetorno);
					}else{
						alert("Produto atualizado com sucesso");
					}
				}else{
					alert(vlrRetorno);
				}			
								
			  });			
		});
		
		
		$("#btnLimpar").click(function(){
			
			$("#action").val("addProduto");
			$("#NmProduto").val(""),
			$("#VlrProduto").val("")
			$("#DscProduto").val("")
			$("#QtdProduto").val("")
			$("#CodProduto").val("")
		});
		
	});
</script>
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
</style>
<body>
	<?php include './includes/menu.php';?>
	<h1>E-Commerce Maneiro...</h1>
	<div id="wrapper">
		<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST" id="formCadastro">
			<input type="hidden" name="CodProduto" id="CodProduto"
				value="<?php echo $row["CodProduto"];?>" /> <input type="hidden"
				name="action" id="action" value="<?php echo $Action; ?>" />
			<table id="keywords">
				<tr align="left">
					<td nowrap>Nome produto:</td>
					<td><input type="text" name="NmProduto" id="NmProduto"
						required="required" value="<?php echo $row["NmProduto"];?>" /></td>
				</tr>
				<tr align="left">
					<td nowrap>Valor:</td>
					<td><input type="text" name="VlrProduto" id="VlrProduto" maxlength="14"
						required="required" value="<?php echo $row["VlrProduto"];?>"  /></td>
				</tr>
				<tr align="left">
					<td nowrap>Quantidade:</td>
					<td><input type="text" name="QtdProduto" id="QtdProduto"
						value="<?php echo $row["QtdProduto"];?>" class='qtdProduto'/></td>
				</tr>
				<tr align="left">
					<td nowrap>Descrição:</td>
					<td><textarea rows="3" cols="28" id="DscProduto" name="DscProduto"><?php echo $row["DscProduto"]?></textarea></td>
				</tr>
				<tr align="left">
					<td colspan="2"><input type="button" name="BtnSubmit" id="BtnSubmit"
						value="<?php echo $valueBtnSubmit?>" />
					<input type="button" id="btnLimpar" value="Limpar"/></td>	
				</tr>
				<tr>
					<td colspan="2"><?php echo $_SESSION["Msg"]?></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>