<?php

namespace camaleon\models;
use camaleon\system\database\CrudBase;

class ProductoModel extends CrudBase {
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

    const TABLE="productos";
    const ID="prod_id_pk";

    private $pdo;

    public function __construct() {
        parent::__construct(self::TABLE, self::ID);
        $this->pdo=parent::connect();
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->name;
    }

    // TODO: seleccionar todos los productos con categorías
    public function selectAllProducts() {
        $query = "
                    SELECT  pr.prod_id_pk, pr.prod_nombres, pr.prod_descripcion, pr.cate_id_fk, pr.prod_estado, pr.prod_peso, pr.prod_precio_usd, pr.prod_cantidad, pr.prod_estado,pr.prod_fecha_publicacion, pr.prod_tipo_publicacion, pr.prod_estado_publicacion, pr.prod_precio_publicacion, ca.cate_nombres as nombreCategoria
                    FROM productos pr INNER JOIN categorias_producto ca
                    ON ca.cate_id_pk = pr.cate_id_fk;
        ";

        $queryPdo = $this->pdo->prepare($query);
        $queryPdo->execute();

        //PDO::FETCH_ASSOC
        $response = $queryPdo->fetchAll(\PDO::FETCH_OBJ);
        $queryPdo->closeCursor();
        $queryPdo = null;        
        return $response;
    }

    // pUBLICACIONES POR DIA
    public function getPublicacionesDiarias() {
        $query = "
                    SELECT 
                    CASE
                        WHEN weekday(prod_fecha_publicacion) = 0 THEN 'LUNES'
                        WHEN weekday(prod_fecha_publicacion) = 1 THEN 'MARTES'
                        WHEN weekday(prod_fecha_publicacion) = 2 THEN 'MIERCOLES'
                        WHEN weekday(prod_fecha_publicacion) = 3 THEN 'JUEVES'
                        WHEN weekday(prod_fecha_publicacion) = 4 THEN 'VIERNES'
                        WHEN weekday(prod_fecha_publicacion) = 5 THEN 'SABADO'
                        WHEN weekday(prod_fecha_publicacion) = 6 THEN 'DOMINGO'
                    END AS dia,
                    COUNT(prod_id_pk) AS totalPublicaciones
                    FROM productos
                    GROUP BY weekday(prod_fecha_publicacion)
                    ORDER BY weekday(prod_fecha_publicacion)  
        ";

        $queryPdo = $this->pdo->prepare($query);
        $queryPdo->execute();

        //PDO::FETCH_ASSOC
        $response = $queryPdo->fetchAll(\PDO::FETCH_OBJ);
        $queryPdo->closeCursor();
        $queryPdo = null;        
        return $response;        
    }

    // override
    public function create() {
        $stm = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (prod_nombres, prod_descripcion, cate_id_fk, prod_peso, prod_cantidad, prod_precio_usd, prod_tipo_publicacion, prod_fecha_publicacion) values(?,?,?,?,?,?,?, DATE(NOW()))");
        $res = $stm->execute(array( $this->nombres, $this->descripcion, $this->categoriaId, $this->peso, $this->cantidad, $this->precio, $this->tipoPublicacion ));
        $stm->closeCursor();
        $stm = null;
        return $res;
    }

    // Actualizar
    public function update($idEntity=null) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET prod_nombres=?, prod_descripcion=?, cate_id_fk=?, prod_peso=?, prod_cantidad=?, prod_precio_usd=?, prod_tipo_publicacion=? WHERE prod_id_pk=?");
        $res = $stm->execute(array( $this->nombres, $this->descripcion, $this->categoriaId, $this->peso, $this->cantidad, $this->precio, $this->tipoPublicacion, $this->id ));
        return $res;
    }

    // eliminado lógico 
    public function logicDelete($idProd) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET prod_estado = 0 WHERE prod_id_pk=?");
        $res = $stm->execute(array( $idProd ));
        return $res;
    }

    // publicar
    public function publicarProducto($idProd, $nuevoValor) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET prod_estado_publicacion = 1, prod_precio_publicacion=? WHERE prod_id_pk=?");
        $res = $stm->execute(array( $nuevoValor, $idProd ));
        $stm->closeCursor();
        $stm = null;
        return $res;
    }

    // pausar publicación
    public function pausarPublicacionProducto($idProd) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET prod_estado_publicacion = 0 WHERE prod_id_pk=?");
        $res = $stm->execute(array( $idProd ));
        $stm->closeCursor();
        $stm = null;
        return $res;
    }
}

?>