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
            <h2></h2><br>
            <hr>
            <div class="single-poster row">
                <div class="img col-12 col-md-4 photo">
                    <img src="<?= PROJECT_PATH . "image/posts/" . $post[0]['img'] ?>"
                         alt="<?= $post[0]['title'] ?>" class="post-image img-thumbnail modified">
                    <h3>My-Instagram(<a href="#">Arthur_Best_#</a>)</h3>
                    <h3>My-Telegram(<a href="#">web-Genius_#_</a>)</h3>
                </div>
                <br>
                <div class="single-poster_text col-12 col-md-8">
                    <h4><?= $post[0]['title'] ?></h4>
                    <i class="far fa-user"> Author Name: <?= $post[0]['author'] ?></i><br>
                    <i class="far fa-calendar"> Date: <?= $post[0]['date_of_creation'] ?></i>
                    <hr>
                    <p class="preview-start">
                        <?= $post[0]['content'] ?>
                    <h5>Having shorter hair is extremely convenient and so easy!</h5>
                    <p>Fine, it is not always that easy, but it definitely takes less time to take care of than when you
                        have almost a meter of have to deal with. Also it makes you feel more energized. I have been
                        fond of having this haircut and it seems like the most natural thing to keep on cutting it from
                        time to time, but then I wonder — what if I will never be able to grow my hair long again? What
                        if now is the chance to do it one more time and then I could have it short for the rest of my
                        life? As a result, I get confused and I cannot decide, what I want to do more.Apart from that,
                        there is the whole process of growing your hair out. Right now mine is somewhere in the middle
                        between short hair and regular hair, so it looks weird and it makes me uncomfortable. Every day
                        I look at it, I think how much I want it to either become really long already or to cut it right
                        now.</p>
                    <h5>What am I going to decide? I have no idea!</h5>
                    <p>
                        For now I am just trying to be patient and to take my time. Finally, the irritating thing is
                        that i cut my hair a few years ago and then every second person cut it that way too, so it
                        sometimes seems like everyone looks pretty much the same now, and I hate it too.
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