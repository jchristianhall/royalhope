<?php
  require_once("connect.php");

  // Get ID from post
  $id = $_POST['personID'];

  // SQL query for Doctor info
  $query = "SELECT * FROM Patient NATURAL JOIN Person WHERE patientID = '$id'";
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

<h2><?php echo $row['first'] . ' ' . $row['last']; ?></h2>
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
  <div class="profileBlockTitle"><span>Information</span></div>
  <div class="profileBlockContent">

    <div class="profileItem">
      <div class="profileLabel">Bill</div>
      <div class="profileResult"><?php echo $row['bill']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Illness</div>
      <div class="profileResult">
        <?php 
          if (!$row['primaryIllness'])
          {
            if (!$row['dismissed'])
            {
              echo "Undiagnosed";
            }
            else
            {
              echo "Cured";
            }
          }
          else
          {
            echo $row['primaryIllness'];
          }
        ?>
      </div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Admitted</div>
      <div class="profileResult"><?php echo $row['admitted']; ?></div>
    </div><!-- // .profileItem -->
    <div class="profileItem">
      <div class="profileLabel">Dismissed</div>
      <div class="profileResult">
        <?php 
          if (!$row['dismissed'])
          {
            echo "Still in hospital";
          } 
          else
          {
            echo $row['dismissed'];
          }
        ?>
      </div>
    </div><!-- // .profileItem -->

  </div><!-- // .profileBlockContent -->
</div><!-- // .profileBlock -->

<?php

  // SQL query for doctor
  $query = "SELECT doctorID
            FROM has
            WHERE has.patientID = '$id'";
  $result = mysql_query($query);

  // Check query
  if (!$result)
  {
    $message = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }

  // Get doctor info based on fetched ID
  $row = mysql_fetch_assoc($result);
  $doctorID = $row['doctorID'];
  $doctorQuery = "SELECT first, last, specialty
                   FROM Doctor NATURAL JOIN Person
                   WHERE doctorID = '$doctorID'";
  $doctorResult = mysql_query($doctorQuery);
  $doctorRow = mysql_fetch_assoc($doctorResult);
?>

<div class="profileBlock">
  <div class="profileBlockTitle"><span>Doctor</span></div>
  <div class="profileBlockContent">
    <div class="profileItem">
      <div class="profileLabel"><?php echo $doctorRow['first'] . ' ' . $doctorRow['last']; ?></div>
      <div class="profileResult"><?php echo $doctorRow['specialty']; ?></div>
    </div><!-- // .profileItem -->
  </div><!-- // .profileBlockContent -->
</div><!-- // .profileBlock -->

<div class="profileEdit">
  <button class="btn btn-inverse btn-primary profileEditPatientButton" type="button">Edit</button>
</div><!-- // .profileEdit -->

<?php
  mysql_close($con);
?>