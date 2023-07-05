<?php

include "../controls/work_with_form_data.php";
$page = $_GET['page'] ?? 1;
$limit = 2;
$offset = $limit * ($page - 1);
$all_pages = ceil(count_all_posts('posts') / $limit);

$posts = select_post_with_author_pages("posts", "users", $limit, $offset);
//////////////SEARCH POST BY TEXT//////////////////
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['searcher'])) {
    $posts = search_post_by_text($_POST['searcher'], 'posts', 'users');
    if (empty($posts)) {
        $err_msg = "\nNothing was found by indicated text\n";
        $posts = select_post_with_author("posts", "users");
    }
}
//////////////SEARCH POST BY TEXT(end)//////////////////

//////////////SHOW POSTS OF CHOSEN CATEGORY///////////////
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['category_id'])) {
    $posts = select_all_posts_of_chosen_category('posts', 'users', $_GET['category_id']);
    if (empty($posts)) {
        $err_msg = "\nPost list is empty for this category\n";
        $posts = select_post_with_author("posts", "users");
    }
}
//////////////SHOW POSTS OF CHOSEN CATEGORY(END)///////////////


?>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFblackLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../bootstrap5/bootstrap.css">
    <link rel="stylesheet" href="../css/For-project.css">


    <title>BLOG</title>
</head>


<?php
if (file_exists("../includes/header.php")) {
    require_once "../includes/header.php";
}

?>
<!---Carousel (start)--->
<main>
    <div class="container-xxl Carousel">
        <div class="row_carousel">
            <h2>Fashion World</h2>
        </div>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $top_posts = select_top_topic_from_post("posts");
                foreach ($top_posts

                as $key => $top_post):

                if ($key == 0):
                ?>
                <div class="carousel-item active">
                    <?php
                    else: ?>
                    <div class="carousel-item ">
                        <?php
                        endif;
                        ?>
                        <img src="<?= PROJECT_PATH . "image/posts/" . $top_post['img'] ?>"
                             class="d-block w-100"
                             alt="<?= $top_post['title'] ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5> <?php
                                $posts_ = select_post_by_link("posts", "users", $top_post['id_topic'], $top_post['id']);
                                if (strlen($top_post['title']) > 20) {
                                    ?>
                                    <a
                                            href="<?= PROJECT_PATH . "pages/single_{$posts_[0]['id']}.php?id={$posts_[0]['id']}&topic_id={$posts_[0]['id_topic']}" ?>"><?= substr(
                                            $top_post['title'],
                                            0,
                                            20
                                        ) . '...' ?></a>
                                    <?php
                                } else { ?>
                                    <a
                                            href="<?= PROJECT_PATH . "pages/single_{$posts_[0]['id']}.php?id={$posts_[0]['id']}&topic_id={$posts_[0]['id_topic']}" ?>"><?= $top_post['title'] ?></a>
                                    <?php
                                } ?></h5>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
</main>
<!---Carousel (end)--->


<div class="container-xxl">
    <div class="content-row">
        <!----main-content (start)---->
        <div class="main-content col-md-9">
            <h2>Latest Posts</h2><br>
            <?php
            if (isset($err_msg)) { ?>
                <div class="form-error">
                    <h4><i class="fa-solid fa-triangle-exclamation" style="color: black"></i><?= $err_msg ?><i
                                class="fa-solid fa-triangle-exclamation" style="color: black"></i></h4>
                </div>
                <?php
            } ?>
            <?php
            foreach ($posts as $key => $post): ?>
                <hr>
                <div class="poster row">
                    <div class=" img col-12 col-md-3">
                        <img src="<?= PROJECT_PATH . "image/posts/" . $post['img'] ?>"
                             alt="<?= $post['title'] ?>" class="post-image img-thumbnail modified">
                    </div>
                    <br>
                    <div class="poster_text col-12 col-md-8">
                        <?php
                        $posts_ = select_post_by_link("posts", "users", $post['id_topic'], $post['id']);
                        if (strlen($post['title']) > 20) {

                            ?>
                            <h3>
                                Post-Title: <a
                                        href="<?= PROJECT_PATH . "pages/single_{$posts_[0]['id']}.php?id={$posts_[0]['id']}&topic_id={$posts_[0]['id_topic']}" ?>"><?= substr(
                                        $post['title'],
                                        0,
                                        20
                                    ) . '...' ?></a>
                            </h3>
                            <?php
                        } else { ?>
                            <h3>
                                Post-Title: <a
                                        href="<?= PROJECT_PATH . "pages/single_{$posts_[0]['id']}.php?id={$posts_[0]['id']}&topic_id={$posts_[0]['id_topic']}" ?>"><?= $post['title'] ?></a>
                            </h3>
                            <?php
                        } ?>
                        <i class="far fa-user"> Author Name: <?= $post['author'] ?></i><br>
                        <i class="far fa-calendar"> Date: <?= $post['date_of_creation'] ?></i>
                        <p class="preview-start">
                            <?php
                            if (strlen($post['content']) > 200) { ?>
                                <?= substr($post['content'], 0, 200) . '...' ?>
                                <?php
                            } else { ?>
                                <?= $post['content'] ?>
                                <?php
                            } ?>
                        </p>
                    </div>
                </div>
                <hr>
            <?php
            endforeach; ?>
            <?php include "../includes/pagination.php" ?>
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
    require "../includes/footer.php";
}
?>
