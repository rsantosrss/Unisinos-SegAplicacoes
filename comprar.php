<?php
error_reporting(0);
include_once "./includes/connection.php";

session_start();

if(!$_SESSION["Apelido"]){
    header("location: index.php");
    return;
}

try{

	$sql  = "SELECT ItensCarrinho.CodProduto,ItensCarrinho.QtdProdutos";
	$sql .= " FROM ItensCarrinho";
	$sql .= " INNER JOIN Carrinho ON(ItensCarrinho.CodCarrinho = Carrinho.CodCarrinho)";	
	$sql .= " WHERE Carrinho.IdSessao = '" . $_SESSION["IdSessao"] . "'";
	$sql .= " AND CompraFinalizada IS NULL";

    $query = mysql_query($sql)or die(mysql_error());	
	
	$arrProdutos = array();
	
	while($row = mysql_fetch_assoc($query)){
		$arrProdutos[$row["CodProduto"]] = $row["QtdProdutos"];
	}
	
	$Sql = "SELECT * FROM Produtos";
    
    $query = mysql_query($Sql)or die(mysql_error());
    
}catch (Exception $e){
    echo $e->getMessage();
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
		
		$("#addCarrinho").on("click", function(){
			$.ajax({
				method: "POST",
				url: "function.php",
				data: { 
						acao : "addCarrinho",
						qtdProduto : $('#formCadastro').serialize()						
					}
			}).done(function( vlrRetorno ) {		
				
				if(vlrRetorno){									
					alert("Produtos adicionados ao carrinho com sucesso.");
				}else{
					alert("Ocorreu algum problema." );
					
				}
			  });			
		});
	});
	
	
</script>
<body>
<?php include './includes/menu.php';?>
<h1>E-Commerce Maneiro...</h1>
<div id ="wrapper">
<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST" id="formCadastro">
    <table id="keywords">
      <thead>
        <tr align="center">
          <th><span>Produto</span></th>
          <th><span>Valor unitário</span></th>
          <th><span>Quantidades disponíveis</span></th>
          <th><span>Descrição</span></th>
          <th><span>Unidades</span></th>
          <th><input type="button" value="Adicionar ao carrinho" id="addCarrinho"/></th>        
        </tr>
      </thead>
      <tbody>
         <?php while($row = mysql_fetch_assoc($query)){
			 
			$readOnly = "";
			$texto = "";
			
			$qtdProduto = $row["QtdProduto"];
			
			if($row["QtdProduto"] <=0){
				$readOnly = "readonly";
				$texto = "Produto indisponível";				
				$qtdProduto = 0;
			}
			?>
        
        <tr align="center" class="lalign hover">
          <td class="NmProduto"><?php echo $row["NmProduto"]?></td>
          <td>R$ <?php echo $row["VlrProduto"]?></td>
          <td><?php echo $qtdProduto?> un.</td>
          <td><?php echo $row["DscProduto"]?></td>
          <td><input type="text" id="qtdProduto" class='qtdProduto' name="qtdProduto[<?php echo $row['CodProduto']?>]"  <?php echo $readOnly;?>
		  size="1"; value="<?php echo $arrProdutos[$row['CodProduto']]?>"/></td>
		  
          <td>&nbsp; <?php echo $texto; ?></td>
        </tr>  
        <?php }?>
      </tbody>
    </table>
	</form>	
</div>
</body>
</html>