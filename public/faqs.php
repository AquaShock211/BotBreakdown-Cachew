<?php
$pageTitle = "FAQs";
include './_dbConnection.php';
include './_head.php';
?>
<div class="container">
    <div class="row">
        <h1>Frequently Asked Questions</h1>
    </div>
    <hr>
    <ol id="faq">
        <li>Are you affiliated with FIRST&trade; Robotics?
            <ul>
                <li>No. We are an FRC team who wanted to make a tool for the worldwide community, to help raise the capabilities of ALL teams to do great scouting analysis!</li>
            </ul>
        </li>
        <li>Who is that robot on the front page?
            <ul>
                <li>That's <code>Bit-C</code> (pronounced "Bitsy"), our mascot!</li>
            </ul>
        </li>
        <li>Bit-C is awesome! Do you have stickers or anything?
            <ul>
                <li>Yes- look up The Coconuts at any of our events and we probably have some available! 😉</li>
            </ul>
        </li>
        <li>Who can I call or email to get help?
            <ul>
                <li>Sorry, we don't have official support. Like we said, we're an FRC team making a tool that we want to be useful! We can't make any guarantees or warranties or offer support.</li>
                <li>If there's an issue, you can open an issue in our <a href="https://github.com/mikejed/botbreakdown">Repository</a> on GitHub.</li>
                <li>If there's enough interest, we might also open a Discord server for community discussions.</li>
            </ul>
        </li>
        <li>How do I set or change my password?
            <ul>
                <li>You don't have or need a password for an account here.</li>
                <li>To register or to log in, we just send you an email so you can prove that you have access to the address you're logging in as.</li>
                <li>Your email is probably already provided by a company who is paid to keep things safe and secure. Their security measures are better than we could provide here.</li>
                <li>Besides, if we had you create a password for this site, we'd still have to offer a "forgot password" link that let you get back in using your email anyway.</li>
                <li>So by not having or storing passwords, there's that much less information of yours that we have. Bonus!</li>
            </ul>
        </li>
        <li>Why can't I find a BotBreakdown app in the store?
            <ul>
                <li>We don't have an app yet. We're evaluating our options for that, but for now the data entry pages are available offline once you load them the first time - just bookmark them and you can come right back to it - no app needed!</li>
            </ul>
        </li>
        <li>What happens if I submit new or edited data for the same team in the same match and event?
            <ul>
                <li>The new submission will completely overwrite/replace the old submission. A single scouter (login) can only submit once per event/match/team.</li>
                <li>Usually that's logical enough and works as you'd expect - the exception though is if you have lots of scouters on your team working offline, and maybe one or two mentors walking around and scanning the results in using their phones.
                    <ul>
                        <li>The submissions get attached to the login that submitted the data.</li>
                        <li>In 2024 that was the mentor/scanner, rather than the scouter. As of 2025 though, we've changed that and now a single mentor can scan multiple scouters' entries for the same team and match without conflict</li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>Why don't you include any fields for driver skill, speed categories, etc?
            <ul>
                <li>Subjective fields that aren't measurable are difficult to standardize from one scouter to another. If one scouter classifies a driver as "medium" skill, another might classify the same driver as "low" skill, depending on their experience. We find that objective data like actual counts of events are best for analysis.</li>
            </ul>
        </li>
        <li>Then why don't you include cycle time measurements?
            <ul>
                <li>Similar answer actually; it's hard to objectively measure cycle times the same from scouter to scouter and match to match, when sometimes a bot acts as a feeder, sometimes gets fed, and sometimes has to cycle across the full field. We are considering how to be able to capture objective data despite these challenges but it's still just an idea.</li>
            </ul>
        </li>
        <li>OK, but I really want my team to be able to store some data you don't support.
            <ul>
                <li>We totally get that! For now our solution is that we've added the ability to store <code>customDataKey</code> and <code>customData</code>.</li>
                <li>You won't be able to use our built-in data entry form, but don't let that stop your team! You can use any tool to create and submit data to our server.</li>
                <li>You'll probably want to JSON-encode the extra data you provide - analytics tools can easily pull this back apart later.</li>
                <li>The point of the <code>customDataKey</code> field is to let you find submissions that match your same data format.</li>
            </ul>
        </li>
        <li>How can I use another tool to submit data?
            <ul>
                <li>There are two options: a POST request, or a GET request. POST requests are the most reliable, but you might need to be able to link people directly to a submission page without having them actually submit a form (for example, if you use QR codes to embed the address), so we also accept GET submissions.</li>
                <li>GET requests should be made to https://www.botbreakdown.com/myevents/submit.php (don't forget to add the ? and the parameters for the data you're providing). Note that GET requests are necessarily limited in how much data you can send us - this limit is by your browser, not our site.</li>
                <li>POST requests should also be made to https://www.botbreakdown.com/myevents/submit.php with a <code>application/x-www-form-urlencoded</code> body containing all your data.</li>
            </ul>
        </li>
        <li>If I am submitting data from another tool, what fields can I store data into?
            <ul>
                <li>Here is a list of the fields for the current season:
                    <ul>
                        <?php
                        $dataPoints = $db->query("SELECT * FROM `dataPoint` WHERE `season` = $currentSeason;");
                        while($field = $dataPoints->fetch_object()){
                            echo('<li><strong>' . $field->dataKey . '</strong> (' . $field->dataType . ')</li>');
                        } ?>
                    </ul>
                </li>
                <li>(count and int are the same format when you're submitting data; in the results we provide averages for "count" fields, but not "int" fields).</li>
                <li>Some of the "int" fields will expect "1" for "true" and "0" for "false" (as in, did they accomplish the endgame goal, etc).</li>
                <li>More information on all this will be coming later. We're still working on v1 features, after all! But with this information and what you can download once you have made some submissions, we think this would get you started.</li>
            </ul>
        </li>
                        
    </ol>
</div>
<?php include './_footer.php'; ?>