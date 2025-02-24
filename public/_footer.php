        <footer id="page-footer" class="bg-body-secondary text-center mt-3">

            <div class="container p-4">
                <section>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-4 mb-md-0">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="/privacy.php">Privacy Policy</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-3 col-6 mb-4 mb-md-0">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="/faqs.php">FAQs</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-3 col-6 mb-4 mb-md-0">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="/blog">Blog</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-3 col-6 mb-4 mb-md-0">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <?php
                                    if ($currentPersonId > 0) {
                                        echo('<a href="/myaccount.php">My Account</a>');
                                    } else {
                                        echo('<a href="/login.php">Log in or Register</a>');
                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>

            <div class="text-center p-3" style="background-color:rgba(0, 0, 0, 0.2);">
                Site and Bit-C mascot © <?php echo date("Y"); ?> by BotBreakdown.com<br>
                Data you provide here is available to any FRC team<br>
                <small>Event Data provided by <a href="//frc-events.firstinspires.org/services/API" target="_blank"><i>FIRST</i></a></small>
            </div>

        </footer>

    </body>
</html>

<?php $db->close(); ?>