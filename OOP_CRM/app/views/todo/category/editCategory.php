<?php

$title = "Edit Category";
ob_start();
?>
    <h1 class="text-center">Edit Category</h1>
    <div class="row justify-content-center mt-4">
        <?php if (isset($_SESSION['err_msg'])): ?>
            <div class="p-2 error_display mb-3">
                <i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i><strong style="font-size: x-large"><?= $_SESSION['err_msg']?></strong><i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i>
            </div>
        <?php endif; unset($_SESSION['err_msg'])?>
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/category/update/<?= $_GET['id'] ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Category Title</label>
                    <input type="text" id="title" autocomplete="on" class="form-control" name="title"
                           value="<?= $category['title'] ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Category Description</label>
                    <textarea type="text" id="description" class="form-control"
                              name="description" autocomplete="on" required><?= $category['description'] ?></textarea>
                </div>

                <div class="mb-3">
                    <input type="checkbox" id="usability" class="form-check-input"
                           name="usability"  autocomplete="on" value="1" <?= $category['usability'] == 1 ? 'checked' : ''?>>
                    <label for="usability" class="form-check-label">Usability</label>

                </div>

                <button type="submit" class="btn btn-primary mt-2">Edit</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";

