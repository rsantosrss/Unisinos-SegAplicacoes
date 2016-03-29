<?php
error_reporting(0);

include_once "./includes/connection.php";

try{

    session_start();
    
    if(!$_SESSION["Apelido"]){
		
		echo "<script>alert('Acesso somente para administradores.');</script>";
        header("location: index.php");
        return;
    }
    
    if(strtoupper($_SESSION["Apelido"]) != "ADMIN"){
        header("location: comprar.php");
    }
    if ($_REQUEST["acao"] == "excluir") {
    
        $sql = "DELETE FROM Produtos";
        $sql .= " WHERE CodProduto = '" . $_REQUEST["CodProduto"] . "'";
    
        $query = mysql_query($sql) or die(mysql_error());
    
        $_SESSION["Msg"] = "Produto excluído com sucesso!";
        
    }

    $sql = "SELECT * FROM Produtos";   
    
    $query = mysql_query($sql) or die(mysql_error());
    
}catch(Exception $e){
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
</script>
<body>
<?php include './includes/menu.php';?>
<h1>E-Commerce Maneiro...</h1>
<div id ="wrapper">
    <table id="keywords">
      <thead>
        <tr align="center">
          <th><span>Nome</span></th>
          <th><span>Valor</span></th>
          <th><span>Quantidade</span></th>
          <th><span>Descrição</span></th>
          <th><span>Ação</span></th>          
        </tr>
      </thead>
      <tbody>
      
      <?php while($row = mysql_fetch_assoc($query)){
			
			$style = "";
			
			if($row["QtdProduto"] <=0){
				$style = "style='border:1px dashed red;'";
			}
		
		?>
        
        <tr align="center" class="lalign hover" <?php echo $style; ?>>
          <td><?php echo $row["NmProduto"]?></td>
          <td>R$ <?php echo $row["VlrProduto"]?></td>
          <td><?php echo $row["QtdProduto"]?></td>
          <td><?php echo $row["DscProduto"]?></td>
          <td>
            <a href="cadastroProdutos.php?acao=editar&CodProduto=<?php echo $row["CodProduto"]?>">Editar</a>
            &nbsp;&nbsp;|
            <a href="editarProdutos.php?acao=excluir&CodProduto=<?php echo $row["CodProduto"]?>">Excluir</a>
          </td>
        </tr>       
        
        <?php }?> 
      </tbody>
    </table>
</div>
</body>
</html>