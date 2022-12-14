<?php
include "partials/_dbconnect.php";
session_start();
if (isset($_SESSION['user_data'])) {
    header("location: http://localhost/blog/admin/");
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Blog Post</title>
    <style>
        body {
            min-height: 100vh;
        }

        footer {
            top: 100%;
            position: sticky;
        }
    </style>
</head>

<body>
    <?php include "partials/header.php"; ?>
    <div class="container-fluid col-sm-9 col-md-6 mt-5 col-11">
        <?php
        if (isset($_SESSION['error']) && $_SESSION['error']) {
            echo '
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Alert! </strong>' . $_SESSION["error"] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>';
            unset($_SESSION['error']);
        }
        ?>
        <?php

        if (isset($_POST['login_btn'])) {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $pass = trim(mysqli_real_escape_string($conn, sha1($_POST['password'])));

            $sql = "SELECT * FROM `users` WHERE email='$email' AND password='$pass'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $user_data = array($row['user_id'], $row['username'], $row['role']);
                $_SESSION['user_data'] = $user_data;
                header("location: admin");
            } else {
                $_SESSION['error'] = "INVALID PASSWORD/USERNAME";
            }
            // $sql = "INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`) VALUES ('manav', 'vermamanav110@gmail.com', SHA1('9796211458'), '1');";
        }
        ?>
        <div class="h-100 p-5 bg-light border rounded-3">
            <h3>Login your account:</h3>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="login_btn">Login</button>
            </form>
        </div>
    </div>

    <?php include "partials/footer.php"; ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>