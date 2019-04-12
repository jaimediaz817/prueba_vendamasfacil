<?php

namespace camaleon\models;
use camaleon\system\database\CrudBase;

class UserModel extends CrudBase {
    private $id;
    private $username;
    private $password;

    const TABLE="usuarios";
    const ID="usua_id_pk";

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

    // custom
    public function innerJoin() {
        $perfName = "parlos";
        $query = "
                    SELECT us.usua_nombres, us.usua_apellidos, up.usua_perf_code
                    FROM usuario us INNER JOIN usua_perf up ON us.usua_id_pk = up.usua_id_fk
                    INNER JOIN perfil pe ON pe.perf_id_pk = up.perf_id_fk 
                    WHERE pe.perf_nombres = :perf_param
        ";
        $query2 = "SELECT * FROM usuario";
        $consulta = $this->pdo->prepare($query);
        $consulta->execute(array(':perf_param' => $perfName));
        //PDO::FETCH_ASSOC
        $res = $consulta->fetchAll(\PDO::FETCH_OBJ);
        return $res;
    }


    /**
     * Iniciar sesión
     */
    public function selectUserLogin($user='', $pass='') {
        $response = null;

        if ($user!= '' && $pass!='') {
            $query = "
                        SELECT * FROM usuarios us WHERE us.usua_login = :nickname
                        AND us.usua_password = :password
            ";
            $return = $this->pdo->prepare($query);
            $return->execute(array(':nickname' => $user, ':password'=> $pass));
            //PDO::FETCH_ASSOC
            $response = $return->fetchAll(\PDO::FETCH_ASSOC);
            return $response;
        }
    }

    // override
    public function create() {
        $stm = $this->pdo->prepare("INSERT INTO " .self::TABLE. " (usua_login, usua_password) values(?,?)");
        $stm->execute(array($this->username, $this->password));
    }

    // Actualizar
    public function update($idEntity=null) {
        $stm = $this->pdo->prepare("UPDATE " .self::TABLE. " SET usua_login=?, usua_password=? WHERE usua_id_pk=?");
        $stm->execute(array( $this->username, $this->password ));
    }
}

?>