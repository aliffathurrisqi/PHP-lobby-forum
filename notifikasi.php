<?php

include "config.php";

$id = $_GET['id'];
$post = $_GET['post'];

mysqli_query($conn, "UPDATE notifikasi set dibaca = 'Ya' WHERE id = '$id'");

?>
<script>
    location.replace("discussion.php?id=<?php echo $post; ?>")
</script>