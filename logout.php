<?php // logout.php
  require_once 'header.php';

  if (isset($_SESSION['user']))
  {
    destroySession();
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
  }
  else echo "<div class='center'>You cannot log out because
             you are not logged in</div>";
?>
    </div>
  </body>
</html>
