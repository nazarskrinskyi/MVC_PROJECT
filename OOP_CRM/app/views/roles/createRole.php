<?php

$title = "CategoryModel Creation";
ob_start();
?>
    <h1 class="text-center">Create Role</h1>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/roles/store">
                <div class="mb-3">
                    <label for="roleName" class="form-label">RoleName</label>
                    <input placeholder="RoleName..." type="text" id="roleName" class="form-control" name="roleName"
                           required>
                </div>

                <div class="mb-3">
                    <label for="roleDesc" class="form-label">RoleDescription</label>
                    <input placeholder="RoleDescription..." type="text" id="roleDesc" class="form-control"
                           name="roleDescription" required>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Create</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";
