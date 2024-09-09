<?php
$con = mysqli_connect("localhost","ibexe","673603","dailyexpense");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error() ." | Seems like you haven't created the DATABASE with an exact name";
  }
?>
