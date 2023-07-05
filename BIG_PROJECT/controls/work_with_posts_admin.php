<?php

include "../../db_code/db_functions.php";


//////////CREATE POST////////////////
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['post_create'])) {
    $title = trim(strip_tags($_POST['title']));
    $topic = $_POST['topics'];
    $content = strip_tags($_POST['content']);
    $status = isset($_POST['publish']) ? "published" : "unpublished";
    $posts = select_all(table: 'posts');

    $img = $_FILES['img']['name'];

    for ($i = 0; $i < count($posts); $i++) {
        if ($posts[$i]["title"] === $title) {
            $err_msg = "\nTitle name duplication\n";
        }
    }
    if ($title === '' || $content === '' || $topic == '' || $img == "") {
        $err_msg = "\nSomething is not filled\n";
    } else {
        if (mb_strlen($title, 'UTF-8') < 7) {
            $err_msg = "\nTittle name is too short\n";
        } else {
            if (!empty($_FILES)) {
                $img_check = str_starts_with($_FILES['img']['type'], 'image');
                if ($img_check === true) {
                    if ($_FILES['img']['size'] <= 1000000) {
                        $img_tmp = $_FILES['img']['tmp_name'];
                        $arr_size = getimagesize($img_tmp);
                        if ($arr_size[0] == 400 and $arr_size[1] == 300) {
                            $img = time() . '_' . $_FILES['img']['name'];
                            $destination = ROOT_PATH . "\\image\\posts\\" . $img;
                            $img_move = move_uploaded_file($img_tmp, $destination);
                            $post_data =
                                [
                                    'title' => $title,
                                    'content' => $content,
                                    'id_user' => $_SESSION['id'],
                                    'img' => $img,
                                    'status' => $status,
                                    'id_topic' => $topic
                                ];
                            insert(table: 'posts', params: $post_data);
                            header("location: http://localhost/BIG_PROJECT/admin/posts/post_index.php?res=created");
                        } else {
                            if ($arr_size[0] == 1024 and $arr_size[1] == 573) {
                                $img = time() . '_' . $_FILES['img']['name'];
                                $destination = ROOT_PATH . "\\image\\posts\\" . $img;
                                $img_move = move_uploaded_file($img_tmp, $destination);
                                $post_data =
                                    [
                                        'title' => $title,
                                        'content' => $content,
                                        'id_user' => $_SESSION['id'],
                                        'img' => $img,
                                        'status' => $status,
                                        'id_topic' => $topic
                                    ];
                                insert(table: 'posts', params: $post_data);
                                header("location: http://localhost/BIG_PROJECT/admin/posts/post_index.php?res=created");
                            } else {
                                $err_msg = "\nImage width or height is too large\n";
                            }
                        }
                    }
                } else {
                    $err_msg = "\nFile size is more than (1mb)\n";
                }
            } else {
                $err_msg = "\nWrong type of file was uploaded\n";
            }
        }
    }
}
//////////CREATE POST(END)////////////////


//////////EDIT POST////////////////
if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['id'])) {
    /*$id = $_GET['id'];
    $post = select('posts', ['id' => $id]);
    $id = $topic[0]['id'];
    $name = $topic[0]['name'];
    $description = $topic[0]['description'];*/
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['post_edit'])) {
    $title = trim(strip_tags($_POST['title']));
    $topic = $_POST['topics'];
    $content = strip_tags($_POST['content']);
    $status = isset($_POST['publish']) ? "published" : "unpublished";
    $id = $_GET['id'];
    $posts = select_all(table: 'posts');
    $top_post = select(table: 'posts', params: ['id' => $id]);
    $img = $_FILES['img']['name'];
    for ($i = 0; $i < count($posts); $i++) {
        if (($status == $posts[$i]['status'] && $title == $posts[$i]['title']) && ($content == $posts[$i]['content'] && $topic == $posts[$i]['id_topic']) && $img == $posts[$i]['img']) {
            $err_msg = "\nYou didn't modify category\n";
            $check = false;
        }
    }
    if ($title === '' || $content === '' || $topic == "" || $img == "") {
        $err_msg = "\nSomething is not filled\n";
    } else {
        if (mb_strlen($title, 'UTF-8') < 7) {
            $err_msg = "\nPost tittle name is too short\n";
        } else {
            if (!empty($_FILES)) {
                $img_check = str_starts_with($_FILES['img']['type'], 'image');
                if ($img_check === true) {
                    if ($_FILES['img']['size'] <= 1000000) {
                        $img_tmp = $_FILES['img']['tmp_name'];
                        $arr_size = getimagesize($img_tmp);
                        if (($arr_size[0] == 400 || $arr_size[1] == 300) && $top_post[0]['id_topic'] != 8) {
                            $img = time() . '_' . $_FILES['img']['name'];
                            $destination = ROOT_PATH . "\\image\\posts\\" . $img;
                            $img_move = move_uploaded_file($img_tmp, $destination);
                            $post_data =
                                [
                                    'title' => $title,
                                    'content' => $content,
                                    'id_user' => $_SESSION['id'],
                                    'img' => $img,
                                    'status' => $status,
                                    'id_topic' => $topic
                                ];
                            $post_id = update('posts', $id, $post_data);
                            header("location: http://localhost/BIG_PROJECT/admin/posts/post_index.php?res=edited");
                        } else {
                            if (($arr_size[0] == 1024 || $arr_size[1] == 573) && $top_post[0]['id_topic'] == 8) {
                                $img = time() . '_' . $_FILES['img']['name'];
                                $destination = ROOT_PATH . "\\image\\posts\\" . $img;
                                $img_move = move_uploaded_file($img_tmp, $destination);
                                $post_data =
                                    [
                                        'title' => $title,
                                        'content' => $content,
                                        'id_user' => $_SESSION['id'],
                                        'img' => $img,
                                        'status' => $status,
                                        'id_topic' => $topic
                                    ];
                                $post_id = update('posts', $id, $post_data);
                                header("location: http://localhost/BIG_PROJECT/admin/posts/post_index.php?res=edited");
                            } else {
                                $err_msg = "\nImage width or height is too large or too small\n";
                            }
                        }
                    } else {
                        $err_msg = "\nImage size is more than (1mb)\n";
                    }
                } else {
                    $err_msg = "\nWrong type of file was uploaded\n";
                }
            }
        }
    }
}
/*/////////////EDIT POST(END)*************/

/*/////////////POST PUBLISH*///////////////
if (isset($_GET['pub_id'])) {
    $id = $_GET['pub_id'];
    $status = $_GET['publish'];
    $post_id = update('posts', $id, ['status' => $status]);
    header("location: http://localhost/test.loc/BIG_PROJECT/admin/posts/post_index.php");
    exit();
}
/*/////////POST PUBLISH(END)*/////////////////////


/*//////////////DELETE POST////////////////*/
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $topic = select('posts', ['id' => $id]);
    delete('posts', $id);
    header("location: http://localhost/test.loc/BIG_PROJECT/admin/posts/post_index.php?res=deleted");
}
/*//////////////DELETE POST(END)////////////////*/
