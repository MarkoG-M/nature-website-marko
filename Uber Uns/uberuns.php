<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Über uns</title>
    <link rel="stylesheet" href="uberuns.css">
</head>
<body>
    <?php session_start(); ?>
<?php include "../header.php"; ?>

    <div class="main-content">
        <div class="container">
            <div class="content-block">
                <h2 class="content-title">Unsere Vision</h2>
                <p class="content-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse potenti. Cras ac massa ac elit sagittis dictum. 
                    Duis in lacus nisi. Integer sit amet justo id risus aliquam pulvinar non eget orci. Aenean tincidunt elit vel felis faucibus, 
                    in pellentesque mauris fermentum.
                </p>
            </div>
            <div class="content-block">
                <h2 class="content-title">Unsere Mission</h2>
                <p class="content-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque non sapien at sapien aliquam consequat. 
                    Curabitur ac risus ut nulla vehicula luctus at eget lorem. Nullam malesuada viverra dolor, non laoreet nisi vestibulum at. 
                    Fusce nec metus eu eros tempus congue id nec neque.
                </p>
            </div>
            <div class="content-block">
                <h2 class="content-title">Unser Team</h2>
                <div class="team-members">
                    <div class="team-member">
                        <h3 class="team-name">Elon Musk</h3>
                        <p class="team-role">Gründer & CEO</p>
                        <p class="team-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vel felis non eros ullamcorper eleifend.</p>
                    </div>
                    <div class="team-member">
                        <h3 class="team-name">Beispiel</h3>
                        <p class="team-role">Chief Technology Officer</p>
                        <p class="team-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt libero vel mauris tempus, vel tincidunt felis malesuada.</p>
                    </div>
                    <div class="team-member">
                        <h3 class="team-name">Irgendwer</h3>
                        <p class="team-role">Head of Marketing</p>
                        <p class="team-bio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in felis ac purus malesuada convallis a ac magna.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="footer-text">© 2025 Natur Calls. Alle Rechte vorbehalten.</p>
        </div>
    </footer>
</body>
</html>
