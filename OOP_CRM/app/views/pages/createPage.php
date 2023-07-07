<?php

$title = "Page Creation";
ob_start();
?>
    <h1 class="text-center">Create Page</h1>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/pages/store">
                <div class="mb-3">
                    <label for="TitleName" class="form-label">Title</label>
                    <input placeholder="Title..." type="text" id="TitleName" class="form-control" name="title"
                           required>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input placeholder="Slug..." type="text" id="slug" class="form-control"
                           name="slug" required>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-check-label">Role</label>
                    <?php foreach ($roles as $key => $role):?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="roles" name="roles[]" value="<?=$role['id']?>">
                            <label class="form-check-label" for="roles"><?=$role['role_name']?></label>
                        </div>
                    <?php endforeach;?>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Create</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";

