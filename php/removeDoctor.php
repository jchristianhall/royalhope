<?php
  require_once("connect.php");

  $doctorID = $_POST['personID'];
  $doctorID = mysql_real_escape_string($doctorID);

  // Delete doctor from has table
  $query = "DELETE FROM has WHERE doctorID = '$doctorID'";
  mysql_query($query) or die("Could not query: " . mysql_error());

  // Get ssn
  $query = "SELECT ssn FROM Doctor NATURAL JOIN Person WHERE doctorID = '$doctorID'";
  $result = mysql_query($query) or die("Could not query: " . mysql_error());
  $row = mysql_fetch_assoc($result);
  $ssn = $row['ssn'];

  // Delete doctor from Doctor table
  $query = "DELETE FROM Doctor WHERE doctorID = '$doctorID'";
  mysql_query($query) or die("Could not query: " . mysql_error());

  // Delete doctor from Person table
  $query = "DELETE FROM Person WHERE ssn = '$ssn'";
  mysql_query($query) or die("Could not query: " . mysql_error());

  echo "success";
?>