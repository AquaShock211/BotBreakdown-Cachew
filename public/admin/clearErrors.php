<?php

include '../_dbConnection.php';

if (!$isAdmin) {
    header('Location: /', true, 302);
    exit;
}

include '../_head.php';

file_put_contents("../../php_errors.log", "");

// --------- Begin Body ------------
?>
<div class="container">
<h1>Clear Error Log</h1>
<hr>
Done :)<br>
<a href="errors.php">Go back</a>

</div>
<?php
include '../_footer.php';
?>