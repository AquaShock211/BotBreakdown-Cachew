<?php
$authRequired = true;
include '../_dbConnection.php';
include '../_head.php';

$flagRemove = $db->prepare("DELETE FROM `flag` WHERE `submissionId` = ? AND `reportingScouterId` = $currentPersonId;");
logHistory("unflagged", json_encode($_REQUEST), "submission", $_GET["submissionId"]);

echo ("<div class=\"container\">");
    if (isset($_GET["submissionId"])) {

        $flagRemove->bind_param("i", $_GET["submissionId"]);
        $flagRemove->execute();

        echo("<div class=\"alert alert-success\">Done</div>");
    }

echo ("</div>");

include '../_footer.php';
?>