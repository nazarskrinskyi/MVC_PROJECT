<?php

$title = "All Pages";
ob_start();
?>
    <h1 class=" text-center text-primary text-uppercase ">Pages</h1>
    <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/pages/create" class="btn-success btn mt-2 mb-3">Create page</a>
    <table class="table">
        <thead>
        <tr>
            <th class="col">Id</th>
            <th class="col">Title</th>
            <th class="col">Slug</th>
            <th class="col">Role</th>
            <th class="col-2">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pages as $key => $elem): ?>
            <tr>
                <td><?= $elem['id'] ?></td>
                <td><?= $elem['title'] ?></td>
                <td><?= $elem['slug'] ?></td>
                <td><?= $elem['role'] ?></td>
                <td class="col-2">
                    <a href="/<?= APP_BASE_PATH ?>/pages/edit/<?= $elem['id'] ?>"
                       class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="POST" action="/<?= APP_BASE_PATH ?>/pages/delete/<?= $elem['id'] ?>"
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
    <div class="pagination-wrapper">
        <nav class="pagination justify-content-center">
            <ul class="pagination">
                <li class="page-item">
                    <?php
                    if ($page != 1): ?>
                        <a class="page-link" href="/<?= APP_BASE_PATH ?>/pages/index/<?= $page - 1 ?>"
                           aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    <?php endif; ?>
                </li>

                <?php
                for ($i = 0; $i < $all_pages; $i++): ?>
                    <li class="page-item"><a class="page-link"
                                             href="/<?= APP_BASE_PATH ?>/pages/index/<?= $i + 1 ?>"><?= $i + 1 ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item">
                    <?php
                    if ($page != $all_pages): ?>
                        <a class="page-link" href="/<?= APP_BASE_PATH ?>/pages/index/<?= $page + 1 ?>"
                           aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include "app/views/layout.php";


