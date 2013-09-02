<?php
  require_once("connect.php");

  // Get ID from post
  $id = $_POST['personID'];
  
  // SQL query for Doctor info
  $query = "SELECT * FROM Doctor NATURAL JOIN Person WHERE doctorID = '$id'";
  $result = mysql_query($query);

  // Check query
  if (!$result)
  {
    $message = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }

  $row = mysql_fetch_assoc($result);
?>

<h2>Doctor <?php echo $row['first'] . ' ' . $row['last']; ?></h2>
<div class="profileBlock">
  <div class="profileBlockTitle"><span>Profile</span></div>
  <div class="profileBlockContent">

    <div class="profileItem">
      <div class="profileLabel">First Name</div>
      <div class="profileResult"><?php echo $row['first']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Last Name</div>
      <div class="profileResult"><?php echo $row['last']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Social Security Number</div>
      <div class="profileResult"><?php echo $row['ssn']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Address</div>
      <div class="profileResult"><?php echo $row['address']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Phone</div>
      <div class="profileResult"><?php echo $row['phone']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Gender</div>
      <div class="profileResult"><?php echo $row['gender']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Birthdate</div>
      <div class="profileResult"><?php echo $row['birthdate']; ?></div>
    </div><!-- // .profileItem -->

  </div><!-- // .profileBlockContent -->
</div><!-- // .profileBlock -->

<div class="profileBlock">
  <div class="profileBlockTitle"><span>Employment</span></div>
  <div class="profileBlockContent">

    <div class="profileItem">
      <div class="profileLabel">Salary</div>
      <div class="profileResult"><?php echo $row['salary']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Specialty</div>
      <div class="profileResult"><?php echo $row['specialty']; ?></div>
    </div><!-- // .profileItem -->

  </div><!-- // .profileBlockContent -->
</div><!-- // .profileBlock -->

<?php

  // SQL query for patient list
  $query = "SELECT patientID
            FROM has
            WHERE has.doctorID = '$id'";
  $result = mysql_query($query);

  // Check query
  if (!$result)
  {
    $message = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
?>

<div class="profileBlock">
  <div class="profileBlockTitle"><span>Patients</span></div>
  <div class="profileBlockContent">

    <?php 
    // Get patient info based on fetched ID
    while ($row = mysql_fetch_assoc($result))
    { 
      $patientID = $row['patientID'];
      $patientQuery = "SELECT first, last, primaryIllness
                       FROM Patient NATURAL JOIN Person
                       WHERE patientID = '$patientID'";
      $patientResult = mysql_query($patientQuery);

      // Check query
      if (!$patientResult)
      {
        $message = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $patientQuery;
        die($message);
      }
      $patientRow = mysql_fetch_assoc($patientResult);

    ?>
      <div class="profileItem">
        <div class="profileLabel"><?php echo $patientRow['first'] . ' ' . $patientRow['last']; ?></div>
        <div class="profileResult">
          <?php 
            if ($patientRow['primaryIllness'])
            {
              echo $patientRow['primaryIllness'];
            }
            else
            {
              echo "Undiagnosed";
            }
          ?>
        </div>
      </div><!-- // .profileItem -->
    <?php } ?>

  </div><!-- // .profileBlockContent -->
</div><!-- // .profileBlock -->

<div class="profileEdit">
  <button class="btn btn-inverse btn-primary profileEditDoctorButton" type="button">Edit</button>
</div><!-- // .profileEdit -->

<?php
  mysql_close($con);
?>