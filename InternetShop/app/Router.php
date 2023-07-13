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
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/auth\/(?P<action>[a-z]+)\/(?P<id>\d+)?$/' => ['controller' => 'auth\\AuthController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/?$/' => ['controller' => 'HomeController', 'action' => 'index'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/users(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'users\\UsersController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/roles(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'roles\\RoleController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/pages(\/(?P<action>[a-z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'pages\\PageController'],
            '/^\/' . preg_quote(APP_BASE_PATH, '/') . '\/(register|login|authenticate|logout)(\/(?P<action>[a-z]+))?$/' => ['controller' => 'users\\AuthController']
        ];
    }


    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $controller = null;
        $action = null;
        $params = null;

        foreach ($this->routes as $pattern => $route) {
            if (preg_match($pattern, $uri, $matches)) {
                $controller = "InternetShop\\app\\controllers\\" . $route['controller'];
                $action = $route['action'] ?? $matches['action'] ?? 'index';
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                break;
            }
        }
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