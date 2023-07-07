<?php

$title = "Category Creation";
ob_start();
?>
    <h1 class="text-center">Create Category</h1>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/category/store">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input  type="text" id="title" autocomplete="on" class="form-control" name="title"
                            placeholder="title..." required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea  type="text" id="description" class="form-control"
                               name="description" placeholder="description..." autocomplete="on"
                               required></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Create</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";
