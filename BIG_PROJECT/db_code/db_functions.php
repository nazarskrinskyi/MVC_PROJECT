<?php

require "connection.php";

function pretty(array $array): void
{
    if (!empty($array)) {
        echo "<pre>";
        print_r($array);
        echo "<pre>";
        exit();
    }
}

function error_checker($query): void
{
    $db_errors = $query->errorInfo();

    if ($db_errors[0] != PDO::ERR_NONE) {
        exit("query-error");
    }
}

function select_all(string $table): array
{
    global $connection;
    $sql = "SELECT * FROM $table";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker(query: $query);
    return $query->fetchAll();
}

function select(string $table, array $params = []): array
{
    $sql = "SELECT * FROM $table WHERE";
    $i = 0;
    if (!empty($params)) {
        foreach ($params as $key => $param) {
            $i++;
            if (count($params) > 1) {
                $sql .= " $table.$key=\"$param\" AND";
                if (count($params) == $i) {
                    $sql .= " $table.$key=\"$param\"";
                }
            } else {
                $sql .= " $table.$key=\"$param\"";
            }
        }
    } else {
        $sql = "SELECT * FROM $table";
    }
    global $connection;
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker(query: $query);
    return $query->fetchAll();
}

function update(string $table, int $id, array $params): void
{
    global $connection;
    $i = 0;
    $sql = "UPDATE $table SET";
    foreach ($params as $key => $param) {
        $i++;
        if (count($params) > 1) {
            if ($i == count($params)) {
                $sql .= " $key='$param'";
            } else {
                $sql .= " $key='$param',";
            }
        } else {
            $sql .= " $key='$param'";
        }
    }
    $sql .= " WHERE id='$id'";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker(query: $query);
}

function delete(string $table, int $id): void
{
    global $connection;
    $sql = "DELETE FROM $table WHERE id='$id'";

    $query = $connection->prepare($sql);

    $query->execute();
    error_checker(query: $query);
}

function insert(string $table, array $params): string
{
    global $connection;
    $sql = "INSERT INTO $table(";
    $keys = '';
    $values = '';
    $i = 0;
    foreach ($params as $key => $param) {
        $i++;
        if (count($params) == $i) {
            $keys .= "$key) VALUES(";
        } else {
            $keys .= "$key,";
        }
    }
    $i = 0;
    foreach ($params as $param) {
        $i++;
        if (count($params) == $i) {
            $values .= "'$param')";
        } else {
            $values .= "'$param',";
        }
    }
    $sql .= "$keys$values";
    $query = $connection->prepare($sql);

    $query->execute();
    error_checker(query: $query);
    return $connection->lastInsertId();
}


// displaying published posts with author IN ADMIN
function select_post_with_user(string $table_posts, string $table_users): array
{
    global $connection;
    $sql = "SELECT 
    posts.id as id,
    posts.title as title,
    posts.img as img,
    posts.content as content,
    posts.status as status,
    posts.id_topic as topic_id,
    posts.date_of_creation as date,
    users.username as username
    FROM $table_posts as posts
    LEFT JOIN $table_users as users
    on posts.id_user=users.id";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker($query);
    return $query->fetchAll();
}


// displaying published posts with author IN MAIN PAGE
function select_post_with_author(string $table_posts, string $table_users): array
{
    global $connection;
    $sql = "SELECT 
    posts.*,
    users.username as author
    FROM $table_posts as posts
    LEFT JOIN $table_users as users
    on posts.id_user=users.id where posts.status='published'";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker($query);
    return $query->fetchAll();
}

//Pagination in main
function select_post_with_author_pages(string $table_posts, string $table_users, int $limit, int $offset): array
{
    global $connection;
    $sql = "SELECT 
    posts.*,
    users.username as author
    FROM $table_posts as posts
    LEFT JOIN $table_users as users
    on posts.id_user=users.id where posts.status='published' LIMIT $limit OFFSET $offset";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker($query);
    return $query->fetchAll();
}

function select_post_by_link(string $table_posts, string $table_users, int $topic_id, int $id): array
{
    global $connection;
    $sql = "SELECT 
        posts.*,
        users.username as author
        FROM $table_posts as posts
        INNER JOIN $table_users as users on posts.id_user=users.id
        where posts.id_topic=$topic_id and posts.id=$id";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker($query);
    return $query->fetchAll();
}

///// function for selecting posts for carousel
function select_top_topic_from_post(string $table_posts): array
{
    global $connection;
    $sql = "SELECT * FROM $table_posts WHERE $table_posts.id_topic=8";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker($query);
    return $query->fetchAll();
}

// search logic by titles names
function search_post_by_text(string $text, string $table_posts, string $table_users): array
{
    global $connection;
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    $sql = "SELECT 
    posts.*,
    posts.id as id,
    users.username as author
    FROM $table_posts as posts
    INNER JOIN $table_users as users
    on posts.id_user=users.id where posts.status='published' and posts.title Like '%$text%' or posts.content Like '%$text%'";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker($query);
    return $query->fetchAll();
}

function select_all_posts_of_chosen_category(string $table_posts, string $table_users, int $id): array
{
    global $connection;
    $sql = "SELECT 
    posts.*,
    posts.id as id,
    users.username as author
    FROM $table_posts as posts
    INNER JOIN $table_users as users
    on posts.id_user=users.id where posts.id_topic=$id";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker($query);
    return $query->fetchAll();
}

function count_all_posts(string $table_posts): int
{
    global $connection;
    $sql = "SELECT COUNT(*) FROM $table_posts where $table_posts.status='published'";
    $query = $connection->prepare($sql);
    $query->execute();
    error_checker($query);
    return $query->fetchColumn();
}
