<?php
  require_once("connect.php");
  require_once("validate.php");

  // Get form values
  $first = $_POST['patientFirst'];
  $last = $_POST['patientLast'];
  $ssn = $_POST['patientssn'];
  $address = $_POST['patientAddress'];
  $phone = $_POST['patientPhone'];
  $gender = $_POST['patientGender'];
  $birth = $_POST['patientBirth'];
  $bill = $_POST['patientBill'];
  $illness = $_POST['patientIllness'];
  $admit = $_POST['patientAdmit'];
  $doctorID = $_POST['patientDoctor'];

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
  $doctorID = clean($doctorID);

  if (!checkLetters($first))
  {
    echo "invalidFirst";
  }
  else if (!checkLetters($last))
  {
    echo "invalidLast";
  }
  else if (!checkSSN($ssn))
  {
    echo "invalidSSN";
  }
  else if (!checkUnique($ssn))
  {
    echo "duplicateSSN";
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
  else if (!checkNumbers($doctorID))
  {
    echo "invalidDoctor";
  }

  // If all validation passes, execute queries
  if (checkLetters($first) && checkLetters($last) && checkSSN($ssn) && checkUnique($ssn) &&
      checkPhone($phone) && checkDates($birth) && checkNumbers($bill) && checkDates($admit) &&
      checkNumbers($doctorID))
  {
    // Add info to Person table
    $query = "INSERT INTO Person (ssn, first, last, address, phone, gender, birthdate)
                   VALUES ('$ssn', '$first', '$last', '$address', '$phone', '$gender', '$birth')";
    mysql_query($query) or die("Could not query: " . mysql_error());

    // Generate patient ID
    $currentIDs = (mysql_query("SELECT patientID FROM Patient"));
    $IDarray = NULL;
    while ($nextID = mysql_fetch_array($currentIDs))
    {
      $IDarray[] = $nextID['patientID'];
    }
    if ($IDarray != NULL)
    {
      $patientID = max($IDarray) + 1;
    }
    else
    {
      $patientID = 1;
    }

    // Add info to Patient table
    if ($illness)
    {
      $query = "INSERT INTO Patient (patientID, ssn, bill, primaryIllness, admitted, dismissed)
                     VALUES ('$patientID', '$ssn', '$bill', '$illness', '$admit', NULL)";
      mysql_query($query) or die("Could not query: " . mysql_error());
    }
    else
    {
      $query = "INSERT INTO Patient (patientID, ssn, bill, primaryIllness, admitted, dismissed)
                     VALUES ('$patientID', '$ssn', '$bill', NULL, '$admit', NULL)";
      mysql_query($query) or die("Could not query: " . mysql_error());
    }

    // Add info to has table
    $query = "INSERT INTO has (doctorID, patientID)
                   VALUES ('$doctorID', '$patientID')";
    mysql_query($query) or die("Could not query: " . mysql_error());

    echo "success";
  }
  mysql_close($con);
?>