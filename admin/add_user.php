<?php include "header.php";
if (isset($_POST['add_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, sha1($_POST['password']));
    $c_pass = mysqli_real_escape_string($conn, sha1($_POST['c_pass']));
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    if (strlen($username) < 4 || strlen($username > 100)) {
        $error = "Username must be between 4 to 100 character";
    } else if (strlen($pass) < 4) {
        $error = "Password must be 4 character long";
    } else if ($pass != $c_pass) {
        $error = "Password does not match";
    } else {
        $sql = "SELECT * FROM `users` WHERE email='$email'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_num_rows($query);
        if ($row >= 1) {
            $error = "Email already exist";
        } else {
            $sql = "INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES ('$username', '$email', '$pass', '$role'); ";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                $msg =  ["User has been added successfully", "success"];
                $_SESSION['msg'] = $msg;
                header("location:users.php");
            } else {
                $error = "Failed! Please try again";
            }
        }
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 m-auto bg-light p-4">
            <h5 class="text-center mb-4">Create new user</h5>
            <?php
            if (!empty($error)) {
                $message = $error;
                echo '<div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
                ' . $message . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                unset($_SESSION['msg']);
            }
            ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" aria-describedby="emailHelp" value="<?= (!empty($error)) ? $username : '';  ?>" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" aria-describedby="emailHelp" value="<?= (!empty($error)) ? $email : '';  ?>" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="c_pass" name="c_pass" placeholder="Confirm Password" aria-describedby="emailHelp" required>
                </div>
                <select name="role" class="form-control mb-3" required>
                    <option value="">Select role</option>
                    <option value="1">Admin</option>
                    <option value="0">Co Admin</option>
                </select>

                <button type="submit" class="btn btn-primary mb-3" name="add_user">Create</button>
            </form>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>