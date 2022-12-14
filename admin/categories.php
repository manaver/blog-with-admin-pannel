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
$pagination = "SELECT * FROM categories";
$run_q = mysqli_query($conn, $pagination);
$total_post = mysqli_num_rows($run_q);
$limit = 5;
$pages = ceil($total_post / $limit);
$offset = ($page - 1) * $limit;
?>
<!-- ------------------------- -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h5 class="mb-2 text-gray-800">Categories</h5>
    <!-- DataTales Example -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <a href="add_cat.php">
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
                            <th>Category name</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `categories` limit $offset,$limit";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $row_id = $row['cat_id'];
                                echo '<tr>';
                                echo '<td>' . ++$offset . '</td>';
                                echo '<td>' . $row['cat_name'] . '</td>';
                                echo '<td><a href="edit_cat.php?id=' . $row_id . '" class="btn btn-sm btn-success">Edit</a></td>';

                        ?>
                                <td>
                                    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete')">
                                        <input type="hidden" name="catID" value="<?= $row['cat_id'] ?>">
                                        <input type="submit" name="deleteCat" value="Delete" class="btn btn-sm btn-danger">
                                    </form>
                                </td>
                        <?php
                                echo '</tr>';
                            }
                        } else {
                            echo "<tr><td colspan='4'>No record found</td></tr>";
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
                                <a href="categories.php?page=<?= $i ?>" class="page-link"><?= $i ?></a>
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
if (isset($_POST['deleteCat'])) {
    $id = $_POST['catID'];
    $sql = "DELETE FROM `categories` WHERE `categories`.`cat_id` = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $msg =  ["Deleted Successfully", "success"];
        $_SESSION['msg'] = $msg;
        header("location:categories.php");
    } else {
        $msg =  ["Failed please try again", "danger"];
        $_SESSION['msg'] = $msg;
        header("location:categories.php");
    }
}
?>


</body>

</html>