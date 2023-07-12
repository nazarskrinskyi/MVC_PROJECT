<?php
$title = "Home Page";
ob_start();?>
<h1>Home</h1>
<?php $content = ob_get_clean();
include_once "../app/views/layout.php";
