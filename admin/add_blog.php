<?php
include "header.php";
if (isset($_SESSION['user_data'])) {
    $author_id = $_SESSION['user_data']['0'];

    $sql = "SELECT * FROM  `categories`";
    $query = mysqli_query($conn, $sql);
}
?>
<div class="container">
    <!-- Page Heading -->
    <h5 class="mb-2 text-gray-800">Blog</h5>
    <div class="row">
        <div class="col-xl-12 col-lg-11">
            <div class="card">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary mt-2">Publish Blog/Article</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" name="blog_title" placeholder="Title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <textarea name="blog_body" class="form-control" placeholder="Body" id="blog" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="blog_image" class="form-control" required>
                        </div>
                        <div class="mb-3 col-5">
                            <select class="form-control required" name="category">
                                <option value="">Select Category</option>
                                <?php
                                while ($cats = mysqli_fetch_assoc($query)) {
                                    echo "<option value=" . $cats['cat_id'] . ">" . $cats['cat_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="add_blog" value="Add" class="btn btn-primary">
                            <a href="index.php" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
if (isset($_POST['add_blog'])) {
    $title = mysqli_real_escape_string($conn, $_POST['blog_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['blog_body']);
    // Image insertion in upload folder
    $filename = $_FILES['blog_image']['name'];
    $tmp_name = $_FILES['blog_image']['tmp_name'];
    $size = $_FILES['blog_image']['size'];
    $image_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allow_type = ['jpg', 'png', 'jpeg'];
    $destination = "upload/" . $filename;
    //Category
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    if (in_array($image_ext, $allow_type)) {
        if ($size < 2000000) {
            move_uploaded_file($tmp_name, $destination);
            $sql2 = "INSERT INTO `blogs` (`blog_title`, `blog_body`, `blog_image`, `category`, `author_id`) VALUES ('$title', '$desc', '$filename', '$category', '$author_id')";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                $msg =  ["Post published successfully", "success"];
                $_SESSION['msg'] = $msg;
                header("location:index.php");
            } else {
                $msg =  ["Failed! Please try again", "danger"];
                $_SESSION['msg'] = $msg;
                header("location:add_blog.php");
            }
        } else {
            echo "";
            $msg =  ["Image size should not be greater than 2mb", "danger"];
            $_SESSION['msg'] = $msg;
            header("location:add_blog.php");
        }
    } else {
        $msg =  ["File type is not allowed", "danger"];
        $_SESSION['msg'] = $msg;
        header("location:add_blog.php");
    }
}
?>