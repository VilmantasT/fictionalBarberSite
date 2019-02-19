<?php include "includes/header.php" ?>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php

        $_SESSION['registered'] = false;

         ?>
        <nav id="navigation">
            <h1 class="logo">
                <i class="fas fa-cut"></i> KX
            </h1>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="klientu_reg.php">Registruokis</a></li>
                    <li><a href="admin">Darbuotojams</a></li>
                </ul>
        </nav>
        <div class="message">
            prints message about booked visit if cookie was set
            <?php

            cookieMessage();

            ?>
        </div>
        <header id="showcase">


            <div class="showcase-content">

                <h1 class="text-center l-heading">Kirpykla X</h1>
                <p class="lead"> Rezervuokite laiką ir gaukite 10% nuolaidą
                     kas penktam apsilankymui.
                </p>

                <a class="btn" href="klientu_reg.php">Registruokis</a>
            </div>
        </header>



    </body>
</html>
