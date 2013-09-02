<?php
  require_once("connect.php");

  $type = $_POST['type'];

  // SQL queries
  if ($type == "diagnosed")
  {
    $query = "SELECT first, last, patientID, primaryIllness
              FROM Patient NATURAL JOIN Person
              WHERE primaryIllness IS NOT NULL
              ORDER BY last";
  }
  else if ($type == "undiagnosed")
  {
    $query = "SELECT first, last, patientID
              FROM Patient NATURAL JOIN Person
              WHERE primaryIllness IS NULL
              AND dismissed IS NULL
              ORDER BY last";
  }
  else if ($type == "released")
  {
    $query = "SELECT first, last, patientID
              FROM Patient NATURAL JOIN Person
              WHERE primaryIllness IS NULL
              AND dismissed IS NOT NULL
              ORDER BY last";
  }
  $result = mysql_query($query);

  // Check query
  if (!$result)
  {
    $message = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }

  // Construct HTML string to return
  while ($row = mysql_fetch_assoc($result))
  {
?>
  <div class="listItem" id="<?php echo $row['patientID']; ?>">
    <div class="listID"><?php echo $row['patientID']; ?></div>
    <div class="listName"><?php echo $row['first'] . ' ' . $row['last']; ?></div>
    <div class="listSpecialty">
      <?php
        if ($type == "diagnosed")
        {
          echo $row['primaryIllness'];
        }
        else if ($type == "undiagnosed")
        {
          echo "Undiagnosed";
        }
        else if ($type == "released")
        {
          echo "Released";
        }
      ?>
    </div>
</div><!-- // .listItem -->
<?php
  }
  mysql_close($con);
?>