<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/21/2017
 * Time: 12:26 PM
 */

namespace framework\core;


class Request {
    private $url;
    private $segments = array();
    private $controller, $method;
    private $params = array();

    /**
     * Get requested page and explode it to segments.
     *
     */
    public function __construct() {
        // Each module will have a client with the same name as module, for example the blog module with have a BlogClient.
        // This helps improve security since anyone can simply try to guess combinations in the browser bar.
        // This way there is a default client for each module with the publicly available methods.

        // Grab the server request string
        if (!empty($_SERVER["REQUEST_URI"])) {
            $this->url = $_SERVER["REQUEST_URI"];
        }
        $this->segments = explode('/', $this->url);
        array_shift($this->segments);
        array_shift($this->segments);


        // Set controller
        if (!empty($this->segments[0])) {
            $this->controller = "\\modules\\" . $this->segments[0] . "\\" . ucfirst($this->segments[0]) . "Controller";
        } else {
            $this->controller = "PublicController";
        }

        // Set method
        if (!empty($this->segments[1])) {
            $this->method = $this->segments[1];
        } else {
            $this->method = "default";
        }

        // Set params
        $x = 0;
        if (!empty($this->segments[2])) {
            $arr = array_slice($this->segments, 2);
            foreach ($arr as $value) {
                $this->params[$x] = $value;
                $x++;
            }
        } else {
            $this->params = "";
        }

        // Dispatch the request
        $this->dispatch();

    }

    /**
     *  Take segments and call the appropriate controller
     *
     */
    public function dispatch() {


        $controller = $this->controller;
        $method = $this->method;
        $params = $this->params;


        $worker = new $controller();
        $worker->$method($params);

        unset($_SERVER['REQUEST_URI']);
        unset($this->url);

    }
}