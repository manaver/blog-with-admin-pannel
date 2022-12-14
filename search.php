<?php include "partials/header.php";
include "partials/_dbconnect.php";
//Search
$keyword = $_GET['keyword'];
if (empty($keyword)) {
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
$pagination = "SELECT * FROM blogs WHERE blog_title like '%$keyword%' OR blog_body like '%$keyword%'";
$run_q = mysqli_query($conn, $pagination);
$total_post = mysqli_num_rows($run_q);
$limit = 5;
$pages = ceil($total_post / $limit);
$offset = ($page - 1) * $limit;
?>
<!-- ------------------------- -->
<?php
$sql = "SELECT * FROM blogs LEFT JOIN categories ON blogs.category=categories.cat_id LEFT JOIN users ON blogs.author_id=users.user_id WHERE blog_title like '%$keyword%' OR blog_body like '%$keyword%' ORDER BY blogs.publish_date DESC limit $offset,$limit";
$run = mysqli_query($conn, $sql);
$row = mysqli_num_rows($run);
?>
<div class="container mt-2">
    <div class="row">
        <h3 class="mb-0">Search result for:<span class="text-primary"><?= $keyword ?></span></h3>
        <div class="col-lg-8">
            <hr>
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
                                        <a href="category.php?id=<?= $result['cat_id'] ?>" class="text-primary"> <span><i class="fa fa-tag" aria-hidden="true"></i></span> <?= $result['cat_name'] ?> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "<h5 class='text-danger' >No record found</h5>";
                echo "<b>Suggestions:</b>";
                echo "
                <ul>
                <li>Make sure that all words are spelled correctly.</li>
                <li>Try different keywords.</li>
                <li>Try more general keywords.</li>
                <li>Try fewer keywords.</li>
                </ul>";
            }
            ?>
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
                            <a href="search.php?keyword=<?= $keyword ?>&page=<?= $i ?>" class="page-link"><?= $i ?></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <!-- ---------------------------- -->
        </div>
        <?php include "sideBar.php"; ?>
    </div>
</div>

<?php include "partials/footer.php"; ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>