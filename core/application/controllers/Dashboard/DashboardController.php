<?php
//namespace camaleon\viewControllers;

use camaleon\mvc\ControllerBase;
use camaleon\helpers\StringSecurityManager;

//   M O D E L S
use camaleon\models\UserModel;
use camaleon\models\CategoriaModel;

//   S E S S I O N
use camaleon\helpers\SessionApp;

class DashboardController extends ControllerBase{

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


        // PRODUCTOS (Pendiente cargar)


        //*************************************************************** */
        // Render view
        $this->view->test = StringSecurityManager::encrypt("1234");
        $this->view->renderView($this, "index", "main");        
    }


    public function categorias($params = null) {
        $category = new CategoriaModel();
        $categoriesList = $category->getAll(); //->selectAllCategories();

        //header("Location: ". SINGLE_URL . "Dashboard/index");

        $this->view->categoriesList = $categoriesList;

        $this->view->renderView($this, "categorias", "Categorías");
    }

    // Save and Update
    // actions CRUD - Category
    public function saveCategory($params=null) {
        $response = null;
        if ($_POST) {
            $categoryName = $_POST["categoryname"];

            $category = new CategoriaModel();
            $category->nombres = $categoryName;
            $res = $category->create();
            if ($res) {
                $response = array('res'=>'success');
            } else {
                $response = array('res'=>'fail');
            }            
        }
        echo(json_encode($response));
    }

    // actions CRUD - Category
    public function editCategory($params=null) {
        $response = null;
        if ($_POST) {
            $categoryId = $_POST["id"];
            $categoryName = $_POST["categoryname"];

            $category = new CategoriaModel();
            $category->id = $categoryId;
            $category->nombres = $categoryName;
            $res = $category->update();

            if ($res) {
                $response = array('res'=>'success');
            } else {
                $response = array('res'=>'fail');
            }            
        }
        echo(json_encode($response));
    }

    // TODO: eliminar categoría
    public function deleteCategory($params=null) {
        $response = null;
        if ($_POST) {
            $categoryId = $_POST["id"];
            $category = new CategoriaModel();
            $category->id = $categoryId;
            $res = $category->logicDelete( $category->id );
            if ($res) {
                $response = array('res'=>'success');
            } else {
                $response = array('res'=>'fail');
            }            
        }
        echo(json_encode($response));
    }
}