<?php
session_unset();
session_destroy();
echo "<script>window.location.href='main.php'</script>";
exit();