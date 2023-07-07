<?php

namespace OOP_CRM\app\models;

use OOP_CRM\app\models\pages\PageModel;

class Check
{
    private $userRole;

    public function __construct($userRole)
    {
        $this->userRole = $userRole;
    }

    public function getCurrentSlug(): string
    {
        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parseUrl = parse_url($url);
        $path = $parseUrl['path'];
        $pathWithoutBase = str_replace(APP_BASE_PATH, '',$path);
        $segments = explode('/',ltrim($pathWithoutBase,'/'));
        $firstTwoSegment = array_slice($segments,0,2);
        return implode('/',$firstTwoSegment);
    }

    public function checkPermission($slug): bool
    {
        // Получить информацию о странице по slug
        $pageModel = new PageModel();
        $page = $pageModel->getPageBySlug($slug);
        if (!$page) {
            return false;
        }
        // Получить разрешенные роли для страницы
        $allowedRoles = explode(',', $page['role']);
        // Проверить, имеет ли текущий пользователь доступ к странице
        if (isset($this->userRole) && in_array($this->userRole, $allowedRoles)) {
            return true;
        } else {
            return false;
        }
    }

    public function requirePermission(): void
    {
        $slug = $this->getCurrentSlug();

        if (!$this->checkPermission($slug)) {
            $path = '/' . APP_BASE_PATH;
            header("Location: $path");
            exit();
        }
    }

    public function isCurrentUserRole($role): bool
    {
        return $this->userRole == $role;
    }

}