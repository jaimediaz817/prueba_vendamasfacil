<?php

namespace camaleon\models;
use camaleon\system\database\CrudBase;

class CategoriaModel extends CrudBase {
    private $id;
    private $nombres;
    private $estado;

    const TABLE="categorias_producto";
    const ID="cate_id_pk";

    private $pdo;

    public function __construct() {
        parent::__construct(self::TABLE, self::ID);
        $this->pdo=parent::connect();
    }

    public function __set($nonbres, $value) {
        $this->nombres = $value;
    }

    public function __get($nombres) {
        return $this->nombres;
    }

    // override
    public function create() {
        $stm = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (cate_nombres) values(?)");
        $res = $stm->execute(array($this->nombres));
        return $res;
    }

    // Actualizar
    public function update($idEntity=null) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET cate_nombres=? WHERE cate_id_pk=?");
        $res = $stm->execute(array( $this->nombres, $this->id ));
        return $res;
    }

    public function logicDelete($idCate) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET cate_estado = 0 WHERE cate_id_pk=?");
        $res = $stm->execute(array( $idCate ));
        return $res;
    }
}

?>