<?php 
  session_start();
  error_reporting(0);
  set_time_limit(0);
  require 'scrap-function.php'; 
  
  if($_POST['save'])   
  {   
	  echo array2csv($_SESSION['emails'],'sample.csv');
      unset($_SESSION['emails']); 
      echo '<h3 style="color:#00FF00">Your data saved . Close this popup window </h3>';	  
  }

?>
<form method="POST">
<input type="submit" name="save" value="Save" /> |
</form>