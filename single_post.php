<?php include "partials/header.php";
include "partials/_dbconnect.php";
$id = $_GET['id'];
if (empty($id)) {
    header("location:index.php");
}
$sql = "SELECT * FROM blogs WHERE blog_id='$id'";
$run = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($run);
?>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <div id="single_img">
                        <a href="admin/upload/<?= $post['blog_image'] ?>">
                            <img src="admin/upload/<?= $post['blog_image'] ?>" alt="">
                        </a>
                    </div>
                    <div class="mt-4">
                        <h5><?= ucfirst($post['blog_title']); ?></h5>
                        <p><?= $post['blog_body']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php include "sidebar.php"; ?>
    </div>
</div>