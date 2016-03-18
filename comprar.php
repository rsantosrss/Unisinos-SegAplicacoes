<?php
error_reporting(0);
include_once "./includes/connection.php";

session_start();

if(!$_SESSION["Apelido"]){
    header("location: index.php");
    return;
}

try{

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
          <th><span>Quantidades disponíveis</span></th>
          <th><span>Descrição</span></th>
          <th><span>Unidades</span></th>
          <th><input type="submit" value="Adicionar ao carrinho"/></th>        
        </tr>
      </thead>
      <tbody>
         <?php while($row = mysql_fetch_assoc($query)){?>
        
        <tr align="center" class="lalign hover">
          <td><?php echo $row["NmProduto"]?></td>
          <td>R$ <?php echo $row["VlrProduto"]?></td>
          <td><?php echo $row["QtdProduto"]?> un.</td>
          <td><?php echo $row["DscProduto"]?></td>
          <td><input type="text" name="qtdProduto[<?php echo $row['CodProduto']?>]" size="1"; /></td>
          <td>&nbsp;</td>
        </tr>  
        <?php }?>
      </tbody>
    </table>
</div>
</body>
</html>