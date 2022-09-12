<?php
$pindah = $_GET['url'];
$new_url = "..".$pindah;
?>
<script> location.replace("<?php echo $new_url;?>") </script>