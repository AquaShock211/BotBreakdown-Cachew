# Welcome to the BotBreakdown repository
BotBreakdown is a website for teams in [First&reg; Robotics Competition](https://www.firstinspires.org/robotics/frc) events.

Scouting is an important part of the robot games in FRC. We created BotBreakdown to allow teams' scouters to gather data without requiring an app, even when they're not online, and then submit the data for event analysis.

In the spirit of Coopertition&reg;, anyone submitting data to the server gains access to all submitters' data for that event.

BotBreakdown is a website so that teams like ours who can't install apps on school devices can still use it. And since WiFi connections are not allowed in the tournament, each event can be loaded ahead of time in your browser and will remain available even when you have no connection. Each time you submit results for a match, the site will store your information so you can submit it later, and/or encode it into a QR code that can be scanned and submitted by someone who is logged in on their phone.

The PHP code for the site is open-sourced here to allow teams to report bugs if needed and possibly make pull requests for new features.

As long as BotBreakdown.com is active, we recommend using that site rather than setting up your own site using this repo, to avoid separating teams into multiple unconnected silos. However, if you do wish to set up your own server based on these pages, you'll need to also create a database that matches the schema file. That file also inserts sample keys into the `settings` table so be sure to modify those as needed for your use!

---
_First&reg; and Coopertition&reg; are registered trademarks of [FIRST](https://www.firstinspires.org), which is not affiliated with and does not endorse BotBreakdown_