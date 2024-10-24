<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Aufgaben von <?php echo $_SESSION["username"]; ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php
                include("conn.php");
                $lid = $_SESSION['lid'];
                $stmt = $db->prepare("SELECT * FROM items INNER JOIN lists ON lists.LID = items.iLID WHERE iLID = ?");
                $stmt->execute([$lid]);
                $result = $stmt->fetchAll();
                
                if (count($result) == 0) {
                    echo "<p class='text-center'>Keine items vorhanden</p>";
                    return;
                }

                $lname = htmlspecialchars($result[0]['name']);
                echo "<p class='text-center'>Inhalt der Liste \"$lname\":</p>";
                ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Zu erledigen bis</th>
                                <th>Status</th>
                                <th>Erledigen</th>
                                <th>Löschen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $row) {
                                $command = "window.location.href='main.php?action=edititem&iid=" . $row['IID'] . "'";
                                $command2 = "window.location.href='main.php?action=deleteitem&iid=" . $row['IID'] . "'";
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['content']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['due']) . "</td>";
                                echo "<td>" . ($row['is_done'] ? 'Erledigt' : 'Nicht erledigt') . "</td>";
                                if ($row["is_done"] == 0) {
                                    echo "<td><button onclick=\"$command\" class='btn btn-success'>Erledigt</button></td>";
                                } else {
                                    echo "<td></td>";
                                }
                                echo "<td><button onclick=\"$command2\" class='btn btn-danger'>Löschen</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
