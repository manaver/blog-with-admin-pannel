<?php include "header.php";
if ($admin != 1) {
    header("location:index.php");
}
// pagination
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
} ?>
<!-- Pagination varaibles begin -->
<?php
$pagination = "SELECT * FROM users";
$run_q = mysqli_query($conn, $pagination);
$total_post = mysqli_num_rows($run_q);
$limit = 5;
$pages = ceil($total_post / $limit);
$offset = ($page - 1) * $limit;
$sql = "SELECT * FROM users limit $offset,$limit";
$query = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($query);
?>
<!-- ------------------------- -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h5 class="mb-2 text-gray-800">Users</h5>
    <!-- DataTales Example -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <a href="add_user.php">
                    <h6 class="font-weight-bold text-primary mt-2">Add New</h6>
                </a>
            </div>
            <div>
                <form class="navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-white border-0 small" placeholder="Search for...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button"> <i class="fas fa-search fa-sm"></i> </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            if (isset($_SESSION['msg'])) {
                $message = $_SESSION['msg'];
                echo '<div class="mt-3 alert alert-' . $message[1] . ' alert-dismissible fade show" role="alert">
                ' . $message[0] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                unset($_SESSION['msg']);
            }
            ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($rows) {
                            while ($result = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td><?= ++$offset ?></td>
                                    <td><?= $result['username'] ?></td>
                                    <td><?= $result['email'] ?></td>
                                    <td><?php
                                        if ($result['role'] == 1) {
                                            echo "Admin";
                                        } else {
                                            echo "Co-Admin";
                                        }
                                        ?></td>
                                    <td>
                                        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete')">
                                            <input type="hidden" name="userid" value="<?= $result['user_id'] ?>">
                                            <input type="submit" name="deleteUser" value="Delete" class="btn btn-sm btn-danger">
                                        </form>
                                    </td>
                                </tr>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <!-- pagination frontend -->
                <?php
                if ($total_post > $limit) {
                ?>
                    <ul class="pagination pt-2 pb-5">
                        <?php for ($i = 1; $i <= $pages; $i++) { ?>
                            <li class="page-item <?php
                                                    if ($i == $page) {
                                                        echo 'active';
                                                    }
                                                    ?>">
                                <a href="users.php?page=<?= $i ?>" class="page-link"><?= $i ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <!-- ---------------------------- -->
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<?php include "footer.php";
if (isset($_POST['deleteUser'])) {
    $id = $_POST['userid'];
    $sql = "DELETE FROM `users` WHERE `users`.`user_id` = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $msg =  ["User has been deleted Successfully", "success"];
        $_SESSION['msg'] = $msg;
        header("location:users.php");
    } else {
        $msg =  ["Failed please try again", "danger"];
        $_SESSION['msg'] = $msg;
        header("location:users.php");
    }
}
?>


</body>

</html>