<!doctype html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/66d450dc17.js" crossorigin="anonymous"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../bootstrap5/bootstrap.css">
    <link rel="stylesheet" href="../css/For-project.css">


    <title>BLOG</title>
</head>
<?php
include "../controls/work_with_form_data.php";
$post = select_post_by_link("posts", "users", $_GET['topic_id'], $_GET['id']);

if (file_exists("../includes/header.php")) {
    require_once "../includes/header.php";
}
?>

<div class="container-xxl">
    <div class="content-row">
        <!----main-content (start)---->
        <div class="main-content col-md-9">
            <h2><?= $post[0]['title'] ?></h2><br>
            <hr>
            <div class="poster row">
                <div class="img col-12 col-md-4">
                    <img src="<?= PROJECT_PATH . "image/posts/" . $post[0]['img'] ?>"
                         class="d-block w-100"
                         alt="<?= $post[0]['title'] ?>">
                    <h3>My-Instagram(<a href="#">Alla_Fashion_#</a>)</h3>
                    <h3>My-Telegram(<a href="#">web-Enjoy[*_*]</a>)</h3>
                </div>
                <br>
                <div class="poster_text col-12 col-md-8">
                    <h3><?= $post[0]['title'] ?></h3>
                    <i class="far fa-user"> Author Name: <?= $post[0]['author'] ?></i><br>
                    <i class="far fa-calendar"> Date: <?= $post[0]['date_of_creation'] ?></i>
                    <hr>
                    <p class="preview-start">
                    <p>
                        <?= $post[0]['content'] ?>
                        I find petite-friendly denim at many brands, but my top pick for all-around comfort,
                        quality,
                        and fit continues to be Madewell. Their spring denim, in particular, tends to be my
                        favorite
                        year after year. I love the lighter washes, and the weight of the denim, and many of the
                        styles
                        are also often cropped, making them the best fit for my height. Today I’m sharing four
                        different
                        options I’ve tried and loved – bonus, they’re all 25% off now through 3/27 during the
                        Madewell
                        Insiders Event. You can sign in or sign up to be an insider with a simple email sign-up.
                    </p>
                    <h5>Petite-Friendly Spring Denim</h5>
                    My Sizing: I’m 4’10” and my bust, waist, and hip measurements are 32″, 24″ and 36″. My
                    typical
                    inseam is 24-25″. The clothes shown are unaltered and show how they fit me right from the
                    store.
                    I list my sizing beside each item to help you compare when shopping online.PETITE FASHION,
                    SPRING & SUMMER OUTFITS · MARCH 17, 2023

                    <h5>Kick Out Crop</h5>
                    A few years ago I bought a Cali Demi Boot pair of jeans from Madewell that are similar to
                    this pair and styled them regularly on my blog. This style fits almost the same, but has a
                    longer inseam, coming down to my ankle bone (I know a lot of you will appreciate that). The
                    jeans are stretchy and have a comfortable 8.5″ mid-rise. They’re true white and not
                    see-through! The top I’m wearing is also from Madewell and I’m wearing it in XXS. I pinned
                    the v-neck because it was too low for me.
                    <h5>Petite-Friendly Spring Denim</h5>
                    <p>
                        My Sizing: I’m 4’10” and my bust, waist, and hip measurements are 32″, 24″ and 36″. My
                        typical
                        inseam is 24-25″. The clothes shown are unaltered and show how they fit me right from
                        the store.
                        I list my sizing beside each item to help you compare when shopping online.
                    </p>
                </div>
            </div>
        </div>
        <!----main-content (end)------>
        <!----right-sidebar (start)---->
        <div class="sidebar-content container">
            <h3>[--Search--]</h3>
            <hr>

            <div>
                <form action="main.php" method="post">
                    <label>
                        <input type="text" name="searcher" class="text-input " placeholder="What you are looking for?">
                    </label>
                </form>
            </div>
            <br>
            <div class="fashion-topics">
                <h3>Categories:</h3>
                <hr>
                <ul>
                    <?php
                    $topics = select_all('topics');
                    foreach ($topics as $topic):?>
                        <li><a href="main.php?category_id=<?= $topic['id'] ?>"><?= $topic['name'] ?></a></li>
                    <?php
                    endforeach; ?>
                </ul>
            </div>
        </div>
        <!----right-sidebar (end)---->
    </div>
</div>
<?php
if (file_exists("../includes/footer.php")) {
    require_once "../includes/footer.php";
}
?>