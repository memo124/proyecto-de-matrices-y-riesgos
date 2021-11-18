<?php

class Procesos extends Validator
{
    private $id = null;
    private $proceso_id = null;
    private $rol = null;
    private $procesoid = null;
    private $descripcion = null;
    
    public function setId($value)
    {
        if($this->validateId($value))
        {
            $this->id = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setProcesoId($value)
    {
        if($this->validateAlphanumeric($value , 1 , 10))
        {
            $this->procesoid = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setRol($value)
    {
        if($this->validateAlphanumeric($value , 1 , 10))
        {
            $this->rol = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setProcesoId2($value)
    {
        if( $this->validateAlphanumeric($value , 1 , 10) )
        {
            $this->proceso_id = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getProcesoId()
    {
        return $this->procesoid;
    }

    public function setDescripcion($value)
    {
        if  ( $this->validateAlphanumeric($value, 1, 50) )
        {
            $this->descripcion = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    //scrud 

    public function insertProceso()
    {
        $sql =  'INSERT INTO KT_PROCESOS(PROCESO_ID, DESCRIPCION) VALUES(?,?)';
        $param = array($this->procesoid, $this->descripcion);
        return Conexion:: executeRow($sql,$param);
    }

    public function readProceso()
    {
        $sql = 'SELECT * from KT_PROCESOS order by ROWID';
        $param = null;
        return Conexion::getRows($sql, $param);
    }

    public function readProceso2()
    {
        $sql = 'SELECT PROCESO_ID , DESCRIPCION from KT_PROCESOS order by PROCESO_ID ';
        $param = null;
        return Conexion::getRows($sql, $param);
    }

    public function deleteProceso()
    {
        $sql = 'DELETE from KT_PROCESOS where ROWID = ?';
        $param = array($this->id);
        return Conexion::executeRow($sql,$param);
    }

    public function updateProceso()
    {
        $sql = 'UPDATE KT_PROCESOS set PROCESO_ID = ?, DESCRIPCION = ? where rowid = ?';
        $param = array($this->procesoid, $this->descripcion,$this->id);
        return Conexion::executeRow($sql,$param);
    }

    public function getProceso()
    {
        $sql = 'SELECT * from KT_PROCESOS where rowid = ?';
        $param = array($this->id);
        return Conexion::getRow($sql, $param);
    }

    public function searchProceso($value)
    {
        $sql = 'SELECT * FROM KT_PROCESOS WHERE PROCESO_ID ILIKE ? OR DESCRIPCION ILIKE ? ORDER BY ROWID';
        $params = array("%$value%" , "%$value%");
        return Conexion::getRows($sql, $params);
    }

    public function getProceso2()
    {
        $sql = 'SELECT DESCRIPCION FROM KT_PROCESOS WHERE PROCESO_ID = ? ';
        $param = array($this->proceso_id);
        return Conexion::getRow($sql, $param);
    }

    /*Método que devuele los procesos pertenecientes a usuarios según el id del proceso
    (Datos del cliente y del pedido en general)*/
    public function darRoles($value)
    {
        $sql = 'SELECT DISTINCT(ROL) FROM KT_USUARIOSCROSS WHERE PROCESO_ID = ? ORDER BY ROL ;';
        $param = array("$value");
        return Conexion::getRows($sql, $param);
    }

    public function darUsuariosPorRol($value)
    {
        $sql = 'SELECT U.USER_ID as usuario FROM KT_USUARIOSCROSS U WHERE U.PROCESO_ID = ? AND ROL = ? ;';
        $params = array("$value", $this->rol);
        return Conexion::getRows($sql, $params);
    }

    public function darRoles2($value)
    {
        $sql = 'SELECT USER_ID , ROL FROM KT_USUARIOSCROSS WHERE PROCESO_ID = ? ORDER BY ROL ;';
        $param = array("$value");
        return Conexion::getRows($sql, $param);
    }

    /*Método que devuelve los usuarios de un proceso agrupados por el rol*/
    public function graficoUsuarios( $value )
    {
        $sql = 'SELECT COUNT(U.ROL)AS usuarios, U.ROL as rol , P.DESCRIPCION as descrip FROM KT_USUARIOSCROSS U 
                JOIN KT_PROCESOS P USING(PROCESO_ID)
                WHERE U.PROCESO_ID = ? GROUP BY P.DESCRIPCION, ROL;';
        $params = array("$value");
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve los correlativos de un proceso agrupados por el número*/
    public function graficoCorrelativos( $value )
    {
        $sql = 'SELECT COUNT(DISTINCT(C.CORRELATIVO_ID)) as cantidadcorrelativo, C.CORRELATIVO_ID,  C.ULTIMO_NUM_UTILIZADO, P.DESCRIPCION as descrip FROM KT_CORRELATIVOS C
                JOIN KT_PROCESOS P USING(PROCESO_ID) 
                WHERE C.PROCESO_ID = ? GROUP BY C.CORRELATIVO_ID , C.ULTIMO_NUM_UTILIZADO , P.DESCRIPCION;';
        $params = array("$value");
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve los indicadores de un proceso*/
    public function graficoIndicadores( $value )
    {
        $sql = 'SELECT COUNT(I.INDICADOR_ID) as cantidadindicadores , P.DESCRIPCION FROM KT_INDICADORES I
        JOIN KT_PROCESOS P USING(PROCESO_ID) WHERE I.PROCESO_ID = ? GROUP BY P.DESCRIPCION;';
        $params = array("$value");
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve las partes interesadas de un proceso*/
    public function graficoPI( $value )
    {
        $sql = 'SELECT COUNT(PI.PARTE_INTERESADA_ID) as cantidadparte , P.DESCRIPCION 
                FROM KT_PARTES_INTERESADAS PI
                JOIN KT_PROCESOS P USING(PROCESO_ID) WHERE PI.PROCESO_ID = ? GROUP BY P.DESCRIPCION;';
        $params = array("$value");
        return Conexion::getRows($sql, $params);
    }

}

?>