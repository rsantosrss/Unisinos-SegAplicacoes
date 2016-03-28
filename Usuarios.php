<?php
error_reporting(0);

include_once "./includes/connection.php";

session_start();

if(!$_SESSION["Apelido"]){
    header("location: index.php");
    return;
}

if(strtoupper($_SESSION["Apelido"]) != "ADMIN"){
    header("location: comprar.php");
}

$_SESSION["Msg"] = "";

try{
    
    $sql = "SELECT * FROM Usuarios";   
    
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
	
	$(document).ready(function(){
		
		$(".delUser").on("click", function(){
			var codUser = this.id;
			$.ajax({
				method: "POST",
				url: "function.php",
				data: { 
						acao : "delUser",
						CodUsuario : this.id						
					}
			}).done(function( msg ) {
				alert(msg);
				$("#user_" + codUser).remove();
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
          <th><span>Nome</span></th>
          <th><span>Cpf</span></th>
          <th><span>Endereço</span></th>
          <th><span>Cidade</span></th>
          <th><span>Estado</span></th>
          <th><span>Email</span></th>
          <th><span>Apelido</span></th>
          <th><span>Nascimento</span></th>
          <th><span>Ação</span></th>          
        </tr>
      </thead>
      <tbody>
      
      <?php while($row = mysql_fetch_assoc($query)){?>
        
        <tr align="center" class="lalign hover" id="user_<?php echo $row["CodUsuario"]?>">
          <td><?php echo $row["NmUsuario"]?></td>
          <td><?php echo $row["Cpf"]?></td>
          <td><?php echo $row["Endereco"]?></td>
          <td><?php echo $row["Cidade"]?></td>
          <td><?php echo $row["Estado"]?></td>
          <td><?php echo $row["Email"]?></td>
          <td><?php echo $row["Apelido"]?></td>
          <td><?php echo implode("/", array_reverse(explode("-",$row["DtNascimento"])))?></td>
          <td>
            <a href="cadastro.php?acao=editar&CodUsuario=<?php echo $row["CodUsuario"]?>">Editar</a>
            &nbsp;&nbsp;|
            <a id="<?php echo $row["CodUsuario"]?>" class='delUser'>Excluir</a>
          </td>
        </tr>       
        
        <?php }?> 
        <tr>
			<td colspan="10"><?php echo $_SESSION["Msg"]?></td>
		</tr>
      </tbody>
    </table>
</div>
</body>
</html>