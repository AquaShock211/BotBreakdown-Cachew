<?php

include './_dbConnection.php';
setcookie("user", "", time() - 3600, '/', 'botbreakdown.com');
$currentPersonId = 0;
include './_head.php';
?>

<div class="container">
    <div class="alert alert-success"><strong>You have been logged out.</strong><br>It's a good idea to close your browser now.</div>
</div>

<?php
include './_footer.php';
?>