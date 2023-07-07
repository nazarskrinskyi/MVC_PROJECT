<?php

namespace OOP_CRM\app\controllers;

use OOP_CRM\app\models\todo\tasks\TaskModel;

class HomeController
{
    private TaskModel $taskModel;
    private int $userId;
    public function __construct()
    {
        $this->taskModel = new TaskModel();
        $this->userId = $_SESSION['user_id'] ?? 0;
    }

    public function index(): void
    {
        $tasks = $this->taskModel->getAllTasks();
        $tasksJson = json_encode($tasks);
        include_once "app/views/index.php";
    }

}