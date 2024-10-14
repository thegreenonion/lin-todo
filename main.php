<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Liste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        h1 {
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            color: black;
            text-align: center;
        }
        .inline-paragraph {
            display: inline;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="main.php">TODO-Applikation</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="main.php?action=dashboard">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main.php?action=login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main.php?action=signup">Registrieren</a>
                    </li>
                    <?php
                    if(isset($_SESSION["BID"])) {
                        echo "
                        <li class='nav-item'>
                        <a class='nav-link' href='main.php?action=getlists'>Listen anzeigen</a>
                        </li>
                        ";
                    }
                    if(isset($_SESSION['BID']))
                    {
                        echo "<li class='nav-item'>";
                        echo "<a class='nav-link' href='main.php?action=logout'>Logout</a>";
                        echo "</li>";
                    }
                    ?>
                </ul>
                <span class="navbar-text">
                    Willkommen bei der TODO-Applikation von
                    <a style="color: red" href="https://github.com/thegreenonion">thegreenonion</a>,
                    <a style="color: purple" href="https://github.com/skeund89">skeund89</a> und
                    <a style="color: orange" href="https://github.com/leg0batman">leg0batman</a>
                </span>
            </div>
        </div>
    </nav>
    <br>
    <?php
        include("conn.php");

        $sql = $db->prepare("SELECT COUNT(*) FROM users");
        $sql->execute();
        $result = $sql->fetch();
        $count = $result[0];
        echo "<div>";
        if(!isset($_SESSION["username"]))
        {
            echo "<span style='color: red; float: right; font-weight: bold; margin-right: 20px;'>
            Du bist noch nicht angemeldet!
            </span>";
            
            echo "<span style='color: red; font-weight: bold; margin-left: 20px;'>
            Bereits " . $count . " Menschen benutzen TODO!</span>
            <br>
            <span style='color: red; font-weight: bold; margin-left: 20px;'>
            Sei der nächste: 
            <a href='main.php?action=signup'>Registrieren!</a>
            </span><br><br>";
        }
        else {
            echo "<span style='color: green; float: right; margin-right: 20px;'>
            Du bist angemeldet als <span style='color: blue'>" . $_SESSION['username'] . "</span>!
            </span><br><br>";
        }
        echo "</div>";
    ?>
    <div style="border: 2px solid black; padding: 10px; margin: 20px;">
        <?php
            if(isset($_GET["action"]))
            {
                if($_GET["action"] == "login") {
                    include("login.php");
                }
                else if($_GET["action"] == "signup") {
                    include("signup.php");
                }
                else if($_GET["action"] == "getlists") {
                    include("getlists.php");
                }
                else if($_GET["action"] == "logout") {
                    include("logout.php");
                }
                else if($_GET["action"] == "dashboard") {
                    include("dashboard.php");
                }
                else if($_GET["action"] == "getitems") {
                    $_SESSION["lid"] = $_GET["lid"];
                    include("getitems.php");
                }
            }
            else {
                echo "<div style='text-align: center'>";
                echo "<span>Hier könnte ihre Liste stehen!</span>";
                echo "</div>";
            }
        ?>
    </div>
</body>
<footer>
    <span>© 2024 thegreenonion, skeund89, leg0batman
        <br>
        Kontakt via GitHub
        <br>
        Benutzerzahl: <?php echo $count; ?>
    </span>
    <p></p>
</footer>
</html>