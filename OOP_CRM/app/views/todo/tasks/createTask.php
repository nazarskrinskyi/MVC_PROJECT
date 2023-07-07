<?php
$title = "Task Creation";
ob_start();
?>

    <h1 class="text-center">Create Task</h1>
    <div class="row justify-content-center mt-4">
        <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/tasks/store">
            <div class="row">
                <div class="mb-3 col">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" autocomplete="on" class="form-control" name="title"
                           placeholder="title..." required>
                </div>

                <div class="mb-3 col">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" id="category" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col ">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-control" id="priority" name="priority" required>
                        <option value="low">low</option>
                        <option value="medium">medium</option>
                        <option value="high">high</option>
                        <option value="urgent">urgent</option>
                    </select>
                </div>

                <div class="mb-3 col">
                    <label for="finish_date" class="form-label">Finish Date</label>
                    <input type="text" class="form-control" id="finish_date" name="finish_date" placeholder="Select date and hour">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea type="text" id="description" class="form-control"
                          name="description" autocomplete="on" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
    <script type="text/javascript" src="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/app/js_scripts/DateRefactoring.js"></script>

<?php
$content = ob_get_clean();

include "app/views/layout.php";
