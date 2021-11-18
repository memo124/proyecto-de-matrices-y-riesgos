<?php

class Correlativos extends Validator
{   
    /*Creación del atributo que contiene el id del proceso*/
    private $proceso_id = null;
    // Declaracion de variables
    private $descripcion = null;
    private $id = null;
    private $ultimo = null;
    private $texto1 = null;
    private $texto2 = null;
    private $texto3 = null;
    private $texto4 = null;

    public function setProcesoId($value)
    {
        if( $this->validateAlphanumeric($value , 1 , 10) )
        {
            if( strip_tags($value) ){
                $texto1 = strip_tags($value);
                $this->proceso_id = $texto1;
                return true;
            }else{
                return false;
            }
        }  else {
            return false;
        }
    }

    //Metodos de set para obtener los datos
    public function setId($value)
    {
        if($this->validateId($value))
        {
            if( strip_tags($value) ){
                $texto2 = strip_tags($value);
                $this->id = $texto2;
                return true;
            }else{
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    //métodos empleados para mostrar correlativos en la tabla o para buscar un en especifico
    public function setDescripcion($value)
    {
        if($this->validateId($value))
        {
            if( strip_tags($value) ){
                $texto3 = strip_tags($value);
                $this->descripcion = $texto3;
                return true;
            }else{
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function setUltimo($value)
    {
        if($this->validateId($value))
        {
            if( strip_tags($value) ){
                $texto4 = strip_tags($value);
                $this->ultimo = $texto4;
                return true;
            }else{
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    //Metodos para obtener los gets

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getUltimo()
    {
        return $this->ultimo;
    }
    
    //metodos para realizar los mantenimientos necesarios
    public function createCorrelativo()
    {
        $sql = 'INSERT into KT_CORRELATIVOS(PROCESO_ID, CORRELATIVO_ID,ULTIMO_NUM_UTILIZADO)
		values( ?, ?, ?)';
        $param = array($this->descripcion,$this->id,$this->ultimo);     
        return Conexion::executeRow($sql, $param);
    }

    public function deleteCorrelativo()
    {
        $sql = 'DELETE FROM KT_CORRELATIVOS where CORRELATIVO_ID = ?';
        $param = array($this->id);     
        return Conexion::executeRow($sql, $param);
    }
//métodos empleados para mostrar correlativos en la tabla o para buscar un en especifico
    public function readCorrelativo()
    {
        $sql = 'SELECT P.DESCRIPCION, C.CORRELATIVO_ID, C.ULTIMO_NUM_UTILIZADO
                FROM KT_CORRELATIVOS C INNER JOIN KT_PROCESOS P 
                ON C.PROCESO_ID = P.PROCESO_ID';
        $param = null;
        return Conexion::getRows($sql, $param);
    }
    /*Método que sirve para buscar un correlativo*/

    public function getCorrelativo()
    {
        $sql = 'SELECT PROCESO_ID, CORRELATIVO_ID, ULTIMO_NUM_UTILIZADO
                FROM KT_CORRELATIVOS where CORRELATIVO_ID = ? ';
        $param = array($this->id);
        return Conexion::getRows($sql, $param);
    }

    public function buscarCorrelativo($value)
    {
        $sql = 'SELECT P.DESCRIPCION, C.CORRELATIVO_ID, C.ULTIMO_NUM_UTILIZADO
                FROM KT_PROCESOS P INNER JOIN KT_CORRELATIVOS C
                ON P.PROCESO_ID = C.PROCESO_ID
                WHERE P.DESCRIPCION ILIKE ? OR C.CORRELATIVO_ID ILIKE ?';
        $params = array("%$value%", "%$value%");
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve la descripción de un proceso según su id*/
    public function getProceso($value)
    {
        $sql = 'SELECT DESCRIPCION FROM KT_PROCESOS WHERE PROCESO_ID = ? ';
        $param = array("$value");
        return Conexion::getRow($sql, $param);
    }

    /*Método que devuelve los correlativos, según el id del proceso*/
    public function darCorrelativo($value)
    {
        $sql = 'SELECT CORRELATIVO_ID , ULTIMO_NUM_UTILIZADO FROM KT_CORRELATIVOS where proceso_id = ? ORDER BY ULTIMO_NUM_UTILIZADO;';
        $param = array("$value");
        return Conexion::getRows($sql, $param);
    }
    // Métodos para los gráficos y reportes del sistema.

    public function cantidadUsuariosRol()
    {
        $sql = 'SELECT COUNT(user_id)cantidad , rol from kt_usuarioscross group by rol';
        $params = null;
        return Database::getRows($sql, $params);
    }
}
?>