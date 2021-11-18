<?php


/*Se crea la clase UserApp que es heredada de la clase Validator*/
class Matrices extends Validator
{
    /*Se crean los atributos de la clase UserApp*/
    private $id = null;
    private $user_id = null;
    private $password = null;
    private $level = null;
    
    /*Se crean los métodos para otorgar valor a los atributos (Setters) y
    los métodos para obtener valores de los atributos (Getters)*/
    public function setId($value)
    {
        if( $this->validateId($value) ) 
        {
            $this->id = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getId(){
        return $this->id;
    }

    public function setUser($value)
    {
        if( $this->validateAlphabetic($value, 1, 50) )
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

    public function setPassword($values)
    {
        if  ( $this->validatePassword($values) )
        {
            $this->password = $values;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setLevel($value)
    {
        if( $this->validateAlphabetic($value,1 ,50) )
        {
            $this->level = $value;
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function getLevel()
    {
        return $this->level;
    }

    /*Se crean los métodos que sirven para hacer los mantenimientos de la
    tabla Matrices de la base de datos*/

    /*Se crea el método que sirve para insertar en la tabla KT_USERSAPP*/
    public  function insertMatriz()
    {
        $hash =  password_hash($this->password, PASSWORD_DEFAULT);
        $sql =  'INSERT INTO kt_usersapp(USER_ID, PASSWORD , LEVEL) VALUES(?,?,?)';
        $param = array($this->user_id, $hash, $this->level);
        return Conexion:: executeRow($sql,$param);
    }

    /*Se crea el método que sirve para leer los datos en general de la tabla KT_USERSAPP*/
    public function readMatris()
    {
        $sql = 'SELECT m.matriz_id, t.descripcion as DescripcionM, o.palabra_clave, p.descripcion as Proceso, i.nombre as Indicador, pi.requisito_identificado,
        m.clasificacion_matriz, m.ro_num, m.edicion_num, m.status, m.entrada, m.salida, m.oportunidad, m.riesgo, m.etapa, 
        m.mercado_e_imagen, m.afectacion_recursos, m.cumplimiento_requisitos, m.medio_ambiente, m.responsabilidad_social,
        m.seguridad, m.consecuencia, m.controles_existentes, ec.descripcion as Eficacia, m.causa, f.descripcion as Factibilidad, im.descripcion as impactos, m.resultado,
        nor.descripcion as Nivel, dor.descripcion as Decisiones, pa.descripcion as Probablidad
        from matrices m
        inner join kt_tiposmatriz t using(tipomatriz_id)
        inner join kt_objetivoscalidad o using(objetivocalidad_id)
        inner join kt_procesos p using(proceso_id)
        inner join kt_indicadores i using(indicador_id)
        inner join kt_partes_interesadas pi using(parte_interesada_id)
        inner join kt_eficaciacontroles ec using(eficacia_id)
        inner join kt_factibilidad f using(factibilidad_id)
        inner join kt_impactos im using(impacto_id)
        inner join kt_nivel_or nor using(nivel_or_id)
        inner join kt_decisiones_or dor using(decision_or_id)
        inner join kt_probabilidadesocurrencia pa using(probabilidad_id)
        order by m.rowid';
        $param = null;
        return Conexion::getRows($sql, $param);
    }

    /*Se crea el método que sirve para eliminar datos de la tabla KT_USERSAPP*/
    public function deleteUser()
    {
        $sql = 'DELETE from kt_usersapp where rowid = ?';
        $param = array($this->id);
        return Conexion::executeRow($sql,$param);
    }

    /*Se crea el método que sirve para actualizar datos de la tabla KT_USERSAPP*/
    public function updateUser()
    {
        $sql = 'UPDATE kt_usersapp set user_id = ?, level = ? where rowid = ?';
        $param = array($this->user_id, $this->level, $this->id);
        return Conexion::executeRow($sql,$param);
    }

    /*Se crea el método que sirve para leer un dato especifico en base
    al campo ROWID de la tabla KT_USERSAPP*/
    public function getUserApp()
    {
        $sql = 'SELECT user_id,  level from kt_usersapp where rowid = ?';
        $param = array($this->id);
        return Conexion::getRow($sql, $param);
    }

    /*Se crea el método que sirve para buscar datos de la tabla KT_USERSAPP*/    
    public function searchUserApp($value)
    {
        $sql = 'SELECT ROWID , USER_ID , LEVEL FROM KT_USERSAPP WHERE USER_ID ILIKE ? OR LEVEL ILIKE ? ORDER BY ROWID';
        $params = array("%$value%","%$value%");
        return Conexion::getRows($sql, $params);
    }

    /*Métodos que sirven para la funcionalidad de iniciar sesión o registrarse*/

    /*Método que verifica que esté correcto y exista el nombre de usuario*/
    public function checkAlias($usuario)
    {
        $sql = 'SELECT rowid FROM KT_USERSAPP WHERE USER_ID = ?';
        $params = array($usuario);
        if ( $data = Conexion::getRow($sql, $params) ) {
            $this->id = $data['rowid'];
            $this->user_id = $usuario;
            return true;
        } else {
            return false;
        }
    }

    /*Método que verifica que esté correcto y exista la contraseña de usuario*/
    public function checkPassword($contrasena)
    {
        $sql = 'SELECT password FROM KT_USERSAPP WHERE ROWID = ?';
        $params = array($this->id);
        $data = Conexion::getRow($sql, $params);
        if ( password_verify($contrasena, $data['password']) ) {
            return true;
        } else {
            return false;
        }
    }
    
    /*Método que devuelve los usuarios de un proceso agrupados por el rol*/
    public function graficoUsuarios()
    {
        $sql = 'SELECT COUNT(U.ROL)AS usuarios, U.ROL as rol , P.DESCRIPCION as descrip FROM KT_USUARIOSCROSS U 
                JOIN KT_PROCESOS P USING(PROCESO_ID)
                GROUP BY P.DESCRIPCION, ROL;';
        $params = null;
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve los correlativos de un proceso agrupados por el número*/
    public function graficoCorrelativos( )
    {
        $sql = 'SELECT COUNT(DISTINCT(C.CORRELATIVO_ID)) as cantidadcorrelativo, C.CORRELATIVO_ID,  C.ULTIMO_NUM_UTILIZADO, P.DESCRIPCION as descrip FROM KT_CORRELATIVOS C
                JOIN KT_PROCESOS P USING(PROCESO_ID) 
                GROUP BY C.CORRELATIVO_ID , C.ULTIMO_NUM_UTILIZADO , P.DESCRIPCION;';
        $params = null;
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve los indicadores de un proceso*/
    public function graficoIndicadores(  )
    {
        $sql = 'SELECT COUNT(I.INDICADOR_ID) as cantidadindicadores , P.DESCRIPCION FROM KT_INDICADORES I
        JOIN KT_PROCESOS P USING(PROCESO_ID) GROUP BY P.DESCRIPCION;';
         $params = null;
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve las partes interesadas de un proceso*/
    public function graficoPI( )
    {
        $sql = 'SELECT COUNT(PI.PARTE_INTERESADA_ID) as cantidadparte , P.DESCRIPCION 
                FROM KT_PARTES_INTERESADAS PI
                JOIN KT_PROCESOS P USING(PROCESO_ID) GROUP BY P.DESCRIPCION;';
         $params = null;
        return Conexion::getRows($sql, $params);
    }

    /*Método que devuelve los indicadores de un objetivo*/
    public function graficoIndicadores2(  )
    {
        $sql = 'SELECT COUNT(I.INDICADOR_ID) as cantidadindicadores, P.DESCRIPCION, O.PALABRA_CLAVE FROM KT_INDICADORES I
        JOIN KT_OBJETIVOSCALIDAD O USING(OBJETIVOCALIDAD_ID)
        JOIN KT_PROCESOS P USING(PROCESO_ID)
         GROUP BY P.DESCRIPCION, O.PALABRA_CLAVE;';
        $params = null;
        return Conexion::getRows($sql, $params);
    }
}
?>