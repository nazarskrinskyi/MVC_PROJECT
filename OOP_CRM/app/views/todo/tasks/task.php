<?php

$title = "All Tasks";
ob_start();

?>
    <div class="mb-4 card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fa-solid fa-square-up-right"></i><strong><?= $task['title'] ?></strong>
            </h1>
        </div>
        <div class="card-body">
            <p class="row">
                <span class="col-12 col-md-6"><strong><i class="fa-solid fa-layer-group"></i>
                    Category:</strong> <?php echo htmlspecialchars($category['title'] ?? 'N/A'); ?>
                </span>
                <span class="col-12 col-md-6"><strong><i
                                class="fa-solid fa-battery-three-quarters"></i>Status:</strong> <?php echo htmlspecialchars($task['status']); ?>
                </span>
            </p>
            <p class="row">
                <span class="col-12 col-md-6"><strong><i
                                class="fa-solid fa-person-circle-question"></i> Priority:</strong> <?php echo htmlspecialchars($task['priority']); ?></span>
                <span class="col-12 col-md-6"><strong><i
                                class="fa-solid fa-hourglass-start"></i> Start Date:</strong> <?php echo htmlspecialchars($task['created_at']); ?></span>
            </p>
            <p class="row">
                <span class="col-12 col-md-6"><strong><i
                                class="fa-solid fa-person-circle-question"></i> Updated:</strong> <?php echo htmlspecialchars($task['updated_at']); ?></span>
                <span class="col-12 col-md-6"><strong><i
                                class="fa-solid fa-hourglass-start"></i> Due Date:</strong> <?php echo htmlspecialchars($task['finish_date']); ?></span>
            </p>
            <p>
                <strong><i class="fa-solid fa-battery-three-quarters"></i>
                    Tags:</strong>
                <?php
                foreach ($tags as $tag):
                    if ($task['id'] == $tag['task_id']):?>
                        <a href="/<?= APP_BASE_PATH ?>/todo/tasks/byTag/<?php echo $tag['tags_id']; ?>"
                           class="tag"><?= htmlspecialchars($tag['name']); ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </p>
            <p>
                <strong><i class="fa-solid fa-file-prescription"></i>
                    Description:</strong> <?php echo htmlspecialchars($task['description']); ?>
            </p>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/tasks/edit/<?php echo $tag['task_id']; ?>"
                   class="btn btn-primary me-2">Edit</a>
                <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/todo/tasks/delete/<?php echo $tag['task_id']; ?>"
                   class="btn btn-danger me-2">Delete</a>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";
