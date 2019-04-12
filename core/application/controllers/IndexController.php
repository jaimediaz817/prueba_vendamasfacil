<?php
//namespace camaleon\viewControllers;

use camaleon\mvc\ControllerBase;
use camaleon\helpers\StringSecurityManager;

//   M O D E L S
use camaleon\models\UserModel;

//   S E S S I O N
use camaleon\helpers\SessionApp;

class IndexController extends ControllerBase{

    public function index($params=null) {
        // Parametros que llegan por get.
        \FB::log("params: ".$params);
        $ex = explode(",", $params);
        $arr = array();
        $cont=0;
        foreach($ex as $index => $va) {
            $cont++;
            array_push($arr, $va);
        }
        $cantidad =  count($arr);
        // Final - parametros GET.

        // Cargando usuarios
        $user = new UserModel();
        $usuarios = $user->getAll();


        // PRODUCTOS    

        //*************************************************************** */
        // Render view
        $this->view->test = StringSecurityManager::encrypt("1234");
        $this->view->renderView($this, "index", "main");
    }
}