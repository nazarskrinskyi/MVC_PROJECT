<?php

$title = "Edit CategoryModel";
ob_start();
?>
    <h1 class="text-center">Edit Role</h1>
    <div class="row justify-content-center mt-4">
        <?php if (isset($_SESSION['err_msg'])): ?>
            <div class="p-2 error_display mb-3">
                <i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i><strong style="font-size: x-large"><?= $_SESSION['err_msg']?></strong><i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i>
            </div>
        <?php endif; unset($_SESSION['err_msg'])?>
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/roles/update/<?= $_GET['id'] ?>">
                <div class="mb-3">
                    <label for="roleName" class="form-label">RoleName</label>
                    <input  type="text" id="roleName" autocomplete="on" class="form-control" name="roleName" value="<?= $role['role_name']?>"
                           required>
                </div>

                <div class="mb-3">
                    <label for="roleDesc" class="form-label">RoleDescription</label>
                    <textarea  type="text" id="roleDesc" class="form-control"
                               name="roleDescription" autocomplete="on" required><?= $role['role_description']?></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Edit</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";

