<?php
  require_once("connect.php");
  require_once("validate.php");

  // Get form values
  $first = $_POST['editPatientFirst'];
  $last = $_POST['editPatientLast'];
  $ssn = $_POST['editPatientssn'];
  $address = $_POST['editPatientAddress'];
  $phone = $_POST['editPatientPhone'];
  $gender = $_POST['editPatientGender'];
  $birth = $_POST['editPatientBirth'];
  $bill = $_POST['editPatientBill'];
  $illness = $_POST['editPatientIllness'];
  $admit = $_POST['editPatientAdmit'];
  $dismiss = $_POST['editPatientDismiss'];
  $doctorID = $_POST['editPatientDoctor'];

  // Clean and validate input
  $first = clean($first);
  $last = clean($last);
  $ssn = clean($ssn);
  $address = clean($address);
  $phone = clean($phone);
  $gender = clean($gender);
  $birth = clean($birth);
  $bill = clean($bill);
  $illness = clean($illness);
  $admit = clean($admit);
  $dismiss = clean($dismiss);
  $doctorID = clean($doctorID);

  if (!checkLetters($first))
  {
    echo "invalidFirst";
  }
  else if (!checkLetters($last))
  {
    echo "invalidLast";
  }
  else if (!checkPhone($phone))
  {
    echo "invalidPhone";
  }
  else if (!checkDates($birth))
  {
    echo "invalidBirth";
  }
  else if (!checkNumbers($bill))
  {
    echo "invalidBill";
  }
  else if (!checkDates($admit))
  {
    echo "invalidAdmit";
  }
  
  // If all validation passes, execute queries
  if (checkLetters($first) && checkLetters($last) && checkPhone($phone) && 
      checkDates($birth) && checkNumbers($bill) && checkDates($admit))
  {
    // Update info in Person table
    $query = "UPDATE Person
              SET first = '$first', last = '$last', address = '$address',
                  phone = '$phone', gender = '$gender', birthdate = '$birth'
              WHERE ssn = '$ssn'";
    mysql_query($query) or die("Could not query: " . mysql_error());
  
    // Update info in Patient table if released
    if ($illness == "" && $dismiss != "")
    {
      $query = "UPDATE Patient
                SET bill = '$bill', primaryIllness = NULL, admitted = '$admit', dismissed = '$dismiss'
                WHERE ssn = '$ssn'";
      mysql_query($query) or die("Could not query: " . mysql_error());

      // Update info in has table
      $query = "SELECT patientID FROM Patient WHERE ssn = '$ssn'";
      $result = mysql_query($query) or die("Could not query: " . mysql_error());
      $row = mysql_fetch_assoc($result);
      $patientID = $row['patientID'];

      $query = "DELETE FROM has WHERE patientID = '$patientID'";
      mysql_query($query) or die("Could not query: " . mysql_error());

      echo "success";
    }

    // Update info in Patient table if undiagnosed with no doctor
    else if ($illness == "" && $dismiss == "" && $doctorID == "")
    {
      $query = "UPDATE Patient
                SET bill = '$bill', primaryIllness = NULL, admitted = '$admit', dismissed = NULL
                WHERE ssn = '$ssn'";
      mysql_query($query) or die("Could not query: " . mysql_error());

      // Update info in has table
      $query = "SELECT patientID FROM Patient WHERE ssn = '$ssn'";
      $result = mysql_query($query) or die("Could not query: " . mysql_error());
      $row = mysql_fetch_assoc($result);
      $patientID = $row['patientID'];

      echo "success";
    }

    // Update info in Patient table if undiagnosed with doctor
    else if ($illness == "" && $dismiss == "" && $doctorID != "")
    {
      $query = "UPDATE Patient
                SET bill = '$bill', primaryIllness = NULL, admitted = '$admit', dismissed = NULL
                WHERE ssn = '$ssn'";
      mysql_query($query) or die("Could not query: " . mysql_error());

      // Update info in has table
      $query = "SELECT patientID FROM Patient WHERE ssn = '$ssn'";
      $result = mysql_query($query) or die("Could not query: " . mysql_error());
      $row = mysql_fetch_assoc($result);
      $patientID = $row['patientID'];

      $query = "UPDATE has SET doctorID = '$doctorID' WHERE patientID = '$patientID'";
      mysql_query($query) or die("Could not query: " . mysql_error());

      echo "success";
    }

    // Update info in Patient table if diagnosed with doctor
    else if ($illness != "" && $dismiss == "")
    {
      $query = "UPDATE Patient
                SET bill = '$bill', primaryIllness = '$illness', admitted = '$admit', dismissed = NULL
                WHERE ssn = '$ssn'";
      mysql_query($query) or die("Could not query: " . mysql_error());

      // Update info in has table
      $query = "SELECT patientID FROM Patient WHERE ssn = '$ssn'";
      $result = mysql_query($query) or die("Could not query: " . mysql_error());
      $row = mysql_fetch_assoc($result);
      $patientID = $row['patientID'];

      $query = "UPDATE has SET doctorID = '$doctorID' WHERE patientID = '$patientID'";
      mysql_query($query) or die("Could not query: " . mysql_error());

      echo "success";
    }
    
  }
  mysql_close($con);
?>