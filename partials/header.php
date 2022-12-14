<?php
$page = basename($_SERVER['PHP_SELF'], ".php");
include "_dbconnect.php";
$select = "SELECT * FROM categories";
$query = mysqli_query($conn, $select);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Blog Post</title>
    <style>
        body {
            min-height: 100vh;
        }

        footer {
            top: 100%;
            position: sticky;
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid mx-5">
            <a class="navbar-brand " href="#">Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php $pageName = basename($_SERVER['PHP_SELF'], ".php");
                                            if ($pageName == "index") echo "active"; ?>" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php while ($cats = mysqli_fetch_assoc($query)) { ?>
                                <li>
                                    <a class="dropdown-item" href="category.php?id=<?= $cats['cat_id'] ?>"><?= $cats['cat_name'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php $pageName = basename($_SERVER['PHP_SELF'], ".php");
                                            if ($pageName == "login") echo "active"; ?>" href="login.php">Login</a>
                    </li>
                </ul>
                <?php
                if (isset($_GET['keyword'])) {
                    $keyword = $_GET['keyword'];
                } else {
                    $keyword =  "";
                }
                ?>
                <form class="d-flex" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="keyword" maxlength="70" autocomplete="off" required value="<?= $keyword ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>