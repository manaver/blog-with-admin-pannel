<?php include "header.php";
if (isset($_SESSION['user_data'])) {
   $userID = $_SESSION['user_data']['0'];
}
// pagination
if (!isset($_GET['page'])) {
   $page = 1;
} else {
   $page = $_GET['page'];
} ?>
<!-- Pagination varaibles begin -->
<?php
$pagination = "SELECT * FROM blogs WHERE author_id='$userID'";
$run_q = mysqli_query($conn, $pagination);
$total_post = mysqli_num_rows($run_q);
$limit = 5;
$pages = ceil($total_post / $limit);
$offset = ($page - 1) * $limit;
?>
<!-- ------------------------- -->
<!-- Begin Page Content -->
<div class="container-fluid" id="adminpage">
   <!-- Page Heading -->
   <h5 class="mb-2 text-gray-800">Blog Posts</h5>
   <!-- DataTales Example -->
   <div class="card shadow">
      <div class="card-header py-3 d-flex justify-content-between">
         <div>
            <a href="add_blog.php">
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
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>Sr.No</th>
                     <th>Title</th>
                     <th>Category</th>
                     <th>Author</th>
                     <th>Date</th>
                     <th colspan="2">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $sql = "SELECT * FROM blogs LEFT JOIN categories ON blogs.category=categories.cat_id LEFT JOIN users ON blogs.author_id=users.user_id WHERE user_id='$userID' ORDER BY blogs.publish_date DESC limit $offset,$limit";
                  $query = mysqli_query($conn, $sql);
                  $rows = mysqli_num_rows($query);
                  if ($rows) {
                     while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>" . ++$offset . "</td>";
                        echo "<td>" . $row['blog_title'] . "</td>";
                        echo "<td>" . $row['cat_name'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . date('d M-Y', strtotime($row['publish_date'])) . "</td>";
                        echo "<td><a href='edit_blog.php?id=" . $row['blog_id'] . "' class='btn btn-sm btn-success'>Edit</td>";
                        // echo "<td><form class='mt'>";
                        // echo "<input type='submit' name='delete_btn' value='Delete' class='btn btn-sm btn-danger'>";
                        // echo "</form></td>";
                  ?>
                        <td>
                           <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete')">
                              <input type="hidden" name="id" value="<?= $row['blog_id'] ?>">
                              <input type="hidden" name="image" value="<?= $row['blog_image'] ?>">
                              <input type="submit" name="deletePost" value="Delete" class="btn btn-sm btn-danger">
                           </form>
                        </td>
                  <?php
                        echo "</tr>";
                     }
                  } else {
                     echo "<tr><td colspan='7'>No record found</td></tr>";
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
                        <a href="index.php?page=<?= $i ?>" class="page-link"><?= $i ?></a>
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
if (isset($_POST['deletePost'])) {
   $id = $_POST['id'];
   $image = "upload/" . $_POST['image'];
   $sql = "DELETE FROM `blogs` WHERE `blogs`.`blog_id` = '$id'";
   $result = mysqli_query($conn, $sql);
   if ($result) {
      unlink($image);
      $msg =  ["Post has been deleted Successfully", "success"];
      $_SESSION['msg'] = $msg;
      header("location:index.php");
   } else {
      $msg =  ["Failed Please try again", "danger"];
      $_SESSION['msg'] = $msg;
      header("location:index.php");
   }
}
?>


</body>

</html>