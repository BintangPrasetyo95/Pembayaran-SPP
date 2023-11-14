<?php
require_once 'header.php';
?>
  <?php
    require_once 'header-up.php';
  ?>

  <?php  
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard' ;
    include $page . '.php';
  ?>

<?php
require_once 'footer.php';
?>