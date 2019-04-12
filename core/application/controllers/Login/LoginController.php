<?php
//namespace camaleon\viewControllers;

use camaleon\mvc\ControllerBase;

// U T I L I T I E S
use camaleon\helpers\StringSecurityManager;

//   M O D E L S
use camaleon\models\UserModel;

//   S E S S I O N
use camaleon\helpers\SessionApp;

class LoginController extends ControllerBase{

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
        $this->view->test = 817;
        $this->view->renderView($this, "index", "main");
    }

    // TODO: inciar sesión
    public function signInLogin($params = null) {
        $nickname = '';
        $password = '';
        $statusAccount = null;
        $userId = null;

        if ($_POST) {
            $nickname = $_POST['login'];
            $password = StringSecurityManager::encrypt($_POST['password']);

            $user = new UserModel();
            $loginData = $user->selectUserLogin($nickname, $password);

            if(!empty($loginData)) {
                $statusAccount =  $loginData[0]["usua_estado"];

                // S E S S I O N
                SessionApp::initStartFullSessionVar("idUser", $loginData[0]["usua_id_pk"]);
                SessionApp::initStartFullSessionVar("nickUser", $loginData[0]["usua_login"]);

                $userId = $loginData[0]["usua_id_pk"];
            } else {
                $userId = 0;
                $statusAccount = 0;
            }
        }        

        print_r(json_encode(["res" => "success", "statusLogin" => $userId]));
    }

    public function signOutLogin($params = null) {
        // S E S S I O N
        SessionApp::unsetVarSession("idUser");
        SessionApp::unsetVarSession("nickUser");
        SessionApp::destroyAllSession();
        // Redirect
        header("Location: ". SINGLE_URL . "Index/index");        
    }
}