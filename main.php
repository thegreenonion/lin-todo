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
    <h1>
        Willkommen bei der TODO-Applikation von
        <a style="color: red" href="https://github.com/thegreenonion">thegreenonion</a>
        ,
        <a style="color: purple" href="https://github.com/skeund89">skeund89</a>
        und
        <a style="color: orange" href="https://github.com/leg0batman">leg0batman</a>
    </h1>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto">
                <button onclick="window.location.href='main.php?action=login'" type="button" class="btn btn-primary btn-lg mb-2">Login</button>
            </div>
            <div class="col-auto">
                <button onclick="window.location.href='main.php?action=signup'" type="button" class="btn btn-primary btn-lg mb-2">Registrieren</button>
            </div>
            <?php
            if(isset($_SESSION['BID']))
            {
                $command = "window.location.href='main.php?action=getlists'";
                echo "<div class='col-auto'><button onclick=\"$command\" type='button' class='btn btn-primary btn-lg mb-2'>Listen anzeigen</button></div>";
            }
            ?>
        </div>
    </div>
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
            </span>";
        }
        else {
            echo "<span style='color: green; float: right; margin-right: 20px;'>
            Du bist angemeldet als <span style='color: blue'>" . $_SESSION['username'] . "</span>!
            </span>";
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
    <p>© 2024 thegreenonion, skeund89, leg0batman
        <br>
        Kontakt via GitHub
        <br>
        Benutzerzahl: <?php echo $count; ?>
    </p>
</footer>
</html>