<?php

if ($_SERVER['REQUEST_URI'] == '/CRM_Telegram/index.php') {
    header('Location: /CRM_Telegram/');
    exit();
}
$title = "Home Page";
ob_start();
?>
    <h1 class=" text-center text-primary text-uppercase mb-3">Home Page</h1>

    <div id="calendar">
    </div>

<?php $path = "/" . filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) . "/todo/tasks/task/" ?>

    <script>
        const tasks = JSON.parse(`<?= $tasksJson ?>`);

        const events = tasks.map((task) => {
            return {
                title: task.title,
                start: new Date(task.created_at),
                end: new Date(task.finish_date),
                extendedProps: {
                    task_id: task.id
                },
            };
        });

        document.addEventListener("DOMContentLoaded", function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events,
                eventClick: function (info) {
                    const taskId = info.event.extendedProps.task_id;
                    window.location.href = "<?=$path?>" + taskId;
                }
            });
            calendar.render();
        });
    </script>


<?php $content = ob_get_clean();

include "app/views/layout.php";
