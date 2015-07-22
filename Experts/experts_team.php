<?php
    $page_title = "Convo Expert Team";
    $title = "Convo Portal | Expert Team";
    include("./../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Convo Expert Team</h1>
            <p>Description here</p>

            <h2>Management Team</h2>
            <div class="management_team_div">
                <figure>
                    <img src="images/nick_stark.png" class="management_team" alt="Nick Stark"/>
                    <figcaption><strong>Nick Stark</strong><br/>Director of Experts</figcaption>
                </figure>
                <figure>
                    <img src="images/michelle_lapides.png" class="management_team" alt="Michelle Lapides"/>
                    <figcaption><strong>Michelle Lapides</strong><br/>Core Development</figcaption>
                </figure>
                <figure>
                    <img src="images/elena_shapiro.png" class="management_team" alt="Elena Shapiro"/>
                    <figcaption><strong>Elena Shapiro</strong><br/>Expert Manager</figcaption>
                </figure>
                <figure>
                    <img src="images/robert_herin.png" class="management_team" alt="Robert Herin"/>
                    <figcaption><strong>Robert Herin</strong><br/>Support Manager</figcaption>
                </figure>
            </div>

            <h2>Top Experts</h2>

<?php
    include("./../assets/inc/footer.inc.php");
?>