<?php
  $host = "localhost";
  $sqlusername = "root";
  $sqlpassword = "root";
  $db_name = "dbms";

  $con = mysql_connect("$host", "$sqlusername", "$sqlpassword")or die("Can't connect to Server" . mysql_error());
  mysql_select_db("$db_name", $con) or die("Database does not exist");
?>