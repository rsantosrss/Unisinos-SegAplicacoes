<?php
error_reporting(0);
include_once "./includes/connection.php";

session_start();

if (strtoupper($_SESSION["Apelido"]) != "ADMIN") {
    header("location: carrinho.php");
}

$_SESSION["Msg"] = "";

if (count($_REQUEST)) {
	
    $sql = "SELECT *";
    $sql .= " FROM Usuarios";
    $sql .= " WHERE Apelido = '" . $_REQUEST["Apelido"] . "'";
    
    $query = mysql_query($sql) or die(mysql_error());
    
    $row = mysql_fetch_assoc($query);
    
    // Se há registros, alimenta a global SESSION
    if (mysql_affected_rows()) {
        
        $_SESSION["Msg"] = "Já existe algum usuário com este mesmo apelido.";
        
        mysql_close();
    } else {
        
        $sql = "INSERT INTO Usuarios (NmUsuario, DtNascimento, Cpf, Endereco, Cidade, Estado, Email, Apelido, Senha)";
        $sql .= " VALUES(";
        $sql .= "'" . $_REQUEST["NmUsuario"] . "',";
        $sql .= "'" . implode("-", array_reverse(explode("/", $_REQUEST["DtNascimento"]))) . "',";
        $sql .= "'" . $_REQUEST["Cpf"] . "',";
        $sql .= "'" . $_REQUEST["Endereco"] . "',";
        $sql .= "'" . $_REQUEST["Cidade"] . "',";
        $sql .= "'" . $_REQUEST["Estado"] . "',";
        $sql .= "'" . $_REQUEST["Email"] . "',";
        $sql .= "'" . $_REQUEST["Apelido"] . "',";
        $sql .= "'" . $_REQUEST["Senha"] . "'";
        $sql .= ")";
        
        if(mysql_query($sql)){
            $_SESSION["Msg"] = "Usuário cadastrado com sucesso!";
        }else{
            die(mysql_error());
        }        
    }
    
    mysql_close();
}

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

	$(document).ready(function(){
		$(function(){
		    $('#keywords').tablesorter();			  
			});

		$("#DtNascimento").mask("##/##/##");

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
	<nav id="nav">
		<ul>
			<li><a href='estoque.php'>Estoque</a></li>
			<li>&nbsp;&nbsp;|</li>
			<li><a href='cadastro.php'>&nbsp;&nbsp;Cadastro Usuários</a></li>
			<li>&nbsp;&nbsp;|</li>
			<li><a href='comprar.php'>&nbsp;&nbsp;Comprar</a></li>
			<li>&nbsp;&nbsp;|</li>
			<li><a href='carrinho.php'>&nbsp;&nbsp;Meu Carrinho</a></li>
		</ul>
	</nav>
	<h1>E-Commerce Maneiro...</h1>
	<div id="wrapper">
		<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
			<table id="keywords">
				<tr align="left">
					<td>Nome:</td>
					<td><input type="text" name="NmUsuario" id="NmUsuario"
						required="required" /></td>
				</tr>
				<tr align="left">
					<td>Cpf:</td>
					<td><input type="text" name="Cpf" id="Cpf" maxlength="10"
						required="required" /></td>
				</tr>
				<tr align="left">
					<td>Endereço:</td>
					<td><input type="text" name="Endereco" id="Endereco" /></td>
				</tr>
				<tr align="left">
					<td>Cidade:</td>
					<td><input type="text" name="Cidade" id="Cidade" /></td>
				</tr>
				<tr align="left">
					<td>Estado:</td>
					<td><select name="Estado" id="Estado">
							<option value="">Selecione</option>
							<option value="RS">RS</option>
							<option value="SC">SC</option>
							<option value="PR">PR</option>
					</select></td>
				</tr>
				<tr align="left">
					<td>Email:</td>
					<td><input type="email" name="Email" id="Email" /></td>
				</tr>
				<tr align="left">
					<td>Apelido:</td>
					<td><input type="text" name="Apelido" id="Apelido" maxlength="20" /></td>
				</tr>
				<tr align="left">
					<td>Senha:</td>
					<td><input type="text" name="Senha" id="Senha" required="required" /></td>
				</tr>
				<tr align="left">
					<td>Nascimento:</td>
					<td><input type="text" name="DtNascimento" id="DtNascimento" /></td>
				</tr>
				<tr align="left">
					<td colspan="2"><input type="submit" name="BtnSubmit"
						value="Cadastrar" /></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $_SESSION["Msg"]?></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>