<?php

include '../_dbConnection.php';

if (!$isAdmin) {
    header('Location: /', true, 302);
    exit;
}

include '../_head.php';

// --------- Begin Body ------------
?>
<div class="container">
<h1>Error Log</h1>
<div class="row"><div class="col">
    <a href="/admin">Back to Admin tools</a><a href="clearErrors.php" class="float-end">Clear error log</a>
</div></div>
<hr>

<?php
$errorLog = file_get_contents('../../php_errors.log');
echo nl2br($errorLog);

echo("</div>");

include '../_footer.php';
?>