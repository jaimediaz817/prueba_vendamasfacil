<?php
//namespace camaleon\viewControllers;

use camaleon\mvc\ControllerBase;
use camaleon\helpers\StringSecurityManager;

//   M O D E L S
use camaleon\models\UserModel;
use camaleon\models\CategoriaModel;
use camaleon\models\ProductoModel;

//   S E S S I O N
use camaleon\helpers\SessionApp;

class ProductoController extends ControllerBase{

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


        // CATEGORIAS
        $categoriaModel = new CategoriaModel();
        $categoriaList = $categoriaModel->getAll();

        // PRODUCTOS
        $productoModel = new ProductoModel();
        $productoList = $productoModel->selectAllProducts();

        //*************************************************************** */
        // Render view
        $this->view->test = StringSecurityManager::encrypt("1234");
        $this->view->categoriaList = $categoriaList;
        $this->view->productoList = $productoList;
        $this->view->renderView($this, "productos", "main");
    }


    // Add
    public function addProductRequest($params=null) {

        $uploadStatus = 0;
        $textAction = "";
        $countProductInitial = 0;

        /* 
    private $id;
    private $nombres;
    private $descripcion;
    private $categoriaId;
    private $peso;
    private $cantidad;
    private $precio;
    private $tipoPublicacion;
    private $estado;
    private $fecha;
        */
        // Product instance
        $product = new ProductoModel();

        $product->nombres          = $_POST['nombres'];
        $product->descripcion      = $_POST['descripcion'];
        $product->categoriaId      = $_POST['categoriaProducto'];
        $product->peso             = $_POST['peso'];
        $product->cantidad         = $_POST['cantidad'];
        $product->precio           = $_POST['precio'];
        $product->tipoPublicacion  = $_POST['tipoPublicacion'];

        // Save Product                
        $res = $product->create();

        // Response
        echo(json_encode(array(
            "res"=> $res
        )));
    }

    // Edit Product 
    public function editProductRequest($params=null) {
        $textAction = "";
        $countProductInitial = 0;

        $product = new ProductModel();
        $product->id         = $_POST['idProduct'];
        $product->name       = $_POST['nameProd'];
        $product->category   = $_POST['categoryProd'];
        $product->price      = $_POST['priceProd'];
        $countProductInitial = $_POST['quantityProd'];

        // Save Product            
        $uploadStatus = 1;            
        $res = $product->update();
        if ($res) {
            $textAction = "success";
        } else {
            $textAction = "failEdit";
        }

        // Response
        echo(json_encode(array(
            "res"=> $textAction
        )));
    } 
}