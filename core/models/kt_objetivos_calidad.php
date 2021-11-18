<?php

class ObjetivosCalidad extends Validator
{
    private $rowid = null;
    private $proceso = null;
    private $objetivoCalidad = null;
    private $descripcion = null;
    private $palabraClave = null;
    
    public function setRowid($value)
    {
        if ($this->validateId($value)) {
            $this->rowid = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProceso($values)
    {
        if($this->validateAlphanumeric($values, 1, 50))
        {
            $this->proceso = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getRowid()
    {
        return $this->rowid;
    }

    public function setObjetivoCalidad($value)
    {
        if($this->validateAlphanumeric($value, 1, 50))
        {
            $this->objetivoCalidad = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getObjetivoCalidad()
    {
        return $this->objetivoCalidad;
    }

    public function setDescripcion($value)
    {
        if  ($this->validateAlphanumeric($value, 1, 120))
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

    public function setPalabraClave($value)
    {
        if($this->validateAlphanumeric($value,1 ,50))
        {
            $this->palabraClave = $value;
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function getPalabraClave()
    {
        return $this->palabraClave;
    }

    //scrud 

    public  function insertObjetivoCalidad()
    {
        
        $sql =  'INSERT INTO kt_objetivoscalidad (objetivocalidad_id , descripcion , palabra_clave) VALUES(?,?,?)';
        $param = array($this->objetivoCalidad, $this->descripcion, $this->palabraClave);
        return Conexion:: executeRow($sql,$param);
    }

    public function readObjetivoCalidad()
    {
        $sql = 'SELECT rowid , objetivocalidad_id, descripcion, palabra_clave FROM kt_objetivoscalidad ORDER BY rowid';
        $params = null;
        return Conexion::getRows($sql, $params);
    }

    public function readObjetivoCalidad2()
    {
        $sql = 'SELECT rowid , palabra_clave FROM kt_objetivoscalidad ORDER BY rowid';
        $params = null;
        return Conexion::getRows($sql, $params);
    }

    public function searchObjetivoCalidad($value)
    {
        $sql = 'SELECT * FROM kt_objetivoscalidad WHERE palabra_clave ILIKE ? OR descripcion ILIKE ? OR objetivocalidad_id ILIKE ?';
        $params = array("%$value%" , "%$value%" , "%$value%");
        return Conexion::getRows($sql, $params);
    }

    public function obtenerObjetivoCalidad()
    {
        $sql = 'SELECT rowid, objetivocalidad_id, descripcion, palabra_clave FROM kt_objetivoscalidad WHERE rowid = ?';
        $params = array($this->rowid);
        return Conexion::getRow($sql, $params);
    }
     
    public function updateObjetivoCalidad()
    {  
            $sql = 'UPDATE kt_objetivoscalidad SET objetivocalidad_id = ?, descripcion = ?, palabra_clave =? WHERE rowid = ?';
            $params = array($this->objetivoCalidad, $this->descripcion, $this->palabraClave, $this->rowid);  
        return Conexion::executeRow($sql, $params);
    }

    public function deleteObjetivoCalidad()
    {
        $sql = 'DELETE FROM kt_objetivoscalidad WHERE rowid = ?';
        $params = array($this->rowid);
        return Conexion::executeRow($sql, $params);
    }

    /*Método que devuelve la descripción de un proceso según su id*/
    public function getObjetivo()
    {
        $sql = 'SELECT PALABRA_CLAVE FROM KT_OBJETIVOSCALIDAD WHERE OBJETIVOCALIDAD_ID = ?;';
        $param = array($this->objetivoCalidad);
        return Conexion::getRow($sql, $param);
    }

    public function darProcesos($value)
    {
        $sql = 'SELECT DISTINCT(DESCRIPCION) FROM KT_INDICADORES I
        JOIN KT_PROCESOS P USING(PROCESO_ID)
        where OBJETIVOCALIDAD_ID = ?;';
        $param = array($this->objetivoCalidad);
        return Conexion::getRows($sql, $param);
    }

    public function darIndicadoresPorObjetivo($value)
    {
        $sql = 'SELECT I.INDICADOR_ID, I.NOMBRE, I.OBJETIVO_ESPECÍFICO as objetivo FROM KT_INDICADORES I
                JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID) where objetivocalidad_id = ?;';
        $params = array($this->objetivoCalidad);
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve los indicadores de un objetivo*/
    public function graficoIndicadores( $value )
    {
        $sql = 'SELECT COUNT(I.INDICADOR_ID) as cantidadindicadores, P.DESCRIPCION, O.PALABRA_CLAVE FROM KT_INDICADORES I
        JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID)
        JOIN KT_PROCESOS P USING(PROCESO_ID)
        WHERE I.OBJETIVOCALIDAD_ID = ? GROUP BY P.DESCRIPCION, O.PALABRA_CLAVE;';
        $params = array("$value");
        return Conexion::getRows($sql, $params);
    }
}

?>