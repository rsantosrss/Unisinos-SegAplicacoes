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

$_SESSION["Msg"] = "";

$valueBtnSubmit = "Cadastrar";

if ($_REQUEST["BtnSubmit"] == 'Editar') {
    
    $sql = "UPDATE Usuarios SET ";
    $sql .= "NmUsuario ='" . $_REQUEST["NmUsuario"] . "',";
    $sql .= "Cpf ='" . $_REQUEST["Cpf"] . "',";
    $sql .= "Endereco ='" . $_REQUEST["Endereco"] . "',";
    $sql .= "Cidade ='" . $_REQUEST["Cidade"] . "',";
    $sql .= "Estado ='" . $_REQUEST["Estado"] . "',";
    $sql .= "Email ='" . $_REQUEST["Email"] . "',";
    $sql .= "DtNascimento ='" . implode("-", array_reverse(explode("/", $_REQUEST["DtNascimento"]))) . "'";
    
    $sql .= " WHERE Apelido = '" . $_REQUEST["Apelido"] . "'";
    
    $query = mysql_query($sql) or die(mysql_error());
    
    $_SESSION["Msg"] = "Usuário " . $_REQUEST["NmUsuario"] . " editado com sucesso";
} 

elseif ($_REQUEST["BtnSubmit"] == "Cadastrar") {
    
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
        
        if (mysql_query($sql)) {
            $_SESSION["Msg"] = "Usuário cadastrado com sucesso!";
        } else {
            die(mysql_error());
        }
    }
    
    mysql_close();
    
} elseif ($_REQUEST["acao"] == "editar") {
    
    $sql = "SELECT *";
    $sql .= " FROM Usuarios";
    $sql .= " WHERE CodUsuario = '" . $_REQUEST["CodUsuario"] . "'";
    
    $query = mysql_query($sql) or die(mysql_error());
    
    $row = mysql_fetch_assoc($query);
    
    mysql_close();

    $valueBtnSubmit = "Editar";
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
$(function(){
	  $('#keywords').tablesorter(); 
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
		<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
			<input type="hidden" name="CodUsuario" id="CodUsuario"
				value="<?php echo $row["CodUsuario"];?>" /> <input type="hidden"
				name="action" id="action" value="<?php echo $_REQUEST["acao"];?>" />
			<table id="keywords">
				<tr align="left">
					<td>Nome:</td>
					<td><input type="text" name="NmUsuario" id="NmUsuario"
						required="required" value="<?php echo $row["NmUsuario"];?>" /></td>
				</tr>
				<tr align="left">
					<td>Cpf:</td>
					<td><input type="text" name="Cpf" id="Cpf" maxlength="14"
						required="required" value="<?php echo $row["Cpf"];?>" /></td>
				</tr>
				<tr align="left">
					<td>Endereço:</td>
					<td><input type="text" name="Endereco" id="Endereco"
						value="<?php echo $row["Endereco"];?>" /></td>
				</tr>
				<tr align="left">
					<td>Cidade:</td>
					<td><input type="text" name="Cidade" id="Cidade"
						value="<?php echo $row["Cidade"];?>" /></td>
				</tr>
				<tr align="left">
					<td>Estado:</td>
					<td><select name="Estado" id="Estado">
							<option value="">Selecione</option>
							<option value="RS"
								<?php echo (($row["Estado"] == "RS") ? " selected" : "") ?>>RS</option>
							<option value="SC"
								<?php echo (($row["Estado"] == "SC") ? " selected" : "")?>>SC</option>
							<option value="PR"
								<?php echo (($row["Estado"] == "PR") ? "selected" : "")?>>PR</option>
					</select></td>
				</tr>
				<tr align="left">
					<td>Email:</td>
					<td><input type="email" name="Email" id="Email"
						value="<?php echo $row["Email"];?>" /></td>
				</tr>
				<tr align="left">
					<td>Apelido:</td>
					<td><input type="text" name="Apelido" id="Apelido" maxlength="20"
						<?php echo ($row["Apelido"]) ? ' readonly style="background-color:rgb(230, 228, 228);"' : "";?>
						value="<?php echo $row["Apelido"];?>" /></td>
				</tr>
				<tr align="left">
					<td>Senha:</td>
					<td><input type="text" name="Senha" id="Senha" required="required"
						value="<?php echo $row["Senha"];?>" /></td>
				</tr>
				<tr align="left">
					<td>Nascimento:</td>
					<td><input type="text" name="DtNascimento" id="DtNascimento"
						value="<?php echo implode("/", array_reverse(explode("-",$row["DtNascimento"])));?>" /></td>
				</tr>
				<tr align="left">
					<td colspan="2"><input type="submit" name="BtnSubmit"
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