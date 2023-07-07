<?php

$title = "All Roles";
ob_start();

?>
    <h1 class=" text-center text-primary text-uppercase ">Roles</h1>
    <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/roles/create" class="btn-success btn mt-2 mb-3">Create role</a>
    <table class="table">
        <thead>
        <tr>
            <th class="col">Id</th>
            <th class="col">RoleName</th>
            <th class="col">RoleDescription</th>
            <th class="col-2">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($roles as $key => $role): ?>
            <tr>
                <td><?= $role['id'] ?></td>
                <td><?= $role['role_name'] ?></td>
                <td><?= $role['role_description'] ?></td>
                <td class="col-2">
                    <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/roles/edit/<?= $role['id'] ?>"
                       class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="POST" action="/<?= APP_BASE_PATH ?>/roles/delete/<?= $role['id'] ?>"
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

