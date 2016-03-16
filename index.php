<?php
error_reporting(0);
include_once "./includes/connection.php";

try{

	$_SESSION["MsgErro"] = "";
    
	if(count($_REQUEST)){
        
        session_destroy();
        
        session_start();
        
        $apelido = $_REQUEST["Apelido"];
        $senha = $_REQUEST["Senha"];
        
        $sql  = "SELECT CodUsuario, NmUsuario, Apelido";
        $sql .= " FROM Usuarios";
        $sql .= " WHERE Apelido = '". $apelido ."'";
        $sql .= " AND Senha = '" . $senha . "'";      
        
        $query = mysql_query($sql)or die(mysql_error());
        
        $row = mysql_fetch_assoc($query);
        
        // Se há registros, alimenta a global SESSION
        if(mysql_affected_rows()){         
            
            $_SESSION["CodUsuario"] = $row["CodUsuario"];
            $_SESSION["NmUsuario"] = $row["NmUsuario"];
            $_SESSION["Apelido"] = strtoupper($apelido);
            $_SESSION["IdSessao"] = rand(0, 200);
            
            mysql_close();
            // Redirecionara para a página do carrinho.
            header("location: carrinho.php"); 
        }
        else{
            $_SESSION["MsgErro"] = "Não foi encontrado algum usuário com apelido de ( ".strtoupper($apelido)." )";
        }
        
        mysql_close();
    }
        
    
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
<nav id="nav"></nav>;
<h1>E-Commerce Maneiro...</h1>
<div id ="wrapperLogin">

    <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
        <table id="keywords">
          <thead>
            <tr align="center">
              <th><span>Apelido</span></th>
              <th colspan="2"><span>Senha</span></th>                
            </tr>
          </thead>
          <tbody>
            <tr align="center" class="lalign">
              <td><input type="text" name="Apelido" id="Apelido" placeholder="Seu apelido..." autocomplete="off"/></td>
              <td><input type="password" name="Senha" id="Senha" placeholder="Sua senha.." autocomplete="off"/></td>
              <td><input type="submit" name="BtnSubmit" value="Entrar"/></td>          
            </tr>
            <tr>
                <td colspan="3"><?php echo $_SESSION["MsgErro"]?></td>
            </tr>        
          </tbody>
        </table>
    </form>
</div>
</body>
</html>