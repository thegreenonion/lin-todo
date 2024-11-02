<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        p {
            margin-left: 10px;
        }

        button {
            margin-left: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Listen von
                    <?php echo "<span style='color: cream;'>$_SESSION[username]</span>"; ?>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php
                echo "<h2>Deine Listen:</h2>";
                include("conn.php");
                include("./control/getListsByID.php");
                if (count($result) == 0) {
                    $cmd = "window.location.href='main.php?action=newlist'";
                    echo "<p style='color: red; font-weight: bold'>Keine Listen vorhanden.</p>";
                    echo "<button class='btn btn-success' onclick=$cmd>Neue Liste erstellen</button>";
                } else {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered'>";
                    echo "<thead class='thead-dark'><tr><th>Name</th><th>Anzahl Aufgaben</th><th>Davon unerledigt</th><th>Geteilt mit</th><th>Löschen</th></tr></thead>";
                    echo "<tbody>";
                    foreach ($result as $row) {
                        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ?");
                        $stmt->execute([$row['LID']]);
                        $count = $stmt->fetch()[0];
                        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ? AND is_done = 0");
                        $stmt->execute([$row['LID']]);
                        $ocount = $stmt->fetch()[0];
                        $stmt = $db->prepare("SELECT users.username FROM darfsehen
                        INNER JOIN users ON users.BID = darfsehen.dBID
                        WHERE dLID = ?");
                        $stmt->execute([$row["LID"]]);
                        if ($stmt->rowCount() == 0) {
                            $str = "";
                        } else {
                            $str = "";
                            $str = $stmt->fetch()["username"];
                            while ($row2 = $stmt->fetch()) {
                                $str .= ", " . $row2["username"];
                            }
                            $str .= "<br><a class='text-decoration-none' href='main.php?action=removeuser&lid=" . $row["LID"] . "'>Verwalten</a>";
                        }
                        $cmd = "window.location.href='main.php?action=deletelist&lid=" . $row["LID"] . "'";
                        echo "<tr>
                                <td><a href='main.php?action=getitems&lid=$row[LID]'>$row[name]</a></td>
                                <td>$count</td>
                                <td><span style='color: red'>$ocount</span></td>
                                <td>
                                $str
                                </td>
                                <td><button onclick=$cmd class='btn btn-danger'>Löschen</button></td>
                            </tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <?php
                echo "<h2>Freigegebene Listen:</h2>";
                $bid = $_SESSION["BID"];
                $stmt = $db->prepare("SELECT * FROM darfsehen WHERE dBID = ?");
                $stmt->execute([$bid]);
                $result = $stmt->fetchAll();
                if (count($result) == 0) {
                    echo "<p style='color: red; font-weight: bold'>Keine Listen vorhanden.</p>";
                } else {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered'>";
                    echo "<thead class='thead-dark'><tr><th>Name</th><th>Anzahl Aufgaben</th><th>Davon unerledigt</th></tr></thead>";
                    echo "<tbody>";
                    foreach ($result as $row) {
                        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ?");
                        $stmt->execute([$row['dLID']]);
                        $count = $stmt->fetch()[0];
                        $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE iLID = ? AND is_done = 0");
                        $stmt->execute([$row['dLID']]);
                        $ocount = $stmt->fetch()[0];
                        $stmt = $db->prepare("SELECT * FROM lists WHERE LID = ?");
                        $stmt->execute([$row["dLID"]]);
                        $result2 = $stmt->fetch();
                        echo "<tr>
                                <td><a href='main.php?action=getitems&lid=$row[dLID]'>$result2[name]</a></td>
                                <td>$count</td>
                                <td><span style='color: red'>$ocount</span></td>
                            </tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>