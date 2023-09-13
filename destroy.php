<!-- Action file to destroy session. -->
<html><body>
<?php
session_start();
session_destroy();
//Send user to index page.
header('Location: index.php');
?>
</body></html>