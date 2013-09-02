<?php
  require_once("connect.php");
  require_once("validate.php");

  // Get form values
  $first = $_POST['editDoctorFirst'];
  $last = $_POST['editDoctorLast'];
  $ssn = $_POST['editDoctorssn'];
  $address = $_POST['editDoctorAddress'];
  $phone = $_POST['editDoctorPhone'];
  $gender = $_POST['editDoctorGender'];
  $birth = $_POST['editDoctorBirth'];
  $salary = $_POST['editDoctorSalary'];
  $specialty = $_POST['editDoctorSpecialty'];

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
  if (checkLetters($first) && checkLetters($last) && checkPhone($phone) && 
      checkDates($birth) && checkNumbers($salary) && checkLetters($specialty))
  {
    // Update info in Person table
    $query = "UPDATE Person
              SET first = '$first', last = '$last', address = '$address',
                  phone = '$phone', gender = '$gender', birthdate = '$birth'
              WHERE ssn = '$ssn'";
    mysql_query($query) or die("Could not query: " . mysql_error());
  
    // Update info in Doctor table
    $query = "UPDATE Doctor
              SET salary = '$salary', specialty = '$specialty'
              WHERE ssn = '$ssn'";
    mysql_query($query) or die("Could not query: " . mysql_error());

    echo "success";
  }
  mysql_close($con);
?>