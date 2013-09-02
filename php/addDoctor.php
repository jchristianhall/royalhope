<?php
  require_once("connect.php");
  require_once("validate.php");

  // Get form values
  $first = $_POST['doctorFirst'];
  $last = $_POST['doctorLast'];
  $ssn = $_POST['doctorssn'];
  $address = $_POST['doctorAddress'];
  $phone = $_POST['doctorPhone'];
  $gender = $_POST['doctorGender'];
  $birth = $_POST['doctorBirth'];
  $salary = $_POST['doctorSalary'];
  $specialty = $_POST['doctorSpecialty'];

  // Clean and validate input
  $first = clean($first);
  $last = clean($last);
  $ssn = clean($ssn);
  $address = clean($address);
  $phone = clean($phone);
  $gender = clean($gender);
  $birth = clean($birth);
  $salary = clean($salary);
  $specialty = clean($specialty);

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
  else if (!checkNumbers($salary))
  {
    echo "invalidSalary";
  }
  else if (!checkLetters($specialty))
  {
    echo "invalidSpecialty";
  }

  // If all validation passes, execute queries
  if (checkLetters($first) && checkLetters($last) && checkSSN($ssn) && checkUnique($ssn) &&
      checkPhone($phone) && checkDates($birth) && checkNumbers($salary) && checkLetters($specialty))
  {
    // Add info to Person table
    $query = "INSERT INTO Person (ssn, first, last, address, phone, gender, birthdate)
                   VALUES ('$ssn', '$first', '$last', '$address', '$phone', '$gender', '$birth')";
    mysql_query($query) or die("Could not query: " . mysql_error());
  
    // Add info to Doctor table
    $query = "INSERT INTO Doctor (doctorID, ssn, salary, specialty)
                   VALUES (NULL, '$ssn', '$salary', '$specialty')";
    mysql_query($query) or die("Could not query: " . mysql_error());
  
    echo "success";
  }
  mysql_close($con);
?>