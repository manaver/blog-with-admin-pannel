<?php
include "header.php";
// GEt Blog ID
$blogID = $_GET['id'];
if (empty($blogID)) {
    header("location: categories.php");
}
if (isset($_SESSION['user_data'])) {
    $author_id = $_SESSION['user_data']['0'];
    // Fetch categories
    $sql = "SELECT * FROM  `categories`";
    $query = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM blogs LEFT JOIN categories ON blogs.category=categories.cat_id LEFT JOIN users ON blogs.author_id=users.user_id WHERE blog_id='$blogID'";
    $query2 = mysqli_query($conn, $sql2);
    $result = mysqli_fetch_assoc($query2);
}
?>
<div class="container">
    <!-- Page Heading -->
    <h5 class="mb-2 text-gray-800">Blog</h5>
    <div class="row">
        <div class="col-xl-12 col-lg-11">
            <div class="card">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary mt-2">Edit Blog/Article</h6>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" name="blog_title" placeholder="Title" class="form-control" value="<?php echo $result['blog_title']; ?>" required>
                        </div>
                        <div class=" mb-3">
                            <textarea name="blog_body" class="form-control" placeholder="Body" id="blog" rows="2" required><?= $result['blog_body'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="blog_image" class="form-control">
                            <img src="upload/<?= $result['blog_image'] ?>" alt="..." width="40%" class="my-2 border">
                        </div>
                        <div class=" mb-3 col-5">
                            <select class="form-control required" name="category">
                                <?php
                                while ($cats = mysqli_fetch_assoc($query)) {
                                    echo "<option value='" . $cats['cat_id'] . "'";
                                    if ($result['category'] == $cats['cat_id']) {
                                        echo "selected";
                                    } else {
                                        echo "";
                                    }
                                    echo ">" . $cats['cat_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="edit_blog" value="Update" class="btn btn-primary">
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
if (isset($_POST['edit_blog'])) {
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

    if (!empty($filename)) {
        if (in_array($image_ext, $allow_type)) {
            if ($size < 2000000) {
                $unlink = "upload/" . $result['blog_image'];
                unlink($unlink);
                move_uploaded_file($tmp_name, $destination);
                // $sql3 = "UPDATE blogs SET blog_title='$title',blog_body='$body',blog_image='$filename',category='$category',author_id='$author_id' WHERE blog_id='$blogID";
                $sql3 = "UPDATE `blogs` SET `blog_title` = '$title', `blog_body` = '$desc', `blog_image` = '$filename', `category` = '$category', `author_id` = '$author_id' WHERE `blogs`.`blog_id` = $blogID";
                $result3 = mysqli_query($conn, $sql3);
                if ($result3) {
                    $msg =  ["Post Updated successfully", "success"];
                    $_SESSION['msg'] = $msg;
                    header("location:index.php");
                } else {
                    $msg =  ["Failed! Please try again", "danger"];
                    $_SESSION['msg'] = $msg;
                    header("location:index.php");
                }
            } else {
                echo "";
                $msg =  ["Image size should not be greater than 2mb", "danger"];
                $_SESSION['msg'] = $msg;
                header("location:index.php");
            }
        } else {
            $msg =  ["File type is not allowed", "danger"];
            $_SESSION['msg'] = $msg;
            header("location:index.php");
        }
    } else {
        $sql3 = "UPDATE `blogs` SET `blog_title` = '$title', `blog_body` = '$desc', `category` = '$category', `author_id` = '$author_id' WHERE `blogs`.`blog_id` = $blogID";
        $result3 = mysqli_query($conn, $sql3);
        if ($result3) {
            $msg =  ["Post Updated successfully", "success"];
            $_SESSION['msg'] = $msg;
            header("location:index.php");
        } else {
            $msg =  ["Failed! Please try again", "danger"];
            $_SESSION['msg'] = $msg;
            header("location:index.php");
        }
    }
}
?>