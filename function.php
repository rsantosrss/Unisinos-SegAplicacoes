<?php 
include_once "./includes/connection.php";

session_start();

switch($_REQUEST["acao"]){
	
	case "addProduto" :
			
		$sql = "INSERT INTO Produtos (NmProduto, VlrProduto, QtdProduto, DscProduto)";
		$sql .= " VALUES(";
		$sql .= "'" . $_REQUEST["NmProduto"] . "',";
		$sql .= "'" . str_replace(",",".",$_REQUEST["VlrProduto"]) . "',";
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
		$sql .= "VlrProduto ='" . str_replace(",",".",$_REQUEST["VlrProduto"]) . "',";
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
	
	case "PesquisarProduto":
	
		
		if($_REQUEST["NmProduto"]){
			
			$sql  = "SELECT * FROM Produtos";
			$sql .= " WHERE NmPRoduto LIKE '%".$_REQUEST["NmProduto"]."%'";
		}
		elseif($_REQUEST["DscProduto"]){
			
			$sql  = "SELECT * FROM Produtos";
			$sql .= " WHERE DscProduto LIKE '%".$_REQUEST["DscProduto"]."%'";
		}
		else{
			
			$sql  = "SELECT * FROM Produtos";
			$sql .= " WHERE NmPRoduto LIKE '%".$_REQUEST["NmPRoduto"]."%'";
			$sql .= " AND DscProduto LIKE '%".$_REQUEST["DscProduto"]."%'";
		}
		
		$query = mysql_query($sql) or die(mysql_error());
	
		if(mysql_num_rows($query)){			
			
			$string ="<table id='keywords'>";
			
			while($row = mysql_fetch_assoc($query)){
			
				$string .="<tr align='left'>";
				$string .="	<td nowrap>Nome produto:</td>";
				$string .="	<td><input type='text' name='NmProduto' readonly id='NmProduto' value='".$row["NmProduto"]."' /></td>";
				$string .="</tr>";
				$string .="<tr align='left'>";
				$string .="	<td nowrap>Valor:</td>";
				$string .="	<td><input type='text' name='VlrProduto'readonly id='VlrProduto' maxlength='14' value='R$ ".$row["VlrProduto"]."'/></td>";
				$string .="</tr>";
				$string .="<tr align='left'>";
				$string .="	<td nowrap>Quantidade:</td>";
				$string .="	<td><input type='text' name='QtdProduto'readonly id='QtdProduto' value='".$row["QtdProduto"]."'/></td>";
				$string .="</tr>";
				$string .="<tr align='left'>";
				$string .="	<td nowrap>Descrição:</td>";
				$string .="	<td><textarea rows='3' cols='28' readonly id='DscProduto' name='DscProduto'>".$row["DscProduto"]."</textarea></td>";
				$string .="</tr>";				
				
			}			
			
			$string .="</table>";	
			
			echo $string;
		}
		
		mysql_close();
	
	break;
	
	case "addCarrinho":
	
		$codCarrinho = 0;
		
		parse_str($_POST['qtdProduto'], $produtos);		
		
		// Primeiro verifica se não possui um código de carrinho.
		$sql = "SELECT CodCarrinho FROM Carrinho";
		$sql .= " WHERE IdSessao = '" . $_SESSION["IdSessao"] . "' AND CodUsuario = " . $_SESSION["CodUsuario"];
		$sql .= " AND CompraFinalizada IS NULL";
		
		$query = mysql_query($sql) or die(mysql_error());
		
		$row = mysql_fetch_assoc($query);
		
		if(mysql_num_rows($query)){
			$codCarrinho = $row['CodCarrinho'];
		}

		//Se já possui um código de carrinho, deleta todos os registros que foram encontrados a partir daquele código.
		if($codCarrinho){
			
			$sql = "DELETE FROM ItensCarrinho";
			$sql .= " WHERE CodCarrinho = " . $codCarrinho;
			
			mysql_query($sql) or die(mysql_error());
			
			$sql = "DELETE FROM Carrinho";
			$sql .= " WHERE CodCarrinho = " . $codCarrinho;

			mysql_query($sql) or die(mysql_error());
			
		}
		
		// cria um novo código de carrinho
		
		$sql  = "INSERT INTO Carrinho (IdSessao, CodUsuario, DtPedido)";
		$sql .= " VALUES(";
		$sql .= " '".$_SESSION["IdSessao"]."', ";
		$sql .= $_SESSION["CodUsuario"] . ",";
		$sql .= " CURDATE()";		
		$sql .= ")";

		mysql_query($sql) or die(mysql_error());
		
		$lasInsertedId = mysql_insert_id();	
		
		// adiciona os itens dos produtos com um novo código de carrinho.
		foreach($produtos as $produto){
			
			foreach($produto as $codProduto => $qtdProduto){
				
				if(!$qtdProduto){
					continue;
				}
				$sql = "INSERT INTO ItensCarrinho (CodCarrinho, CodProduto, QtdProdutos)";
				$sql .= "VALUES(";
				$sql .= $lasInsertedId . ',';
				$sql .= $codProduto .',';
				$sql .= $qtdProduto;
				$sql .= ")";

				mysql_query($sql) or die(mysql_error());
			}			
		}
		
		mysql_close();
		
		echo "OK";
		
	break;
	
	case "finalizaCompra":
	
	
		$sql  = "SELECT ItensCarrinho.CodProduto,ItensCarrinho.QtdProdutos FROM ItensCarrinho";
		$sql .= " INNER JOIN Carrinho ON(ItensCarrinho.CodCarrinho = Carrinho.CodCarrinho)";
		$sql .= " WHERE Carrinho.IdSessao = '" . $_SESSION["IdSessao"] . "'";
		$sql .= " AND CompraFinalizada IS NULL";
	
		$query = mysql_query($sql)or die(mysql_error());
	
		while($row = mysql_fetch_assoc($query)){
			
			$sql = "UPDATE Produtos SET ";
			$sql .= " QtdProduto = QtdProduto - " . $row["QtdProdutos"];
			$sql .= " WHERE CodProduto = " . $row["CodProduto"];
			
			$query2 = mysql_query($sql)or die(mysql_error());
			
		}
	
		$sql = "UPDATE Carrinho SET CompraFinalizada = 'S'";
		$sql .= " WHERE IdSessao = '" . $_SESSION["IdSessao"] . "' AND CodUsuario = " . $_SESSION["CodUsuario"];
		
		mysql_query($sql) or die(mysql_error());
		
		echo "Compra finalizada com sucesso. Em breve estaremos entrando em contato.";
	
	break;
	
	case "cancelarCompra":
	
		$sql = "SELECT CodCarrinho FROM Carrinho";
		$sql .= " WHERE IdSessao = '" . $_SESSION["IdSessao"] . "' AND CodUsuario = " . $_SESSION["CodUsuario"];
		$sql .= " AND CompraFinalizada IS NULL";
		
		$query = mysql_query($sql) or die(mysql_error());
		
		$row = mysql_fetch_assoc($query);
		
		if(mysql_num_rows($query)){
			$codCarrinho = $row['CodCarrinho'];
		}

		//Se já possui um código de carrinho, deleta todos os registros que foram encontrados a partir daquele código.
		if($codCarrinho){
			
			$sql = "DELETE FROM ItensCarrinho";
			$sql .= " WHERE CodCarrinho = " . $codCarrinho;
			
			mysql_query($sql) or die(mysql_error());
			
			$sql = "DELETE FROM Carrinho";
			$sql .= " WHERE CodCarrinho = " . $codCarrinho;

			mysql_query($sql) or die(mysql_error());
			
		}
	
	break;
}