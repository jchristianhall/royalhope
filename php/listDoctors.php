<?php
  require_once("connect.php");

  // SQL query
  $query = "SELECT first, last, specialty, doctorID
            FROM Doctor NATURAL JOIN Person
            ORDER BY specialty";
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
  <div class="listItem" id="<?php echo $row['doctorID']; ?>">
    <div class="listID"><?php echo $row['doctorID']; ?></div>
    <div class="listName">Doctor <?php echo $row['first'] . ' ' . $row['last']; ?></div>
    <div class="listSpecialty">
      <?php echo $row['specialty']; ?>
    </div>
</div><!-- // .listItem -->
<?php
  }
  mysql_close($con);
?>