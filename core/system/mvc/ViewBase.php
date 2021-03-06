<?php 

namespace camaleon\mvc;

//   S E S S I O N
use camaleon\helpers\SessionApp;

class ViewBase {
    public function renderView($controller,$view, $title, $methodValController = false) {

        if (!$methodValController) {
            $controlador = get_class($controller);
            $controlador = substr($controlador, 0, -10);
        } else {
            $controlador = $controller;
        }

        $path = "./views/" . $controlador . "/" . $view;

        if (file_exists($path. ".php")) {
            if ($title != '') {
                $this->title = $title;
            }

            // Session validate
            session_start();
            if (!isset($_SESSION['nickUser'])) {            
                $path = "./views/Index/index.php";
                include $path;
                //header("Location: ". SINGLE_URL . "Index/index");                
            } else {
            //     if ($controlador !== "Index" && $view !== "index") {
            //         include $path . ".php";
            //     } else if ($controlador == "Dashboard" && $view == "index") {
            //         header("Location: ". SINGLE_URL . "Dashboard/index");
            //     }
                include $path . ".php";
            }
            

        } else if (file_exists($path . ".html")) {
            if ($title !== '') {
                $this->title = $title;
                include ".views/modules/header.php";
            }            
            include $path . ".html";
        } else {
            // 404 Page Not found
            echo "Error al intentar cargar la página";
        }
    }
}