<?php

class Usuariocross extends Validator
{
    private $rowid = null;
    private $user_id = null;
    private $proceso_id = null;
    private $rol = null;
    
    public function setId($value)
    {
        if($this->validateId($value))
        {
            $this->rowid = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setUser($value)
    {
        if($this->validateAlphanumeric($value, 1, 128))
        {
            $this->user_id = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public function setProceso( $value )
    {
        if ($this->validateId($value))
        {
            $this->proceso_id = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getProceso()
    {
        return $this->proceso_id;
    }

    public function setRol($value)
    {
        if($this->validateAlphanumeric($value, 1 ,10))
        {
            $this->rol = $value;
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function getRol()
    {
        return $this->rol;
    }

    //scrud 

    public  function insertUser()
    {
        $sql =  'INSERT INTO KT_USUARIOSCROSS( USER_ID , PROCESO_ID , ROL ) VALUES(?,?,?)';
        $param = array($this->user_id, $this->proceso_id, $this->rol);
        return Conexion::executeRow($sql,$param);
    }

    public function readUser()
    {
        $sql = 'SELECT U.ROWID, U.USER_ID, P.DESCRIPCION, U.ROL FROM KT_USUARIOSCROSS U
                JOIN KT_PROCESOS P USING( PROCESO_ID ) ORDER BY U.ROWID;';
        $param = null;
        return Conexion::getRows($sql, $param);
    }

    public function deleteUser()
    {
        $sql = 'DELETE from KT_USUARIOSCROSS where ROWID = ?';
        $param = array($this->rowid);
        return Conexion::executeRow($sql,$param);
    }

    public function updateUser()
    {
        $sql = 'UPDATE KT_USUARIOSCROSS set USER_ID = ?, PROCESO_ID = ?, ROL = ? where ROWID = ?';
        $param = array($this->user_id, $this->proceso_id, $this->rol, $this->rowid);
        return Conexion::executeRow($sql,$param);
    }

    public function getUsercross()
    {
        $sql = 'SELECT rowid , user_id , PROCESO_ID, ROL from KT_USUARIOSCROSS where ROWID = ?';
        $param = array($this->rowid);
        return Conexion::getRow($sql, $param);
    }

    /*Se crea el método que sirve para buscar datos de la tabla KT_USERSAPP*/    
    public function searchUserCross($value)
    {
        $sql = 'SELECT U.ROWID, U.USER_ID, P.DESCRIPCION, U.ROL FROM KT_USUARIOSCROSS U
                JOIN KT_PROCESOS P USING( PROCESO_ID ) 
                WHERE U.USER_ID ILIKE ? OR P.DESCRIPCION ILIKE ? ORDER BY U.ROWID;';
        $params = array("%$value%","%$value%");
        return Conexion::getRows($sql, $params);
    }

    public function getProcesoUC( $value )
    {
        $sql = 'SELECT proceso_id FROM KT_PROCESOS WHERE DESCRIPCION = ?';
        $param = array("$value");
        if ( $data = Conexion::getRow($sql, $param) ) {
            $this->proceso_id = $data['proceso_id'];
            return true;
        } else {
            return false;
        }
    }

    public function readUserRol()
    {
        $sql = 'SELECT U.ROWID, U.USER_ID, P.DESCRIPCION, U.ROL FROM KT_USUARIOSCROSS U
        JOIN KT_PROCESOS P USING( PROCESO_ID ) 
        where rol = ?
        GROUP BY U.ROWID, U.USER_ID, P.DESCRIPCION, U.ROL;';
        $param = array($this->rol);
        return Conexion::getRows($sql, $param);
    }
    //funciones para los graficos
    public function cantidadUsuariosRol()
    {
        $sql = 'SELECT COUNT(user_id)cantidad , rol from kt_usuarioscross group by rol';
        $params = null;
        return Conexion::getRows($sql, $params);
    }

}
?>