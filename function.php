<?php 
include_once "./includes/connection.php";

switch($_REQUEST["acao"]){
	
	case "addProduto" :
			
		$sql = "INSERT INTO Produtos (NmProduto, VlrProduto, QtdProduto, DscProduto)";
		$sql .= " VALUES(";
		$sql .= "'" . $_REQUEST["NmProduto"] . "',";
		$sql .= "'" . $_REQUEST["VlrProduto"] . "',";
		$sql .= "'" . $_REQUEST["QtdProduto"] . "',";
		$sql .= "'" . $_REQUEST["DscProduto"] . "'";
		$sql .= ")";
		
		if (mysql_query($sql)) {
			echo mysql_insert_id();
		} else {
			die(mysql_error());
		}
				
		mysql_close();
		
	break;
	
	case "updateProduto" :
	
		$sql = "UPDATE Produtos SET ";
		$sql .= "NmProduto ='" . $_REQUEST["NmProduto"] . "',";
		$sql .= "VlrProduto ='" . $_REQUEST["VlrProduto"] . "',";
		$sql .= "DscProduto ='" . $_REQUEST["DscProduto"] . "',";
		$sql .= "QtdProduto ='" . $_REQUEST["QtdProduto"] . "'";    
		$sql .= " WHERE CodProduto = '" . $_REQUEST["CodProduto"] . "'";
    
		$query = mysql_query($sql) or die(mysql_error());
		
		echo $_SESSION["Msg"] = "Produto " . $_REQUEST["NmProduto"] . " editado com sucesso";
		
		mysql_close();
	
	break;
	
	case "delUser" : 
		
		$sql = "DELETE FROM Usuarios";
		$sql .= " WHERE CodUsuario = '" . $_REQUEST["CodUsuario"] . "'";

		$query = mysql_query($sql) or die(mysql_error());

		mysql_close();
		
		echo  "Usuario excluido com sucesso!";
		
	break;
	
}