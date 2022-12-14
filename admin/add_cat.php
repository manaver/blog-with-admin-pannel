<?php
include "header.php";
?>
<div class="container">
    <!-- Page Heading -->
    <h5 class="mb-2 text-gray-800">Categories</h5>
    <div class="row">
        <div class="col-xl-6 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <a href="add_cat.php">
                        <h6 class="font-weight-bold text-primary mt-2">Add Category</h6>
                    </a>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <input type="text" name="cat_name" placeholder="Category Name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="add_cat" value="Add" class="btn btn-primary">
                            <a href="categories.php" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
if (isset($_POST['add_cat'])) {
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    $sql = "SELECT * FROM `categories` WHERE cat_name='$cat_name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);
    if ($row) {
        $msg =  ["Category name already exist", "danger"];
        $_SESSION['msg'] = $msg;
        header("location:add_cat.php");
    } else {
        $sql2 = "INSERT INTO `categories` (`cat_name`) VALUES ('$cat_name'); ";
        $result2 = mysqli_query($conn, $sql2);
        if ($result2) {
            $msg =  ["Category added successfully", "success"];
            $_SESSION['msg'] = $msg;
            header("location:add_cat.php");
        } else {
            $msg =  ["Failed! Please try again", "danger"];
            $_SESSION['msg'] = $msg;
            header("location:add_cat.php");
        }
    }
}
?>