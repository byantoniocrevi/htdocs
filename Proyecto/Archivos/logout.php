<?php
session_start();
ob_start();
$_SESSION = array();
session_destroy();
header("location: index.php");
exit;
?>
<script>
localStorage.clear()
//sessionStorage.clear()
	</script>