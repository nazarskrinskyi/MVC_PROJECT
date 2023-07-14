<?php


namespace InternetShop\app;

class Router
{
    /**
     * @params $routes - contains all urls of pages
     */
    /**
     * @params $routes - key -> (pattern) value ->
     * (controller path + ?additional action param action - (func to call))
     */
    private array $routes;

    public function __construct()
    {
        $this->routes = [
            "^\/" . preg_quote(APP_BASE_PATH, '/') . '\/?$/' => ['controller' => 'HomeController', 'action' => 'index'],
            "^\/" . preg_quote(APP_BASE_PATH, '/') . "\/users(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/" => ['controller' => 'users\\UsersController'],
            '^\/' . preg_quote(APP_BASE_PATH, '/') . '\/users/index(\/(?P<page>\d+))?$/' => ['controller' => 'users\\UsersController'],
            "^\/" . preg_quote(APP_BASE_PATH, '/') . '\/auth(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$' => ['controller' => 'auth\\AuthController'],
            '^\/' . preg_quote(APP_BASE_PATH, '/') . '\/roles(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'roles\\RoleController'],
            '^\/' . preg_quote(APP_BASE_PATH, '/') . '\/pages(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'pages\\PageController'],
            '^\/' . preg_quote(APP_BASE_PATH, '/') . '\/pages/index(\/(?P<page>\d+))?$/' => ['controller' => 'pages\\PageController'],
            '^\/' . preg_quote(APP_BASE_PATH, '/') . '\/(register|login|authenticate|logout)(\/(?P<action>[a-z]+))?$/' => ['controller' => 'auth\\AuthController'],
            '^\/' . preg_quote(APP_BASE_PATH, '/') . '\/todo\/category(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'todo\\category\\CategoryController'],
        ];
    }

    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        tte(preg_match("^\/test\.loc\/InternetShop\/auth(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$", $uri));
        $controller = null;
        $action = null;
        $params = null;

        tt($uri);
        foreach ($this->routes as $pattern => $route) {
            tt($pattern);
            tt(preg_match($pattern, $uri, $matches));
            if (preg_match($pattern, $uri, $matches)) {
                $controller = "InternetShop\\app\\controllers\\" . $route['controller'];
                $action = $route['action'] ?? $matches['action'] ?? 'index';
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                break;
            }
        }
        tte($controller);
        if (!$controller) {
            http_response_code(404);
            echo "Page not found!";
            return;
        }

        $controllerInstance = new $controller();
        if (!method_exists($controllerInstance, $action)) {
            http_response_code(404);
            echo "Action not found!";
            return;
        }

        call_user_func_array([$controllerInstance, $action], [$params]);
    }
}