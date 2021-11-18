<?php
//Nommbre de la clase donde se pondran las variables y scripts
class Indicadores extends Validator
{   
    //Variables globales de la tabla a usar
    private $id = null;
    private $id2 = null;
    private $proceso = null;
    private $indicador = null;
    private $nombre = null;
    private $objetivoCal = null;
    private $objetivo = null;
    private $formula = null;
    private $valoractual = null;
    private $valorpotencia = null;
    private $meta = null;
    private $frecuencia = null;
    private $responsable = null;
    private $responsible = null;
    private $fuente = null;
    //captura y muestra de cada una de las variables 
    public function setId($values)
    {
        if($this->validateId($values))
        {
            $this->id = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setId2($values)
    {
        if($this->validateId($values))
        {
            $this->id2 = $values;
            return true;
        }
        else
        {
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

    public function getProceso()
    {
        return $this->proceso;
    }

    public function setIndicador($values)
    {
        if($this->validateAlphanumeric($values, 1 ,50))
        {
            $this->indicador = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getIndicador()
    {
        return $this->indicador;
    }

    public function setNombre($values)
    {
        if($this->validateAlphanumeric($values, 1, 50))
        {
            $this->nombre = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setObjetivosCal($values)
    {
        if($this->validateAlphanumeric($values, 1, 50))
        {
            $this->objetivoCal = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getObjetivosCal()
    {
        return $this->objetivoCal;
    }

    public function setObjetivos($values)
    {
        if($this->validateAlphanumeric($values, 1, 50))
        {
            $this->objetivo = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getObjetivos()
    {
        return $this->objetivo;
    }

    public function setFormula($values)
    {
        if($this->validateAlphanumeric($values, 1, 50))
        {
            $this->formula = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getFormula()
    {
        return $this->formula;
    }

    public function setValorActual($values)
    {
        if($this->validateAlphanumeric($values,1 ,50))
        {
            $this->valoractual = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getValorActual()
    {
        return $this->valoractual;
    }

    public function setValorPotencia($values)
    {
        if($this->validateAlphanumeric($values,1 ,50))
        {
            $this->valorpotencia = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getValorProtencia()
    {
        return $this->valorpotencia;
    }

    public function setMeta($values)
    {
        if($this->validateAlphanumeric($values,1 ,50))
        {
            $this->meta = $values;
            return true;
        }
        else
        {
            return false;
        } 
    }


    public function getMeta()
    {
        return $this-> meta;
    }

    public function setFrecuencia($values)
    {
        if($this->validateAlphanumeric($values, 1, 50))
        {
            $this->frecuencia = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getFrecuencia()
    {
        return $this->frecuencia; 
    }

    public function setResponsable($values)
    {
        if($this->validateAlphanumeric($values, 1, 50))
        {
            $this->responsable = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getRespondable()
    {
        return $this->responsable;
    }

    public function setResponsible($values)
    {
        if($this->validateAlphanumeric($values,1 ,50))
        {
            $this->responsible = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getResposible()
    {
        return $this->responsible;
    }

    public function setFuente($values)
    {
        if($this->validateAlphanumeric($values, 1, 50))
        {
            $this->fuente = $values;
            return true;
        }
        else
        {
            return false;
        }
    }
    //Scrips que se usaran para la tabla kt_indicadores

    //son foráneas los campos de proceso_id y objetivocalidad_id
    public  function insertIndicadores()
    {
        $sql =  'INSERT INTO KT_INDICADORES(PROCESO_ID, INDICADOR_ID, NOMBRE, OBJETIVOCALIDAD_ID, OBJETIVO_ESPECÍFICO,
                 FÓRMULA_DE_CALCULO, VALOR_ACTUALIDAD, VALOR_POTENCIALIDAD, META, FRECUENCIA_MEDICION, RESPONSABLE_MEDICION,
                  RESPONSIBLE_SEGUIMIENTO, FUENTE_INFORMACIÓN) 
                  VALUES( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? )';
        $param = array($this->proceso, $this->indicador, $this->nombre, $this->objetivoCal, $this->objetivo, $this->formula,
                       $this->valoractual, $this->valorpotencia, $this->meta, $this->frecuencia, $this->responsable, $this->responsible,
                       $this->fuente);
        return Conexion:: executeRow($sql,$param);
    }

    public function readIndicadores()
    {
        $sql = 'SELECT I.ROWID , P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE,
                I.OBJETIVO_ESPECÍFICO AS objetivoes, I.FÓRMULA_DE_CALCULO AS formula, 
                I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, 
                I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN AS fuente
                FROM KT_INDICADORES I JOIN KT_PROCESOS P USING(PROCESO_ID) 
                JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID) ORDER BY I.ROWID;';
        $param = null;
        return Conexion::getRows($sql, $param);
    }

    /*Se crea el método que sirve para buscar datos de la tabla KT_INDICADORES*/    
    public function searchIndicadores($value)
    {
        $sql = 'SELECT I.ROWID , P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE, 
                I.OBJETIVO_ESPECÍFICO AS objetivoes, I.FÓRMULA_DE_CALCULO AS formula, I.VALOR_ACTUALIDAD, 
                I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, I.RESPONSABLE_MEDICION, 
                I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN AS fuente FROM KT_INDICADORES I 
                JOIN KT_PROCESOS P USING(PROCESO_ID) JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID)  
                WHERE P.DESCRIPCION ILIKE ? OR I.INDICADOR_ID ILIKE ? OR I.NOMBRE ILIKE ?
                OR O.PALABRA_CLAVE ILIKE ? OR I.OBJETIVO_ESPECÍFICO ILIKE ? OR I.FÓRMULA_DE_CALCULO ILIKE ? 
                OR I.VALOR_ACTUALIDAD ILIKE ? OR I.VALOR_POTENCIALIDAD ILIKE ?
                OR I.META ILIKE ? OR I.FRECUENCIA_MEDICION ILIKE ? OR I.RESPONSABLE_MEDICION ILIKE ?
                OR I.FUENTE_INFORMACIÓN ILIKE ? ORDER BY I.ROWID;';
        $params = array("%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%","%$value%",
                        "%$value%","%$value%","%$value%","%$value%");
        return Conexion::getRows($sql, $params);
    }

    public function getProcesoIn( $value )
    {
        $sql = 'SELECT proceso_id FROM KT_PROCESOS WHERE DESCRIPCION = ?';
        $param = array("$value");
        if ( $data = Conexion::getRow($sql, $param) ) {
            $this->proceso = $data['proceso_id'];
            return true;
        } else {
            return false;
        }
    }

    public function getObjetivoIn( $value )
    {
        $sql = 'SELECT objetivocalidad_id as objetivocalidad FROM KT_OBJETIVOSCALIDAD WHERE PALABRA_CLAVE = ? ';
        $param = array("$value");
        if ( $data = Conexion::getRow($sql, $param) ) {
            $this->objetivoCal = $data['objetivocalidad'];
            return true;
        } else {
            return false;
        }
    }

    public function getIndicadores()
    {
        $sql = 'SELECT I.ROWID , P.PROCESO_ID , O.OBJETIVOCALIDAD_ID ,P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE AS descrip, I.OBJETIVO_ESPECÍFICO AS objetivoes, I.FÓRMULA_DE_CALCULO AS formula, 
        I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN AS fuente
        FROM KT_INDICADORES I JOIN KT_PROCESOS P USING(PROCESO_ID) JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID)  WHERE I.ROWID = ?';
        $param = array($this->id);
        return Conexion::getRow($sql, $param);
    }

    public function updateIndicadores()
    {
        $sql = 'UPDATE KT_INDICADORES SET PROCESO_ID = ? , INDICADOR_ID = ? , NOMBRE = ? , OBJETIVOCALIDAD_ID = ? , OBJETIVO_ESPECÍFICO = ? ,
                FÓRMULA_DE_CALCULO = ? , VALOR_ACTUALIDAD = ? , VALOR_POTENCIALIDAD = ? , META = ? , FRECUENCIA_MEDICION = ? , RESPONSABLE_MEDICION = ? ,
                RESPONSIBLE_SEGUIMIENTO = ? , FUENTE_INFORMACIÓN = ? WHERE ROWID = ? ';
        $param = array($this->proceso, $this->indicador, $this->nombre, $this->objetivoCal, $this->objetivo, $this->formula,
                       $this->valoractual, $this->valorpotencia, $this->meta, $this->frecuencia, $this->responsable, $this->responsible,
                       $this->fuente, $this->id);
        return Conexion::executeRow($sql,$param);
    }

    public function deleteIndicador()
    {
        $sql = 'DELETE from KT_INDICADORES where ROWID = ?';
        $param = array($this->id);
        return Conexion::executeRow($sql,$param);
    }

    /*Método que devuelve la descripción de un proceso según su id*/
    public function getProceso2($value)
    {
        $sql = 'SELECT DESCRIPCION FROM KT_PROCESOS WHERE PROCESO_ID = ? ';
        $param = array("$value");
        return Conexion::getRow($sql, $param);
    }

    /*Método que devuelve los indicadores, según el id del proceso*/
    public function darIndicadores($value)
    {
        $sql = 'SELECT I.INDICADOR_ID, I.NOMBRE, O.PALABRA_CLAVE, I.OBJETIVO_ESPECÍFICO AS objetivo FROM KT_INDICADORES I
        JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID) where proceso_id = ?;';
        $param = array("$value");
        return Conexion::getRows($sql, $param);
    }
    public function readProcesosIndicadores()
    {
        $sql = 'SELECT I.ROWID , P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE,
        I.OBJETIVO_ESPECÍFICO AS objetivoes, I.FÓRMULA_DE_CALCULO AS formula, 
        I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, 
        I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN AS fuente
        FROM KT_INDICADORES I JOIN KT_PROCESOS P USING(PROCESO_ID) 
        JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID)
        WHERE P.ROWID = ?
        GROUP BY P.ROWID, P.DESCRIPCION,I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE,
        I.OBJETIVO_ESPECÍFICO, I.FÓRMULA_DE_CALCULO, 
        I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, 
        I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN;';
        $param = array($this->proceso);
        return Conexion::getRows($sql, $param);
    }

    public function readObjetivoIndicadores()
    {
        $sql = 'SELECT I.ROWID , P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE,
        I.OBJETIVO_ESPECÍFICO AS objetivoes, I.FÓRMULA_DE_CALCULO AS formula, 
        I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, 
        I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN AS fuente
        FROM KT_INDICADORES I JOIN KT_PROCESOS P USING(PROCESO_ID) 
        JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID) 
        where o.rowid = ?
        GROUP BY I.ROWID , P.DESCRIPCION, I.INDICADOR_ID, I.NOMBRE , O.PALABRA_CLAVE,
        I.OBJETIVO_ESPECÍFICO, I.FÓRMULA_DE_CALCULO, 
        I.VALOR_ACTUALIDAD, I.VALOR_POTENCIALIDAD, I.META, I.FRECUENCIA_MEDICION, 
        I.RESPONSABLE_MEDICION, I.RESPONSIBLE_SEGUIMIENTO, I.FUENTE_INFORMACIÓN ';
        $param = array($this->id);
        return Conexion::getRows($sql, $param);
    }
}

?>