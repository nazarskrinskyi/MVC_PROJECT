<?php

error_reporting(E_ALL & ~E_WARNING);
include "../../db_code/db_functions.php";

//////////CREATE CATEGORY////////////////
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['topic_create'])) {
    $name = trim(strip_tags($_POST['name']));

    $description = trim(strip_tags($_POST['description']));
    $topics = select_all('topics');

    if ($name === '' || $description === '') {
        $err_msg = "\nSomething is not filled\n";
    } else {
        if (mb_strlen($name, 'UTF-8') < 2) {
            $err_msg = "\nCategory tittle is too short\n";
        } else {
            $topic = select(table: 'topics', params: ['name' => $name]);
            if (!empty($topics)) {
                for ($i = 0; $i < count($topics); $i++) {
                    if ($topics[$i]['name'] != $topic[0]['name']) {
                        $names[] = $topics[$i]['name'];
                    }
                }
                if (in_array($name, $names)) {
                    $err_msg = "\nSuch category is already set\n";
                }
            } else {
                $topic_data =
                    [
                        'name' => $name,
                        'description' => $description,
                    ];
                $last_topic = insert(table: 'topics', params: $topic_data);
                $topic = select('topics', ['id' => $last_topic]);
                header("location: " . PROJECT_PATH . "admin/topics/topic_index.php?res=created");
            }
        }
    }
}
//////////CREATE CATEGORY(END)////////////////


//////////EDIT CATEGORY////////////////

if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['topic_edit'])) {
    $topics = select_all('topics');

    $name = trim(strip_tags($_POST['name']));

    $description = trim(strip_tags($_POST['description']));

    $id = $_POST['id'];

    if ($name === '' || $description === '') {
        $err_msg = "\nSomething is not filled\n";
    } else {
        if (mb_strlen($name, 'UTF-8') < 2) {
            $err_msg = "\nCategory tittle is too short\n";
        } else {
            $topic = select('topics', ['id' => $id]);
            for ($i = 0; $i < count($topics); $i++) {
                if ($topics[$i]['name'] != $topic[0]['name']) {
                    $names[] = $topics[$i]['name'];
                }
            }
            if (in_array($name, $names)) {
                $err_msg = "\nSuch category is already set\n";
            } else {
                for ($i = 0; $i < count($topics); $i++) {
                    if ($name === $topics[$i]['name'] and $description === $topics[$i]['description']) {
                        $err_msg = "\nYou didn't modify category\n";
                        $check = false;
                    }
                }
                if (!isset($check)) {
                    $topic_data =
                        [
                            'name' => $name,
                            'description' => $description,
                        ];
                    $topic_id = update('topics', $id, $topic_data);
                    header("location: " . PROJECT_PATH . "admin/topics/topic_index.php?res=edited");
                }
            }
        }
    }
}
/*/////////////EDIT CATEGORY(END)*************/


/*//////////////DELETE CATEGORY////////////////*/
if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $topic = select('topics', ['id' => $id]);
    delete('topics', $id);
    header("location: http://localhost/test.loc/BIG_PROJECT/admin/topics/topic_index.php?res=deleted");
}
/*//////////////DELETE CATEGORY(END)////////////////*/


