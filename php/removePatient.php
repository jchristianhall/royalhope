<?php
  require_once("connect.php");
  require_once("validate.php");

  $patientID = $_POST['personID'];
  $dismiss = $_POST['dismiss'];

  $patientID = clean($patientID);
  $dismiss = clean($dismiss);

  if (!checkDates($dismiss))
  {
    echo "invalidDismiss";
  }

  if (checkDates($dismiss))
  {
    $query = "UPDATE Patient SET dismissed = '$dismiss', primaryIllness = NULL WHERE patientID = '$patientID'";
    mysql_query($query) or die("Could not query: " . mysql_error());

    $query = "SELECT doctorID FROM has WHERE patientID = '$patientID'";
    $result = mysql_query($query) or die("Could not query: " . mysql_error());
    $row = mysql_fetch_assoc($result);
    $doctorID = $row['doctorID'];

    $query = "DELETE FROM has WHERE patientID = '$patientID' AND doctorID = '$doctorID'";
    mysql_query($query) or die("Could not query: " . mysql_error());

    echo "success";
    mysql_close($con);
  }
?>