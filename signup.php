<?php

/**
  * Process the form data
  */
function process_form(): bool {
  $username = $_POST['username'];
  $password = $_POST['password'];
  // Save the user data to the database or perform other actions
  $_SESSION["username"] = $username;
  echo "<script type='text/javascript'>location.href = './main.php';</script>";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (process_form()) {
    // Form processed successfully
  } else {
    echo 'Form processing failed. Please try again.';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Sign Up</h3>
                    </div>
                    <div class="card-body bg-light">
                        <form id="signupForm" action="" method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>
</html>
