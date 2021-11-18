<?php

class PartesIn extends Validator
{
    private $id = null;
    private $procesoid = null;
    private $proceso_id = null;
    private $partesid = null;
    private $descripcion = null;
    private $requisito = null;
    private $lastuser = null;
    
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
        if($this->validateId($value))
        {
            $this->procesoid = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setProceso($value)
    {
        if($this->validateAlphanumeric($value , 1 , 10))
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

    public function setPartesId($value)
    {
        if($this->validateAlphanumeric($value, 1 ,50))
        {
            $this->partesid = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getPartesId()
    {
        return $this->partesid;
    }

    public function setDescripcion($value)
    {
        if  ($this->validateAlphanumeric($value, 1 ,300))
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

    public function setRequisitos($value)
    {
        if  ($this->validateAlphanumeric($value, 1 ,250))
        {
            $this->requisito = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getRequisitos()
    {
        return $this->requisito;
    }

    public function setLastUser($value)
    {
        if($this->validateAlphanumeric($value, 1 ,128))
        {
            $this->lastuser = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getLastUser()
    {
        return $this->lastuser;
    }

    //scrud 

    public function insertPartesInteresadas()
    {
        $sql =  'INSERT INTO KT_PARTES_INTERESADAS(PROCESO_ID, PARTE_INTERESADA_ID, DESCRIPCION, REQUISITO_IDENTIFICADO, LAST_USER) VALUES(?,?,?,?,?)';
        $param = array($this->procesoid, $this->partesid, $this->descripcion, $this->requisito, $this->lastuser);
        return Conexion::executeRow($sql,$param);
    }

    public function readPartesInteresadas()
    {
        $sql = 'SELECT pi.ROWID, pi.PARTE_INTERESADA_ID, pr.DESCRIPCION , pi.DESCRIPCION as descrip , pi.REQUISITO_IDENTIFICADO, pi.LAST_USER 
                from KT_PARTES_INTERESADAS pi join KT_PROCESOS pr USING(PROCESO_ID) order by ROWID';
        $param = null;
        return Conexion::getRows($sql, $param);
    }

    public function deletePartesInteresadas()
    {
        $sql = 'DELETE from KT_PARTES_INTERESADAS where ROWID = ?';
        $param = array($this->id);
        return Conexion::executeRow($sql,$param);
    }

    public function updatePartesInteresadas()
    {
        $sql = 'UPDATE KT_PARTES_INTERESADAS set PROCESO_ID = ?, PARTE_INTERESADA_ID = ?, DESCRIPCION = ?, REQUISITO_IDENTIFICADO = ?, LAST_USER = ? where rowid = ?';
        $param = array($this->procesoid, $this->partesid, $this->descripcion, $this->requisito, $this->lastuser, $this->id);
        return Conexion::executeRow($sql,$param);
    }

    public function getPartesInteresadas()
    {
        $sql = 'SELECT ROWID, PROCESO_ID, PARTE_INTERESADA_ID, DESCRIPCION, REQUISITO_IDENTIFICADO, LAST_USER from KT_PARTES_INTERESADAS where rowid = ?';
        $param = array($this->id);
        return Conexion::getRow($sql, $param);
    }

    public function searchParteInteresada($value)
    {
        $sql = 'SELECT pi.ROWID, pi.PARTE_INTERESADA_ID, pr.DESCRIPCION , pi.DESCRIPCION as descrip , pi.REQUISITO_IDENTIFICADO, pi.LAST_USER 
        from KT_PARTES_INTERESADAS pi join KT_PROCESOS pr USING(PROCESO_ID) where pi.PARTE_INTERESADA_ID ILIKE ? OR pr.DESCRIPCION ILIKE ? OR pi.DESCRIPCION ILIKE ?
        OR pi.REQUISITO_IDENTIFICADO ILIKE ? OR pi.LAST_USER ILIKE ?
        order by ROWID';
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%");
        return Conexion::getRows($sql, $params);
    }

    public function getProcesoPI( $value )
    {
        $sql = 'SELECT proceso_id FROM KT_PROCESOS WHERE DESCRIPCION = ?';
        $param = array("$value");
        if ( $data = Conexion::getRow($sql, $param) ) {
            $this->procesoid = $data['proceso_id'];
            return true;
        } else {
            return false;
        }
    }

    /*Método que devuelve la descripción de un proceso según su id*/
    public function getProceso($value)
    {
        $sql = 'SELECT DESCRIPCION FROM KT_PROCESOS WHERE PROCESO_ID = ? ';
        $param = array("$value");
        return Conexion::getRow($sql, $param);
    }

    /*Método que devuelve los indicadores, según el id del proceso*/
    public function darPartesInteresadas($value)
    {
        $sql = 'SELECT PARTE_INTERESADA_ID , DESCRIPCION , REQUISITO_IDENTIFICADO FROM KT_PARTES_INTERESADAS WHERE PROCESO_ID = ?;';
        $param = array("$value");
        return Conexion::getRows($sql, $param);
    }

    public function readPartesInteresadasProcesos()
    {
        $sql = 'SELECT pi.ROWID, pi.PARTE_INTERESADA_ID, pi.REQUISITO_IDENTIFICADO, pi.LAST_USER 
        from KT_PARTES_INTERESADAS pi join KT_PROCESOS pr USING(PROCESO_ID) 
        where pi.rowid = ?
        GROUP BY pi.ROWID, pi.PARTE_INTERESADA_ID, pr.DESCRIPCION , pi.DESCRIPCION, pi.REQUISITO_IDENTIFICADO, pi.LAST_USER';
        $param = array($this->procesoid);
        return Conexion::getRows($sql, $param);
    }

}

?>