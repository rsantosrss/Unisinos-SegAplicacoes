<?php
error_reporting(0);
include_once "./includes/connection.php";

session_start();

if (! $_SESSION["Apelido"]) {
    header("location: index.php");
    return;
}

if (strtoupper($_SESSION["Apelido"]) != "ADMIN") {
    header("location: carrinho.php");
}

/*if ($_REQUEST["BtnSubmit"] == 'Editar') {
    
    $sql = "UPDATE Produtos SET ";
    $sql .= "NmProduto ='" . $_REQUEST["NmProduto"] . "',";
    $sql .= "VlrProduto ='" . $_REQUEST["VlrProduto"] . "',";
    $sql .= "DscProduto ='" . $_REQUEST["DscProduto"] . "',";
    $sql .= "QtdProduto ='" . $_REQUEST["QtdProduto"] . "'";    
    $sql .= " WHERE CodProduto = '" . $_REQUEST["CodProduto"] . "'";
    
    $query = mysql_query($sql) or die(mysql_error());
    
    $_SESSION["Msg"] = "Produto " . $_REQUEST["NmProduto"] . " editado com sucesso";
}*/

$valueBtnSubmit = "Cadastrar";

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
				name="action" id="action" value="addProduto" />
			<table id="keywords">
				<tr align="left">
					<td nowrap>Nome produto:</td>
					<td><input type="text" name="NmProduto" id="NmProduto"
						required="required" value="<?php echo $row["NmProduto"];?>" /></td>
				</tr>
				<tr align="left">
					<td nowrap>Valor:</td>
					<td><input type="text" name="VlrProduto" id="VlrProduto" maxlength="14"
						required="required" value="<?php echo $row["VlrProduto"];?>" /></td>
				</tr>
				<tr align="left">
					<td nowrap>Quantidade:</td>
					<td><input type="text" name="QtdProduto" id="QtdProduto"
						value="<?php echo $row["QtdProduto"];?>" /></td>
				</tr>
				<tr align="left">
					<td nowrap>Descrição:</td>
					<td><textarea rows="3" cols="28" id="DscProduto" name="DscProduto"><?php echo $row["DscProduto"]?></textarea></td>
				</tr>
				<tr align="left">
					<td colspan="2"><input type="button" name="BtnSubmit" id="BtnSubmit"
						value="<?php echo $valueBtnSubmit?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $_SESSION["Msg"]?></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>