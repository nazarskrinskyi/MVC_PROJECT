<?php

$title = "Edit Task";
ob_start();
?>
    <h1 class="text-center">Edit Task</h1>
    <div class="row justify-content-center mt-4 container-fluid">
        <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/tasks/update/<?= $_GET['id'] ?>">
            <div class="row">
                <div class="mb-3 col">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" autocomplete="on" class="form-control" name="title"
                           placeholder="title..." value="<?= $task['title'] ?>" required>
                </div>

            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea type="text" id="description" class="form-control"
                          name="description" autocomplete="on" required><?= $task['description'] ?></textarea>
            </div>

            <div class="row">
                <div class="mb-3 col">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"<?php if ($task['category_id'] == $category['id']) echo " selected" ?>><?= $category['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3 col">
                    <label class="form-label" for="reminder">Reminder At</label>
                    <select id="reminder" class="form-select" name="reminder" required>
                        <option value="30_M">30 minutes</option>
                        <option value="1_H">1 hours</option>
                        <option value="3_H">3 hours</option>
                        <option value="6_H">6 hours</option>
                        <option value="12_H">12 hours</option>
                        <option value="1_D">1 days</option>
                        <option value="3_D">3 days</option>
                        <option value="7_D">7 days</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-select" id="priority" name="priority" required>
                        <option value="low"<?php if ($task['priority'] == 'low') echo " selected" ?>>low</option>
                        <option value="medium"<?php if ($task['priority'] == 'medium') echo " selected" ?>>medium
                        </option>
                        <option value="high"<?php if ($task['priority'] == 'high') echo " selected" ?>>high</option>
                        <option value="urgent"<?php if ($task['priority'] == 'urgent') echo " selected" ?>>urgent
                        </option>
                    </select>
                </div>
                <div class="mb-3 col">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="new"<?php if ($task['status'] == 'new') echo " selected" ?>>new</option>
                        <option value="in_progress"<?php if ($task['status'] == 'in_progress') echo " selected" ?>>in
                            progress
                        </option>
                        <option value="completed"<?php if ($task['status'] == 'completed') echo " selected" ?>>completed
                        </option>
                        <option value="on_hold"<?php if ($task['status'] == 'on_hold') echo " selected" ?>>on_hold
                        </option>
                        <option value="cancelled"<?php if ($task['status'] == 'cancelled') echo " selected" ?>>cancelled
                        </option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col">
                    <label for="tags" class="form-label">Tags</label>
                    <div class="tags-container form-control">
                        <?php
                        if ($tags):
                        $tagNames = array_map(function ($tag) {
                            return $tag['name'];
                        }, $tags);
                        foreach ($tagNames as $tagName) {
                            echo "<div class='tag'>
                            <span>$tagName</span><button type='button'>×</button>
                        </div>";
                        }
                        endif;
                        ?>
                        <input class="form-control" type="text" id="tag-input">
                    </div>
                    <input class="form-control" type="hidden" name="tags" id="hidden-tags"
                           value="<?php if (!empty($tagNames)): echo htmlspecialchars(implode(', ', $tagNames)); endif ?>">
                </div>

                <div class="mb-3 col">
                    <label for="date" class="form-label">Finish Date</label>
                    <input type="datetime-local" id="date" autocomplete="on" class="form-control" name="finish_date"
                           placeholder="date..." value="<?= $task['finish_date'] ?>" required>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class=" btn btn-primary mt-2 pe-4 ps-4 p-2">Edit</button>
            </div>
        </form>
    </div>

    <script type="text/javascript" src="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/app/js_scripts/TodoTags.js"></script>

<?php
$content = ob_get_clean();

include "app/views/layout.php";

