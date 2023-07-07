<?php

ob_start();

$title = "User list";

?>
    <div class="container">
        <h1 class="text-center text-primary text-uppercase ">User List</h1>
        <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/users/create" class="btn-success btn mt-2 mb-3">Create user</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Email verify</th>
                <th scope="col">Is admin</th>
                <th scope="col">Role</th>
                <th scope="col">Is active</th>
                <th scope="col">Last login</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $key => $user): ?>
                <tr>
                    <th scope="row"><?= $user['id'] ?></th>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?php echo $user["email_verify"] ? 'Yes' : 'No' ?></td>
                    <td><?php echo $user["is_admin"] ? 'Yes' : 'No' ?></td>
                    <td><?= $user['role'] ?></td>
                    <td><?php echo $user["is_active"] ? 'Yes' : 'No' ?></td>
                    <td><?= $user['last_login'] ?></td>
                    <td>
                        <a href="/<?= APP_BASE_PATH ?>/users/edit/<?= $user['id'] ?>"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="POST" action="/<?= APP_BASE_PATH ?>/users/delete/<?= $user['id'] ?>"
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

        <?php if ($all_pages > 1): ?>
            <div class="pagination-wrapper ">
                <nav class="pagination justify-content-center">
                    <ul class="pagination">
                        <li class="page-item">
                            <?php
                            if ($page != 1): ?>
                                <a class="page-link" href="/<?= APP_BASE_PATH ?>/users/index/<?= $page - 1 ?>"
                                   aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            <?php endif; ?>
                        </li>

                        <?php
                        for ($i = 0; $i < $all_pages; $i++): ?>
                            <li class="page-item"><a class="page-link"
                                                     href="/<?= APP_BASE_PATH ?>/users/index/<?= $i + 1 ?>"><?= $i + 1 ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item">
                            <?php
                            if ($page != $all_pages): ?>
                                <a class="page-link" href="/<?= APP_BASE_PATH ?>/users/index/<?= $page + 1 ?>"
                                   aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
<?php $content = ob_get_clean();
include "app/views/layout.php";
