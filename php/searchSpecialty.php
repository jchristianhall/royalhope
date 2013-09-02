<?php
  require_once("connect.php");

  // Get search value from search bar
  $search = $_POST['searchBar'];

  // Query cleaning
  $search = mysql_real_escape_string($search);

  // SQL query
  $query = "SELECT first, last, specialty, doctorID
            FROM Doctor NATURAL JOIN Person
            WHERE specialty LIKE '%$search%'
            ORDER BY specialty";
  $result = mysql_query($query);

  // Check query
  if (!$result)
  {
    $message = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }

  // Add fetched info to HTML
  while ($row = mysql_fetch_assoc($result))
  {
?>
  <div class="searchItem" id="<?php echo $row['doctorID']; ?>">
    <div class="searchID"><?php echo $row['doctorID']; ?></div>
    <div class="searchName">Doctor <?php echo $row['first'] . ' ' . $row['last']; ?></div>
    <div class="searchInfo"><span>Specialty</span>
      <?php echo $row['specialty']; ?>
    </div>
  </div><!-- // .searchItem -->
<?php
  }
  mysql_close($con);
?>