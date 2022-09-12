<?php

include "config.php";

$pindah = $_GET['url'];
$id_like = $_GET['id'];
$new_url = ".." . $pindah;

mysqli_query($conn, "DELETE FROM like_unlike WHERE id = '$id_like'");

?>
<script>
    location.replace("<?php echo $new_url; ?>")
</script>