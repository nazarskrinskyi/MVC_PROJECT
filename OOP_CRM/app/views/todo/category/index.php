<?php

$title = "All Categories";
ob_start();

?>
    <h1 class=" text-center text-primary text-uppercase ">Categories</h1>
    <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/category/create" class="btn-success btn mt-2 mb-3">Create category</a>
    <table class="table">
        <thead>
        <tr>
            <th class="col">Id</th>
            <th class="col">Title</th>
            <th class="col">Description</th>
            <th class="col">Usability</th>
            <th class="col-2">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $key => $category): ?>
            <tr>
                <td><?= $category['id'] ?></td>
                <td><?= $category['title'] ?></td>
                <td><?= $category['description'] ?></td>
                <td><?= $category['usability'] == 1 ? 'yes' : 'no' ?></td>
                <td class="col-2">
                    <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/category/edit/<?= $category['id'] ?>"
                       class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="POST" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/category/delete/<?= $category['id'] ?>"
                          class="d-inline-block">
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Are you sure?')">Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php
$content = ob_get_clean();

include "app/views/layout.php";

