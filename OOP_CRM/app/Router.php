<?php
namespace OOP_CRM\app;

class Router
{
    private array $routes;
    public function __construct()
    {
        $this->routes = [
            "/^\/" . preg_quote(APP_BASE_PATH, '/') . '\/?$/'   => ['controller' => 'HomeController', 'action' => 'index'],
            "/^\/" . preg_quote(APP_BASE_PATH, '/') . "\/users(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/" => ['controller' => 'users\\UsersController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/users/index(\/(?P<page>\d+))?$/' => ['controller' => 'users\\UsersController'],
            "/^\/" . preg_quote(APP_BASE_PATH, '/') . '\/auth(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/'  => ['controller' => 'auth\\AuthController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/roles(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'roles\\RoleController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/pages(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'pages\\PageController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/pages/index(\/(?P<page>\d+))?$/' => ['controller' => 'pages\\PageController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/(register|login|authenticate|logout)(\/(?P<action>[a-z]+))?$/' => ['controller' => 'auth\\AuthController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/todo\/category(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'todo\\category\\CategoryController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/todo\/tasks(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'todo\\tasks\\TaskController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/todo\/tasks\/byTag(\/(?P<id>\d+))?$/' => ['controller' => 'todo\\tasks\\TaskController', 'action' => 'byTag'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/todo\/tasks\/task(\/(?P<id>\d+))?$/' => ['controller' => 'todo\\tasks\\TaskController', 'action' => 'task'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/todo\/tasks\/completed(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'todo\\tasks\\TaskController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/todo\/tasks\/expired(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'todo\\tasks\\TaskController']
        ];
    }
    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $controller = null;
        $action = null;
        $params = null;

        foreach ($this->routes as $pattern => $route)
        {
            if (preg_match($pattern, $uri, $matches)){
                $controller = 'OOP_CRM\\app\\controllers\\' . $route['controller'];
                $action = $route['action'] ?? $matches['action'] ?? 'index';
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $_GET['id'] = $matches['id'];
                $_GET['page'] = $matches['id'];
                break;
            }
        }
        if (!$controller){
            http_response_code(404);
            include "views/errors/404.php";
            die();
        }
        $controllerInstallation = new $controller();
        if (!method_exists($controllerInstallation,$action)){
            http_response_code(404);
            include "views/errors/404.php";
            die();
        }
        call_user_func_array([$controllerInstallation, $action], [$params]);
    }
}