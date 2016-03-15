<?php
error_reporting(0);
include_once "./includes/connection.php";

try{

    $Sql = "SELECT * FROM Produtos";
    
    $con = mysql_query($Sql)or die(mysql_error());
    
}catch (Exception $e){
    echo $e->getMessage();
}



?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
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
<nav id="nav">
	<ul style="margin-left:-85%;">
        <li><img src="img/logo.png" width="100" height="24" title="RL SERVIÇOS" align="left"/></li>        
    </ul>
</nav>
<h1>Controle de Repetidos e IDF por Técnico</h1>
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