<?php
  require_once("connect.php");

  // Get ID from post and clean
  $id = $_POST['personID'];
  $id = mysql_real_escape_string($id);

  // SQL query for Doctor info
  $query = "SELECT * FROM Patient NATURAL JOIN Person WHERE patientID = '$id'";
  $result = mysql_query($query) or die("Could not query: " . mysql_error());;

  $row = mysql_fetch_assoc($result);
?>
<h2>Edit Patient</h2>
<!-- Patient form -->
<form class="form-horizontal" id="editPatientForm" action="php/updatePatient.php" method="post">
  <div class="control-group">
    <label class="control-label" for="editPatientFirst">First Name</label>
    <div class="controls">
      <input type="text" name="editPatientFirst" id="editPatientFirst" placeholder="First Name" value="<?php echo $row['first']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientLast">Last Name</label>
    <div class="controls">
      <input type="text" name="editPatientLast" id="editPatientLast" placeholder="Last Name" value="<?php echo $row['last']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientssn">Social Security Number</label>
    <div class="controls">
      <input type="text" name="editPatientssn" id="editPatientssn" placeholder="xxxxxxxxx" maxlength="9" value="<?php echo $row['ssn']; ?>" disabled>
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientAddress">Address</label>
    <div class="controls">
      <input type="text" name="editPatientAddress" id="editPatientAddress" placeholder="Street, City, State, Zip" value="<?php echo $row['address']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientPhone">Phone Number</label>
    <div class="controls">
      <input type="text" name="editPatientPhone" id="editPatientPhone" placeholder="123-456-7890" maxlength="12" value="<?php echo $row['phone']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientGender">Gender</label>
    <div class="controls">
      <label class="radio inline">
        <input type="radio" name="editPatientGender" id="editPatientGenderMale" value="Male" <?php if ($row['gender'] == "Male"){ ?>checked<?php } ?>>Male
      </label>
      <label class="radio inline">
        <input type="radio" name="editPatientGender" id="editPatientGenderFemale" value="Female" <?php if ($row['gender'] == "Female"){ ?>checked<?php } ?>>Female
      </label>
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientBirth">Birthdate</label>
    <div class="controls">
      <input type="text" name="editPatientBirth" id="editPatientBirth" placeholder="MM/DD/YYYY" maxlength="10" value="<?php echo $row['birthdate']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientBill">Bill</label>
    <div class="controls">
      <input type="text" name="editPatientBill" id="editPatientBill" placeholder="100000" maxlength="7" value="<?php echo $row['bill']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientIllness">Illness</label>
    <div class="controls">
      <input type="text" name="editPatientIllness" id="editPatientIllness" placeholder="Illness" value="<?php echo $row['primaryIllness']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientAdmit">Admittance Date</label>
    <div class="controls">
      <input type="text" name="editPatientAdmit" id="editPatientAdmit" placeholder="MM/DD/YYYY" maxlength="10" value="<?php echo $row['admitted']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientDismiss">Dismissal Date</label>
    <div class="controls">
      <input type="text" name="editPatientDismiss" id="editPatientDismiss" placeholder="MM/DD/YYYY" maxlength="10" value="<?php echo $row['dismissed']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editPatientDoctor">Doctor Assignment</label>
    <div class="controls">
      <?php

        // Get current doctorID
        $query = "SELECT doctorID FROM has WHERE patientID = '$id'";
        $result = mysql_query($query) or die("Could not query: " . mysql_error());;
        $row = mysql_fetch_assoc($result);
        $doctorID = $row['doctorID'];

        // Get all doctor IDs
        $query = "SELECT doctorID FROM Doctor ORDER BY doctorID";
        $result = mysql_query($query) or die("Could not query: " . mysql_error());;
      ?>
      <select name="editPatientDoctor" id="editPatientDoctor">
      <?php
        echo "<option>" . $doctorID . "</option>";
        while ($row = mysql_fetch_assoc($result))
        {
          echo "<option>" . $row['doctorID'] . "</option>";
        }
      ?>
      </select>
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="form-actions">
    <button type="submit" class="btn btn-inverse">Submit</button>
    <button type="reset" class="btn">Restore</button>
    <?php
      $query = "SELECT dismissed FROM Patient WHERE patientID = '$id'";
      $result = mysql_query($query) or die("Could not query: " . mysql_error());;
      $row = mysql_fetch_assoc($result);
      if ($row['dismissed'] == "")
      {
    ?>
      <button type="button" class="btn btn-danger" id="dismissPatient">Dismiss</button>
    <?php } ?>
  </div><!-- // .form-actions -->
</form><!-- // .form-horizontal -->
<?php
  mysql_close($con);
?>