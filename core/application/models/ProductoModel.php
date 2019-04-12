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
                    SELECT  pr.prod_id_pk, pr.prod_nombres, pr.prod_descripcion, pr.cate_id_fk, pr.prod_estado, pr.prod_peso, pr.prod_precio_usd, pr.prod_cantidad, pr.prod_estado,pr.prod_fecha_publicacion, pr.prod_tipo_publicacion, ca.cate_nombres as nombreCategoria
                    FROM productos pr INNER JOIN categorias_producto ca
                    ON ca.cate_id_pk = pr.cate_id_fk;
        ";

        $queryPdo = $this->pdo->prepare($query);
        $queryPdo->execute();

        //PDO::FETCH_ASSOC
        $response = $queryPdo->fetchAll(\PDO::FETCH_OBJ);
        return $response;
    }       

    // override
    public function create() {
        $stm = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (prod_nombres, prod_descripcion, cate_id_fk, prod_peso, prod_cantidad, prod_precio, prod_tipo_publicacion, prod_fecha_publicacion values(?,?,?,?,?,?,?, current_date())");
        $stm->execute(array( $this->nombres, $this->descripcion, $this->categoriaId, $this->peso, $this->cantidad, $this->precio, $this->tipoPublicacion ));
    }

    // Actualizar
    public function update($idEntity=null) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET prod_nombres=?, prod_descripcion=?, cate_id_fk=?, prod_peso=?, prod_cantidad=?, prod_precio=?, prod_tipo_publicacion=?, prod_estado=? WHERE prod_id_pk=?");
        $stm->execute(array( $this->nombres, $this->descripcion, $this->categoriaId, $this->peso, $this->cantidad, $this->precio, $this->tipoPublicacion, $this->estado, $this->id ));
    }

    public function logicDelete($idProd) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET prod_estado=? WHERE prod_id_pk=?");
        $stm->execute(array( $this->estado, $idProd ));
    }
}

?>