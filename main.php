<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Liste</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>

<body>
    <div class="container-fluid">
        <!-- Responsive Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="main.php">TODO-Applikation</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php
                        if (isset($_SESSION["BID"])) {
                            echo "
                            <li class='nav-item'>
                            <a class='nav-link' href='main.php?action=dashboard'>Home</a>
                            </li>
                            ";
                        } else {
                            eli("login", "Login");
                            eli("signup", "Registrieren");
                        }
                        ?>
                        <?php
                        function eli($value, $name)
                        {
                            echo "<li class='nav-item'>";
                            echo "<a class='nav-link' href='main.php?action=" . $value . "'>" . $name . "</a>";
                            echo "</li>";
                        }
                        if (isset($_SESSION["BID"])) {
                            eli("getlists", "Listen anzeigen");
                            eli("newlist", "Neue Liste");
                            eli("newitem", "Neue Aufgabe");
                            eli("adduser", "Listen freigeben");
                            eli("removeuser", "Listen entziehen");
                            eli("logout", "Logout");
                        }
                        ?>
                    </ul>
                    <span class="navbar-text text-muted">
                        Willkommen bei der TODO-Applikation von
                        <a href="https://github.com/thegreenonion" class="text-decoration-none">thegreenonion</a>,
                        <a href="https://github.com/skeund89" class="text-decoration-none">skeund89</a> und
                        <a href="https://github.com/leg0batman" class="text-decoration-none">leg0batman</a>!
                    </span>
                </div>
            </div>
        </nav>

        <!-- Status Display -->
        <div class="row mt-3">
            <div class="col">
                <?php
                include("conn.php");

                $sql = $db->prepare("SELECT COUNT(*) as count FROM users");
                $sql->execute();
                $result = $sql->fetch();
                $count = $result['count'];
                if (!isset($_SESSION["username"])) {
                    echo "<div class='alert alert-danger' role='alert'>";
                    echo "<strong>Du bist noch nicht angemeldet!</strong><br>";
                    echo "Bereits " . $count . " Menschen benutzen TODO! <a href='main.php?action=signup'>Registrieren!</a>";
                    echo "</div>";
                } else {
                    echo "<div class='alert alert-success' role='alert'>";
                    echo "Du bist angemeldet als <strong>" . $_SESSION['username'] . "</strong>!";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="row">
            <div class="col">
                <div class="border p-4 mb-4">
                    <?php
                    if (isset($_GET["action"])) {
                        if ($_GET["action"] == "login") {
                            include("login.php");
                        } else if ($_GET["action"] == "signup") {
                            include("signup.php");
                        } else if ($_GET["action"] == "getlists") {
                            include("getlists.php");
                        } else if ($_GET["action"] == "logout") {
                            include("logout.php");
                        } else if ($_GET["action"] == "dashboard") {
                            include("dashboard.php");
                        } else if ($_GET["action"] == "getitems") {
                            $lid = $_GET["lid"];
                            $stmt = $db->prepare("SELECT * FROM lists WHERE LID = ? AND lBID = ?");
                            $stmt->execute([$lid, $_SESSION["BID"]]);
                            $result = $stmt->fetchAll();
                            if (count($result) != 0) {
                                $_SESSION["lid"] = $_GET["lid"];
                                include("getitems.php");
                            } else {
                                $stmt = $db->prepare("SELECT * FROM darfsehen WHERE dLID = ? AND dBID = ?");
                                $stmt->execute([$lid, $_SESSION["BID"]]);
                                $result = $stmt->fetchAll();
                                if (count($result) != 0) {
                                    $_SESSION["lid"] = $_GET["lid"];
                                    include("getlistshared.php");
                                }
                            }
                        } else if ($_GET["action"] == "edititem") {
                            $_SESSION["IID"] = $_GET["iid"];
                            include("./control/edititem.php");
                        } else if ($_GET["action"] == "deleteitem") {
                            $_SESSION["IID"] = $_GET["iid"];
                            include("./control/deleteitem.php");
                        } else if ($_GET["action"] == "deletelist") {
                            $_SESSION["lid"] = $_GET["lid"];
                            include("./control/deletelist.php");
                        } else if ($_GET["action"] == "newitem") {
                            include("./newitem.php");
                        } else if ($_GET["action"] == "newlist") {
                            include("control/createList.php");
                        } else if ($_GET["action"] == "adduser") {
                            include("control/addUser.php");
                        } else if ($_GET["action"] == "removeuser") {
                            include("control/removeUser.php");
                        }
                    } else {
                        echo "<div style='text-align: center'>";
                        echo "<span>Hier könnte ihre Liste stehen!</span>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-auto py-3 text-center">
            <div class="container">
                <span>© 2024 thegreenonion, skeund89, leg0batman<br>Kontakt via GitHub<br>
                    <?php
                    include("conn.php");

                    $sql = $db->prepare("SELECT COUNT(*) as count FROM users");
                    $sql->execute();
                    $result = $sql->fetch();
                    $count = $result['count'];
                    ?>
                    Benutzerzahl: <?php echo $count; ?>
                </span>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>