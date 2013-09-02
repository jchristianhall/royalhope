<?php
  require_once("connect.php");

  // Get search value from search bar
  $search = $_POST['searchBar'];

  // Query cleaning
  $search = mysql_real_escape_string($search);

  // SQL query
  $query = "SELECT first, last, primaryIllness, patientID
            FROM Patient NATURAL JOIN Person
            WHERE primaryIllness LIKE '%$search%'
            ORDER BY primaryIllness";
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
  <div class="searchItem" id="<?php echo $row['patientID']; ?>">
    <div class="searchID"><?php echo $row['patientID']; ?></div>
    <div class="searchName"><?php echo $row['first'] . ' ' . $row['last']; ?></div>
    <div class="searchInfo"><span>Illness</span>
      <?php echo $row['primaryIllness']; ?>
    </div>
  </div><!-- // .searchItem -->
<?php
  }
  mysql_close($con);
?>