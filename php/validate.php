<?php
  // Validation and query cleaning
  function clean($field)
  {
    $cleanedField = mysql_real_escape_string($field);
    return $cleanedField;
  }

  // Returns true for only letters
  function checkLetters($field)
  {
    $field = str_replace(" ", "", $field);
    if (preg_match('/^\pL+$/u', $field)) {
      return true;
    }
    else
    {
     return false;
    }
  }

  // Returns true for only numbers
  function checkNumbers($field)
  {
    $field = str_replace(" ", "", $field);
    if (preg_match('/^\d+$/', $field)) {
      return true;
    }
    else
    {
     return false;
    }
  }

  // Returns true for xxx xx xxxx, xxxxxxxxx
  function checkSSN($field)
  {
    $field = str_replace(" ", "", $field);
    if (preg_match('/^[0-9]{9}$/', $field)) {
      return true;
    }
    else
    {
     return false;
    }
  }

  // Returns true if ssn is unique
  function checkUnique($field)
  {
    return (mysql_num_rows(mysql_query("SELECT * FROM Person WHERE ssn = '$field'")) <= 0);
  }

  // Returns true for xxx-xxx-xxxx
  function checkPhone($field)
  {
    if (preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $field)) {
      return true;
    }
    else
    {
     return false;
    }
  }

  function checkDates($field)
  {
    list($month, $day, $year) = explode('/', $field);
    if (checkdate($month, $day, $year))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
?>