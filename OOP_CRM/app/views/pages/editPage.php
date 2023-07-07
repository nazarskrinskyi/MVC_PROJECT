<?php

$title = "Edit Page";
ob_start();

?>
    <h1 class="text-center">Edit Page</h1>
    <div class="row justify-content-center mt-4">
        <?php if (isset($_SESSION['err_msg'])): ?>
            <div class="p-2 error_display mb-3">
                <i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i><strong style="font-size: x-large"><?= $_SESSION['err_msg']?></strong><i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i>
            </div>
        <?php endif; unset($_SESSION['err_msg'])?>
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/pages/update/<?= $page['id'] ?>">
                <div class="mb-3">
                    <label for="TitleName" class="form-label">Title</label>
                    <input placeholder="Title..." type="text" id="TitleName" class="form-control" name="title"
                           value="<?= $page['title'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input placeholder="Slug..." type="text" id="slug" class="form-control" name="slug"
                           value="<?= $page['slug'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-check-label">Role</label>
                    <?php

                    $selectedRoles = explode(',', $page['role']);
                    foreach ($roles as $key => $role):?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="roles" name="roles[]"
                                   value="<?= $role['id'] ?>"
                                <?php
                                foreach ($selectedRoles as $selectedRole):
                                    echo $role['id'] == $selectedRole ? 'checked' : '' ?>
                                <?php endforeach; ?>>
                            <label class="form-check-label" for="roles"><?= $role['role_name'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Edit</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";


