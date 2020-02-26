<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<body>
<?php
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
?>
<script>
    window.location.href = "index.php"; //redirect
</script>
</body>
</html>