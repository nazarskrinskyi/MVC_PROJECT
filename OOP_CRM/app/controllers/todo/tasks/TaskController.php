<?php

namespace OOP_CRM\app\controllers\todo\tasks;

use DateInterval;
use DateTime;
use Exception;
use OOP_CRM\app\models\Check;
use OOP_CRM\app\models\todo\category\CategoryModel;
use OOP_CRM\app\models\todo\tasks\TagModel;
use OOP_CRM\app\models\todo\tasks\TaskModel;

class TaskController
{
    private $check;
    private $tagsModel;

    private $userId;

    public function __construct()
    {
        $userRole = $_SESSION['user_role'] ?? null;
        $this->userId = $_SESSION['user_id'] ?? null;
        $this->check = new Check($userRole);
        $this->tagsModel = new TagModel();
    }

    public function index(): void
    {
        $this->check->requirePermission();
        $taskModel = new TaskModel();
        $tasks = $taskModel->getAllTasks();
        foreach ($tasks as $task) {
            $allTaskId[] = $task['id'];
        }
        $categoryModel = new CategoryModel();

        if (!is_null($task['category_id'])) {
            $category = $categoryModel->getCategoryById($task['category_id']);
        }
        else {
            http_response_code(404);
            include 'app/views/errors/404.php';
            return;
        }
        foreach ($allTaskId as $key => $id) {
            $tags[$key] = $this->tagsModel->getTagsByTask($id);
        }
        $deleteUrl =  "/" . filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL)  . "/todo/tasks/delete/";
        include_once "app/views/todo/tasks/index.php";
    }

    public function byTag(): void
    {
        $this->check->requirePermission();
        $taskModel = new TaskModel();
        $tasks = $taskModel->getTasksByTagId($_GET['id'], $this->userId);
        foreach ($tasks as $task) {
            $allTaskId[] = $task['task_id'];
        }
        $tagName = $this->tagsModel->getTagNameById($_GET['id'], $this->userId);
        if (!$tagName){
            http_response_code(404);
            include 'app/views/errors/404.php';
            return;
        }

        $categoryModel = new CategoryModel();
        foreach ($tasks as $task) {
            $tags = $this->tagsModel->getTagsByTask($task['id']);
            $category = $categoryModel->getCategoryById($task['category_id']);
        }
        foreach ($allTaskId as $key => $id) {
            $tags[$key] = $this->tagsModel->getTagsByTask($id);
        }
        include_once "app/views/todo/tasks/pageByTag.php";
    }

    public function completed(): void
    {
        $this->check->requirePermission();
        $taskModel = new TaskModel();
        $tasks = $taskModel->getAllCompletedTasks();
        foreach ($tasks as $task) {
            $allTaskId[] = $task['id'];
        }
        $categoryModel = new CategoryModel();

        if (!is_null($task['category_id'])) {
            $category = $categoryModel->getCategoryById($task['category_id']);
        }
        else {
            http_response_code(404);
            include 'app/views/errors/404.php';
            return;
        }
        $tagModel = new TagModel();
        foreach ($allTaskId as $id) {
            $tags[] = $tagModel->getTagsByTask($id);
        }
        $deleteUrl = "/" . filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL)  . "/todo/tasks/completed/delete/";
        include_once "app/views/todo/tasks/index.php";
    }

    public function expired(): void
    {
        $this->check->requirePermission();
        $taskModel = new TaskModel();
        $tasks = $taskModel->getAllExpiredTasks();
        foreach ($tasks as $task) {
            $allTaskId[] = $task['id'];
        }
        $categoryModel = new CategoryModel();

        if (!is_null($task['category_id'])) {
            $category = $categoryModel->getCategoryById($task['category_id']);
        }
        else {
            http_response_code(404);
            include 'app/views/errors/404.php';
            return;
        }
        $tagModel = new TagModel();
        foreach ($allTaskId as $id) {
            $tags[] = $tagModel->getTagsByTask($id);
        }
        $deleteUrl =  "/" . filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL)  . "/todo/tasks/expired/delete/";
        include_once "app/views/todo/tasks/index.php";
    }

    public function create(): void
    {
        $this->check->requirePermission();
        $todoCategories = new CategoryModel();
        $categories = $todoCategories->getAllActiveCategories();
        include_once "app/views/todo/tasks/createTask.php";
    }

    public function updateStatus(): void
    {
        $this->check->requirePermission();
        $datetime = null;
        $status = trim(htmlspecialchars($_POST['status']));
        $taskModel = new TaskModel();

        if ($status === 'completed') {
            $datetime = date('Y-m-d H:i:s');

            $taskModel->updateTaskStatus($_GET['id'], $status, $datetime);
        }
    }

    public function store(): void
    {
        if (isset($_POST['title']) && isset($_POST['finish_date']) && isset($_POST['category_id'])) {
            $data['title'] = trim(htmlspecialchars($_POST['title']));
            $data['finish_date'] = trim(htmlspecialchars($_POST['finish_date']));
            $data['category_id'] = trim(htmlspecialchars($_POST['category_id']));
            $data['user_id'] = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT) ?? 0;
            $data['status'] = 'new';
            $data['priority'] = trim(htmlspecialchars($_POST['priority']));
            $data['description'] = trim(htmlspecialchars($_POST['description']));
            $taskModel = new TaskModel();
            $taskModel->createTask($data);
            header("Location: /" . APP_BASE_PATH . "/todo/tasks");
        }
    }

    public function delete(): void
    {
        $this->check->requirePermission();
        $taskModel = new TaskModel();
        $allId = $taskModel->readAllId();
        foreach ($allId as $id){
            if (in_array($_GET['id'],$id)){
                $taskModel->deleteTask($_GET['id']);
                header("Location: /" . APP_BASE_PATH . "/todo/tasks");
                die();
            }
        }
        http_response_code(404);
        include 'app/views/errors/404.php';
    }

    public function edit(): void
    {
        $this->check->requirePermission();
        $taskModel = new TaskModel();
        $task = $taskModel->getTaskById($_GET['id']);
        if (!$task){
            http_response_code(404);
            include 'app/views/errors/404.php';
            return;
        }

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllActiveCategories();
        $tags = $this->tagsModel->getTagsByTask($_GET['id']);

        include_once "app/views/todo/tasks/editTask.php";
    }

    public function task(): void
    {
        $this->check->requirePermission();
        $taskModel = new TaskModel();
        $task = $taskModel->getTaskByIdAndUserId($_GET['id'], $this->userId);
        if (!$task){
            $_SESSION['err_msg'] = " There no such task in calendar! ";
            header("Location: /" . APP_BASE_PATH );
            die();
        }
        $categoryModel = new CategoryModel();
        $category = $categoryModel->getCategoryById($task['category_id']);
        $tags = $this->tagsModel->getTagsByTask($_GET['id']);

        include_once "app/views/todo/tasks/task.php";
    }

    /**
     * @throws Exception
     */
    public function update(): void
    {

        $data['title'] = trim(htmlspecialchars($_POST['title']));
        $data['finish_date'] = trim(htmlspecialchars($_POST['finish_date']));
        $data['category_id'] = trim(htmlspecialchars($_POST['category_id']));
        $data['status'] = trim(htmlspecialchars($_POST['status']));
        $data['priority'] = trim(htmlspecialchars($_POST['priority']));
        $data['reminder'] = trim(htmlspecialchars($_POST['reminder']));
        $data['tags'] = trim($_POST['tags']) ?? false;
        $data['description'] = trim(htmlspecialchars($_POST['description']));
        $data['user_id'] = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT) ?? 0;

        $finish_date = new DateTime($data['finish_date']);
        $remindElems = explode('_', $data['reminder']);
        $time = $remindElems[0];
        $timeType = $remindElems[1];
        $interval = new DateInterval("PT$time$timeType");
        $remind_at = $finish_date->sub($interval);
        $data['reminder'] = $remind_at->format('Y-m-d\TH:i');
        $taskModel = new TaskModel();
        $taskModel->updateTask($data, $_GET['id']);


        $tags = explode(',', $data['tags']);
        $tags = array_map('trim', $tags);
        $oldTags = $this->tagsModel->getTagsByTask($_GET['id']);
        $this->tagsModel->removeAllTaskTags($_GET['id']);

        foreach ($tags as $tag_name) {
            $tag = $this->tagsModel->getTagByNameAndUser($tag_name, $data['user_id']);
            $tag_id = $tag['id'];

            if (!$tag_id) {
                $tag_id = $this->tagsModel->addTag($tag_name, $data['user_id']);
            }
            $this->tagsModel->addTaskTag($_GET['id'], $tag_id);

        }

        foreach ($oldTags as $oldTag) {
            $this->tagsModel->removeUnusedTags($oldTag['id']);
        }
        $this->updateStatus();

        header("Location: /" . APP_BASE_PATH . "/todo/tasks");
    }

}