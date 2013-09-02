<?php
  require_once("connect.php");

  // Get ID from post and clean
  $id = $_POST['personID'];
  $id = mysql_real_escape_string($id);

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

<!-- Edit Doctor form -->
<h2>Edit Doctor</h2>
<form class="form-horizontal" id="editDoctorForm" action="php/updateDoctor.php" method="post">
  <div class="control-group">
    <label class="control-label" for="editDoctorFirst">First Name</label>
    <div class="controls">
      <input type="text" name="editDoctorFirst" id="editDoctorFirst" placeholder="First Name" value="<?php echo $row['first']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editDoctorLast">Last Name</label>
    <div class="controls">
      <input type="text" name="editDoctorLast" id="editDoctorLast" placeholder="Last Name" value="<?php echo $row['last']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editDoctorssn">Social Security Number</label>
    <div class="controls">
      <input type="text" name="editDoctorssn" id="editDoctorssn" placeholder="xxxxxxxxx" maxlength="9" value="<?php echo $row['ssn']; ?>" disabled>
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editDoctorAddress">Address</label>
    <div class="controls">
      <input type="text" name="editDoctorAddress" id="editDoctorAddress" placeholder="Street, City, State, Zip" value="<?php echo $row['address']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editDoctorPhone">Phone Number</label>
    <div class="controls">
      <input type="text" name="editDoctorPhone" id="editDoctorPhone" placeholder="123-456-7890" maxlength="12" value="<?php echo $row['phone']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editDoctorGender">Gender</label>
    <div class="controls">
      <label class="radio inline">
        <input type="radio" name="editDoctorGender" id="editDoctorGenderMale" value="Male" <?php if ($row['gender'] == "Male"){ ?>checked<?php } ?>>Male
      </label>
      <label class="radio inline">
        <input type="radio" name="editDoctorGender" id="editDoctorGenderFemale" value="Female" <?php if ($row['gender'] == "Female"){ ?>checked<?php } ?>>Female
      </label>
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editDoctorBirth">Birthdate</label>
    <div class="controls">
      <input type="text" name="editDoctorBirth" id="editDoctorBirth" placeholder="MM/DD/YYYY" maxlength="10" value="<?php echo $row['birthdate']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editDoctorSalary">Salary</label>
    <div class="controls">
      <input type="text" name="editDoctorSalary" id="editDoctorSalary" placeholder="100000" maxlength="7" value="<?php echo $row['salary']; ?>">
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="control-group">
    <label class="control-label" for="editDoctorSpecialty">Specialty</label>
    <div class="controls">
      <select name="editDoctorSpecialty" id="editDoctorSpecialty">
        <option><?php echo $row['specialty']; ?>
        <option>General Practitioner</option>
        <option>Anesthesiologist</option>
        <option>Cardiologist</option>
        <option>Dentist</option>
        <option>General Surgeon</option>
        <option>Immunologist</option>
        <option>Neurologist</option>
        <option>Neurosurgeon</option>
        <option>Oncologist</option>
        <option>Pediatrician</option>
        <option>Radiologist</option>
        <option>Toxicologist</option>
      </select>
    </div><!-- // .controls -->
  </div><!-- // .control-group -->
  <div class="form-actions">
    <button type="submit" class="btn btn-inverse">Submit</button>
    <button type="reset" class="btn">Restore</button>
    <button type="button" class="btn btn-danger" id="fireDoctor">Release</button>
  </div><!-- // .form-actions -->
</form><!-- // .form-horizontal -->
<?php
  mysql_close($con);
?>