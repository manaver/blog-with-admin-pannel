<?php
include "header.php";
$id = $_GET['id'];
if (empty($id)) {
    header("location: categories.php");
}
$sql = "SELECT cat_name FROM `categories` WHERE cat_id='" . $id . "'";
$result = mysqli_query($conn, $sql);
$name = mysqli_fetch_assoc($result);
?>
<div class="container">
    <!-- Page Heading -->
    <h5 class="mb-2 text-gray-800">Categories</h5>
    <div class="row">
        <div class="col-xl-6 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary mt-2">Edit Category</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <input type="text" name="cat_name" value="<?php echo $name['cat_name']; ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="add_cat" value="Edit" class="btn btn-primary">
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
    $sql = "SELECT cat_name FROM `categories` WHERE `categories`.`cat_name` = '" . $cat_name . "' AND `categories`.`cat_id`!=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);
    echo $row;
    if ($row) {
        $msg =  ["Category name already exist", "danger"];
        $_SESSION['msg'] = $msg;
        header("location:http://localhost/blog/admin/categories.php");
        exit();
    }

    $sql = "UPDATE `categories` SET `cat_name` = '" . $cat_name . "' WHERE `categories`.`cat_id` = '" . $id . "'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $msg =  ["Category Edited Successfully", "success"];
        $_SESSION['msg'] = $msg;
        header("location:http://localhost/blog/admin/categories.php");
    } else {
        $msg =  ["Cannot edit category Please try again", "danger"];
        $_SESSION['msg'] = $msg;
        header("location:http://localhost/blog/admin/categories.php");
    }
}
?>