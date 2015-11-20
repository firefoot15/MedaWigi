
<?php 
include '../contact.php';

        session_start();
        session_destroy();
        header("location:personhome.php?id=<?php echo htmlspecialchars($id); ?>");

?>
