<?php
error_reporting(0);

include_once "./includes/connection.php";

session_start();

if(!$_SESSION["Apelido"]){
    header("location: index.php");
    return;
}

if(strtoupper($_SESSION["Apelido"]) != "ADMIN"){
    header("location: carrinho.php");
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
          <th><span>MATRICULA</span></th>
          <th><span>NOME</span></th>
          <th><span>REPAROS</span></th>
          <th><span>REPETIDOS</span></th>
          <th nowrap><span>% REP</span></th>
          <th><span>OS's</span></th>
          <th><span>IDEF</span></th>
          <th nowrap><span>% IDEF</span></th>
        </tr>
      </thead>
      <tbody>
        <tr align="center" class="lalign">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>        
      </tbody>
    </table>
</div>
</body>
</html>