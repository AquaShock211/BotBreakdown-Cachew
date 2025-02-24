<?php
$pageTitle = "Account Change";
include './_dbConnection.php';
include './_head.php';

echo('<div class="container">');

// Delete any `addressChange` records where expireDateTime is in the past and newAddressConfirmed is not equal to 1
$clearOldRecords = $db->prepare("DELETE FROM `addressChange` WHERE `expireDateTime` < NOW() AND `newAddressConfirmed` <> 1");
$clearOldRecords->execute();

// make sure that the request has come in with a token and action
if (isset($_GET["token"]) && strlen($_GET["token"]) > 1 && isset($_GET["action"])) {

    // If action is "Approve"
    if ($_GET["action"] == "approve") {

        // Look for any `addressChange` records where the provided token matches the oldAddressCode
        $oldAddressMatch = $db->prepare("SELECT `id` FROM `addressChange` WHERE `oldAddressCode` = ? AND `oldAddressCode` IS NOT NULL AND `expireDateTime` >= NOW()");
        $oldAddressMatch->bind_param("s", $_GET["token"]);
        $oldAddressMatch->execute();
        $oldAddressMatchResult = $oldAddressMatch->get_result();
        $oldAddressMatchCount = $oldAddressMatchResult->num_rows;
        $oldAddressMatchData = $oldAddressMatchResult->fetch_all(MYSQLI_ASSOC);

        // If one is found, update it and clear the code
        if ($oldAddressMatchCount > 0) {
            foreach ($oldAddressMatchData as $recordId) {
                $updateRecord = $db->prepare("UPDATE `addressChange` SET `oldAddressCode` = null, `oldAddressConfirmed` = 1 WHERE `id` = " . $recordId["id"]);
                $updateRecord->execute();
                echo('<div class="alert alert-info">Thank you for confirming the change</div>');
            }
        } else {
            
            // Then look for any `addressChange` records where the provided token matches the newAddressCode
            $newAddressMatch = $db->prepare("SELECT `id` FROM `addressChange` WHERE `newAddressCode` = ? AND `newAddressCode` IS NOT NULL AND `expireDateTime` >= NOW()");
            $newAddressMatch->bind_param("s", $_GET["token"]);
            $newAddressMatch->execute();
            $newAddressMatchResult = $newAddressMatch->get_result();
            $newAddressMatchCount = $newAddressMatchResult->num_rows;
            $newAddressMatchData = $newAddressMatchResult->fetch_all(MYSQLI_ASSOC);

            // If one is found, update it and clear the code
            if ($newAddressMatchCount > 0) {
                foreach ($newAddressMatchData as $recordId) {
                    $updateRecord = $db->prepare("UPDATE `addressChange` SET `newAddressCode` = null, `newAddressConfirmed` = 1 WHERE `id` = " . $recordId["id"]);
                    $updateRecord->execute();
                    echo('<div class="alert alert-info">Thank you for confirming the change</div>');
                }
            } else {
                echo('<div class="alert alert-warning">No matching pending request found- please confirm you\'re using the latest message we sent. Although sometimes this message is shown as a "false negative", if your email program pre-loads links for your protection. If the link is correct and you haven\'t already clicked on it previously, it may already be done.</div>');
            }
        }

    } elseif ($_GET["action"] == "refuse") {
        // Delete the pending change.
        $findRejectedRequests = $db->prepare("SELECT `id` FROM `addressChange` WHERE `newAddressCode` = ? OR `oldAddressCode` = ?");
        $findRejectedRequests->bind_param("ss", $_GET["token"], $_GET["token"]);
        $findRejectedRequests->execute();
        $rejectedRequestsResult = $findRejectedRequests->get_result();
        $rejectedRequestsCount = $rejectedRequestsResult->num_rows;
        $rejectedRequestsResults = $rejectedRequestsResult->fetch_all(MYSQLI_ASSOC);

        if ($rejectedRequestsCount > 0) {
            foreach ($rejectedRequestsResults as $request) {
                $deleteRejectedRequests = $db->prepare("DELETE FROM `addressChange` WHERE `id` = ?");
                $deleteRejectedRequests->bind_param("i",$request["id"]);
                $deleteRejectedRequests->execute();
            }
            echo('<div class="alert alert-warning">The pending request has been deleted and the account will not be updated. Thanks!</div>');
        } else {
            echo('<div class="alert alert-danger">We weren\'t able to find a match for this pending change. It may have already been deleted.</div>');
        }
    }

} else {
    echo('<div class="alert alert-warning">Invalid request; please try the link in your email again</div>');
}

// Now check for any `addressChange` records where both newAddressConfirmed and oldAddressConfirmed are 1. If any are found, update the corresponding `scouter` record and delete the addressChange record.
$approvedChanges = $db->prepare("SELECT * FROM `addressChange` WHERE `oldAddressConfirmed` = 1 AND `newAddressConfirmed` = 1");
$approvedChanges->execute();
$approvedChangesResult = $approvedChanges->get_result();
$approvedChangesCount = $approvedChangesResult->num_rows;
$approvedChangesData = $approvedChangesResult->fetch_all(MYSQLI_ASSOC);

// If one or more are found, make the updates and clear the record
if ($approvedChangesCount > 0) {
    foreach ($approvedChangesData as $approvedRecord) {
        $updateRecord = $db->prepare("UPDATE `scouter` SET `email` = ?, `modifiedDateTime` = NOW() WHERE `id` = " . $approvedRecord["scouterId"]);
        $updateRecord->bind_param("s", $approvedRecord["newEmail"]);
        $updateRecord->execute();
        // If the updated record is the same as the record that was updated based on the token, show a message. Since the token updates were in a loop there's a chance this doesn't fire, but that would require a perfect match of a token which is EXTREMELY slight. I'm not accounting for that extreme edge case.
        if (isset($recordId) && $approvedRecord["id"] == $recordId["id"]) {
            echo('<div class="alert alert-success">Great! Your email change has been approved.');
            if ($currentPersonId == '') {
                echo (' <a href="/login.php">Log in now</a>.');
            }
            echo('</div>');
        }
        $clearChange = $db->prepare("DELETE FROM `addressChange` WHERE `id` = " . $approvedRecord["id"]);
        $clearChange->execute();
    }
}

echo('</div>');
include './_footer.php'; ?>