<!--
 * This file contains the main HTML structure for the TODO application.
 * It includes a welcome message, links to the GitHub profiles of the contributors,
 * and buttons for user login and registration.
 * 
 * The page uses Bootstrap for styling and includes custom CSS for additional styling.
 * 
 * Elements:
 * - A header with a welcome message and links to contributors' GitHub profiles.
 * - Two buttons for navigating to the login and signup pages.
 * - A footer with copyright information and a contact note.
 * 
 * Dependencies:
 * - Bootstrap CSS from a CDN.
 * 
 * Custom Styles:
 * - h1: Bold font, centered text, margin-top of 10px.
 * - p: Left margin of 20px.
 * - footer: Fixed position at the bottom, full width, light background color, centered text.
 * - button: Block display, margin of 20px, width of 210px.
 * - .vertical-center: Centered vertically using absolute positioning and transform.
 */-->
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
        p {
            margin-left: 20px;
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
        button {
            display: block;
            margin: 20px;
            width: 210px;
        }
    </style>
</head>
<body>
    <h1 class="">
        Willkommen bei der TODO-Applikation von
        <a style="color: red" href="https://github.com/thegreenonion">thegreenonion</a>
        ,
        <a style="color: purple" href="https://github.com/skeund89">skeund89</a>
        und
        <a style="color: orange" href="https://github.com/leg0batman">leg0batman</a>
    </h1>
    <br>
    <div class="d-flex justify-content-center">
        <button onclick="window.location.href='login.php'" type="button" class="btn btn-primary btn-lg">Login</button>
        <button onclick="window.location.href='signup.php'" type="button" class="btn btn-primary btn-lg">Registrieren</button>
    </div>
    <?php
        $datenbank = "eulbert_gtodo";
        $host = "localhost";
        $user = "eulbert";
        $passwd = "noh8Ailaey";

        try 
        {
            $db = new PDO("mysql:dbname=$datenbank;host=$host", $user, $passwd);
            $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) 
        {
            die("Datenbankverbindung gescheitert: " . $e->getMessage());
        }

        $sql = $db->prepare("SELECT COUNT(*) FROM users");
        $sql->execute();
        $result = $sql->fetch();
        echo "<p style='color: red; text-align: right; margin-right: 20px; font-weight: bold'>
        Bereits " . $result[0] . " Menschen benutzen TODO bereits!
        <br>
        Sei der nächste: 
        <a href='./signup.php'>Registrieren!</a>
        </p>";
    ?>
</body>
<footer>
    <p>© 2024 thegreenonion, skeund89, leg0batman
        <br>
        Kontakt via GitHub
    </p>
</footer>
</html>