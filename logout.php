
<?php 
     require('./funktions.php');
     if(!authenticated()){
      redirect('./website.php');
     }
     logout();

?>