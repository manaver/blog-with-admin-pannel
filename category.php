<?php include "partials/header.php";
$id = $_GET['id'];
if (empty($id)) {
    header("location:index.php");
}
include "partials/_dbconnect.php";
$sql = "SELECT * FROM blogs LEFT JOIN categories ON blogs.category=categories.cat_id LEFT JOIN users ON blogs.author_id=users.user_id WHERE cat_id='$id'     ORDER BY blogs.publish_date DESC";
$run = mysqli_query($conn, $sql);
$row = mysqli_num_rows($run);
?>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-8">
            <?php
            if ($row) {
                while ($result = mysqli_fetch_assoc($run)) {
            ?>
                    <div class="card shadow mb-3">
                        <div class="card-body d-flex blog_flex">
                            <div class="flex-part1">
                                <a href="single_post.php?id=<?= $result['blog_id'] ?>"> <img src="admin/upload/<?= $result['blog_image'] ?>"> </a>
                            </div>
                            <div class="flex-grow-1 flex-part2">
                                <a href="single_post.php?id=<?= $result['blog_id'] ?>" id="title"><?= ucfirst($result['blog_title']) ?></a>
                                <p>
                                    <a href="single_post.php?id=<?= $result['blog_id'] ?>" id="body">
                                        <?= strip_tags(substr($result['blog_body'], 0, 200)) . "..." ?>
                                    </a><span><br>
                                        <a href="single_post.php?id=<?= $result['blog_id'] ?>" class="btn btn-sm btn-outline-primary">Continue Reading
                                        </a></span>
                                </p>
                                <ul>
                                    <li class="me-2"><a href=""> <span>
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span><?= $result['username'] ?></a>
                                    </li>
                                    <li class="me-2">
                                        <a href=""> <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span> <?php $date = $result['publish_date']; ?> <?= date('d-M-Y', strtotime($date)); ?></a>
                                    </li>
                                    <li>
                                        <a href="" class="text-primary"> <span><i class="fa fa-tag" aria-hidden="true"></i></span> <?= $result['cat_name'] ?> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

            <?php
                }
            }
            ?>
        </div>
        <?php include "sideBar.php"; ?>
    </div>
</div>

<?php include "partials/footer.php"; ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>