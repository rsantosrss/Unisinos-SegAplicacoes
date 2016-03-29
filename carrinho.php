<?php
error_reporting(0);
include_once "./includes/connection.php";

session_start();

if(!$_SESSION["Apelido"]){
    header("location: index.php");
    return;
}

try{

    $sql  = "SELECT Produtos.NmProduto,Produtos.VlrProduto,ItensCarrinho.QtdProdutos FROM ItensCarrinho";
	$sql .= " INNER JOIN Carrinho ON(ItensCarrinho.CodCarrinho = Carrinho.CodCarrinho)";
	$sql .= " INNER JOIN Produtos ON (ItensCarrinho.CodProduto = Produtos.CodProduto)";
	$sql .= " WHERE Carrinho.IdSessao = '" . $_SESSION["IdSessao"] . "'";
	$sql .= " AND CompraFinalizada IS NULL";
    
    $query = mysql_query($sql)or die(mysql_error());
    
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
	
	$(document).ready(function(){
		
		$("#finalizaCompra, #cancelarCompra").on("click", function(){
			
			$.ajax({
				method: "POST",
				url: "function.php",
				data: { 
						acao : $(this).attr('id')						
					}
			}).done(function( vlrRetorno ) {
				
				if(vlrRetorno){
					alert("Compra finalizada com sucesso. Em breve estaremos entrando em contato.");
					
					window.location.href = 'comprar.php';
					
				}else{
					alert("Compra cancelada com sucesso.");
				}			
								
			  });	
		});		
	});
	
	
</script>
<body>
<?php include './includes/menu.php';?>
<h1>E-Commerce Maneiro...</h1>
<div id ="wrapper">
    <table id="keywords">
      <thead>
        <tr align="center">
			<th><span>Produto</span></th>
			<th><span>Valor unitário</span></th>
			<th><span>Quantidade</span></th>
			<th><span>Valor total</span></th>
			<?php if(mysql_num_rows($query)){ ?>
			<th><input type="button" name='finalizaCompra'  id='finalizaCompra' value="Finaliza compra" /></th>
			<th><input type="button" name='cancelarCompra' id='cancelarCompra'  value="Cancelar compra" /></th>		
			<?php } ?>			
        </tr>
      </thead>
      <tbody>
        <?php 
		
		if(!mysql_num_rows($query)){
			echo "<tr><td colspan='4'>Nenhum item adicionado ao carrinho...</td></tr>";
		}
		
		while($row = mysql_fetch_assoc($query)){?>
        
			<tr align="center" class="lalign hover">
			  <td><?php echo $row["NmProduto"]?></td>
			  <td>R$ <?php echo $row["VlrProduto"]?></td>
			  <td><?php echo $row["QtdProdutos"]?></td>
			  <td>R$ <?php echo number_format(($row["VlrProduto"] * $row["QtdProdutos"]),2,',','.')?></td>                              
			</tr>       
       
        <?php }?>    
      </tbody>
    </table>
</div>
</body>
</html>