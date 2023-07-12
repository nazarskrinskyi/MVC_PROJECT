<?php


namespace InternetShop\www;

class Router
{
    /**
     * @params $routes - contains all urls of pages
     */
    private array $routes;

    public function __construct()
    {
        /**
         * @params $routes - key -> (pattern) value ->
         * (controller path + ?additional action param action - (func to call))
         */
        $this->routes = [
            "/\/" . preg_quote(APP_BASE_PATH, '/') . '\/www/'   => ['controller' => 'HomeController'],
        ];
    }

    public function run(): void
    {
        /**
         * @params default value
         */
        $uri = $_SERVER['REQUEST_URI'];
        $controller = null;
        $action = null;
        $params = null;


        /**
         * @loop trying to find suitable pattern
         * for url in variable $uri, in foreach catching
         * namespace prefix + controllerNameClass and finding action
         * and additional num-params as id...
         */
        foreach ($this->routes as $pattern => $route){
            if (preg_match($pattern, $uri, $matches)) {
                $controller = "InternetShop\\app\\controllers\\" . $route['controller'];
                $action = $route['action'] ?? $matches['action'] ?? 'index';
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $_GET['id'] = $matches['id'] ?? null;
                $_GET['page'] = $matches['id'] ?? null;
                break;
            }
        }

        /**
         * Unknown page error handle
         */
        if (!$controller){
            http_response_code(404);
            include "../app/views/errors/404.php";
            die();
        }
        $controllerInstallation = new $controller();
        if (!method_exists($controllerInstallation,$action)){
            http_response_code(404);
            include "../app/views/errors/404.php";
            die();
        }

        /**
         * calling function in class with ?optional params
         */
        call_user_func_array([$controllerInstallation, $action], [$params]);
    }
}