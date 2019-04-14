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
        $product->precio = 0;
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

        $product = new ProductoModel();

        $product->id               = $_POST['idProduct'];
        $product->nombres          = $_POST['nombres'];
        $product->descripcion      = $_POST['descripcion'];
        $product->categoriaId      = $_POST['categoriaProducto'];
        $product->peso             = $_POST['peso'];
        $product->cantidad         = $_POST['cantidad'];
        $product->precio           = $_POST['precio'];
        $product->tipoPublicacion  = $_POST['tipoPublicacion'];    

        // Save Product            
        $res = $product->update();

        // Response
        echo(json_encode(array(
            "res"=> $res
        )));
    }

    public function deleteProductRequest($params = null) {
        $product = new ProductoModel();
        $id = $_POST['idProduct'];
        $res = $product->logicDelete($id);
        // Response
        echo(json_encode(array(
            "res"=> $res
        )));
    }

    // Publicar producto
    public function postProductListRequest($params = null) {
        $product = new ProductoModel();
        $id                = $_POST['idProducto'];
        $precioUsd         = $_POST['precioUsd'];
        $pesoProducto      = $_POST['pesoProducto'];
        $tipoPublicacion   = $_POST['tipoPublicacion'];
        $valorTrm          = $_POST['valorTrm'];
        $calc = 0;

        // calcular
        if ($tipoPublicacion == "01") {
            $calc = $this->calcularPublicacionBasica($precioUsd, $pesoProducto, $valorTrm);
        } else if ($tipoPublicacion == "02") {
            $calc = $this->calcularPublicacionPremium($precioUsd, $pesoProducto, $valorTrm);
        }        
        
        // Redondear al 900 más cercano
        $valorPublicacion = $this->redondearAl900MasCercano($calc);

        $res = $product->publicarProducto($id, $valorPublicacion);
        // Response
        echo(json_encode(array(
            "res"=> $res
        )));
    }

    // Pausar producto
    public function pauseProductListRequest($params = null) {
        $product = new ProductoModel();
        $id = $_POST['idProduct'];
        $res = $product->pausarPublicacionProducto($id);
        // Response
        echo(json_encode(array(
            "res"=> $res
        )));
    }

    // Actualizar precio de publicación


    // Fórmula #1
    function calcularPublicacionBasica($precioBase, $peso, $trm) {
        $comision = 0;
        $valorComision= 0;
        $comisionMercadoLibre = 0.16;
        $valorComisionML = 0;
        $formulaParte1 = 0;
        $formula = 0;

        if ($peso > 0 && $peso <= 10) {
            $comision = 0.15;
        }
        if ($peso > 10 && $peso <= 20) {
            $comision = 0.25;
        }
        if ($peso > 20 && $peso <= 30) {
            $comision = 0.35;
        }
        if ($peso > 40 && $peso <= 50) {
            $comision = 0.45;
        }
        if ($peso > 50 && $peso <= 60) {
            $comision = 0.55;
        }

        // comisión básica por peso sobre valor base:
        $valorComision = ($precioBase * $comision);
        $formulaParte1 = (($precioBase + ($peso * 10) + $valorComision) * $trm);
        $valorComisionML = $formulaParte1 * $comisionMercadoLibre;
        $formula = $formulaParte1 + $valorComisionML;

        return $formula;
    }

    // Fórmula #2
    function calcularPublicacionPremium($precioBase, $peso, $trm) {

        $comision = 0;
        $valorComision= 0;
        $comisionMercadoLibre = 0.14;
        $valorComisionML = 0;
        $formulaParte1 = 0;
        $formula = 0;

        if ($peso > 0 && $peso <= 10) {
            $comision = 0.1;
        }
        if ($peso > 10 && $peso <= 20) {
            $comision = 0.2;
        }
        if ($peso > 20 && $peso <= 30) {
            $comision = 0.3;
        }
        if ($peso > 40 && $peso <= 50) {
            $comision = 0.4;
        }
        if ($peso > 50 && $peso <= 60) {
            $comision = 0.5;
        }

        // comisión básica por peso sobre valor base:
        $valorComision = ($precioBase * $comision);
        $formulaParte1 = (($precioBase + ($peso * 10) + $valorComision) * $trm);
        $valorComisionML = $formulaParte1 * $comisionMercadoLibre;
        $formula = $formulaParte1 + $valorComisionML;

        return $formula;
    }

    public function redondearAl900MasCercano($valor) {
        $round1    = round($valor)/1000*1000;
        $valorBase = round($round1, -3);
        $valorRetorno = 0;

        if ($valor > $valorBase) {
            $valorRestante = ($valor - $valorBase);
        } else {
            $valorRestante = ($valorBase - $valor);
        }

        if($valorRestante < 400) {
            // restar 100 al valor base, redondear hacia abajo
            $valorRetorno = $valorBase - 100;
        }
        else if ($valorRestante >= 400) {
            // sumar 900 al valor base, redondear hacia arriba
            $valorRetorno = $valorBase + 900;
        }
        return $valorRetorno;
    }

    public function getPublicacionesPorDia($params = null) {
        $product = new ProductoModel();
        $publicacionesDia = $product->getPublicacionesDiarias();
        $flagArray = 0;

        if(!empty($publicacionesDia)) {
            $flagArray = 1;
        }

        print_r(json_encode(array(
            "data" => $flagArray,
            "res" => $publicacionesDia
        )));
    }

}