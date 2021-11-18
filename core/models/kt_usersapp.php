<?php


/*Se crea la clase UserApp que es heredada de la clase Validator*/
class UserApp extends Validator
{
    /*Se crean los atributos de la clase UserApp*/
    private $id = null;
    private $user_id = null;
    private $password = null;
    private $level = null;
    private $correo = null;
    private $estado = null;
    private $codigo = null;
    
    /*Se crean los métodos para otorgar valor a los atributos (Setters) y
    los métodos para obtener valores de los atributos (Getters)*/
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($values)
    {
        if($this->validateId($values)){
            $this->codigo = $values;
            return true ;
        }
        else
        {
            return false;
        }
    }

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

    public function setEstado($value)
    {
        if( $this->validateId($value) ) 
        {
            $this->estado = $value;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setUser($value)
    {
        if( $this->validateAlphanumeric($value, 1, 50) )
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

    public function setCorreo($value)
    {
        if( $this->validateEmail($value, 10, 50) )
        {
            $this->correo = $value;
            return true;
        }
        else
        {
            return false;
        }
    }



    public function getCorreo()
    {
        return $this->correo;
    }

    public function setPassword($values)
    {
        if  ( $this->validatePassword($values, 1 , 20) )
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
    tabla KT_USERSAPP de la base de datos*/

    /*Se crea el método que sirve para insertar en la tabla KT_USERSAPP*/
    public  function insertUser()
    {
        $hash =  password_hash($this->password, PASSWORD_DEFAULT);
        $sql =  'INSERT INTO kt_usersapp(USER_ID, PASSWORD , LEVEL, CORREO, ESTADO) VALUES(?,?,?,?,?)';
        $param = array($this->user_id, $hash, $this->level, $this->correo, $this->estado);
        return Conexion:: executeRow($sql,$param);
    }

    /*Se crea el método que sirve para leer los datos en general de la tabla KT_USERSAPP*/
    public function readUser()
    {
        $sql = 'SELECT rowid, user_id , level, correo, estado from kt_usersapp order by rowid';
        $param = null;
        return Conexion::getRows($sql, $param);
    }

    /*Se crea el método que sirve para leer los datos en general de la tabla KT_USERSAPP*/
    public function readUser2()
    {
        $sql = 'SELECT rowid, user_id from kt_usersapp order by rowid';
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
        $sql = 'UPDATE kt_usersapp set user_id = ?, level = ?,  correo = ?, estado = ? where rowid = ?';
        $param = array($this->user_id, $this->level, $this->correo, $this->estado, $this->id);
        return Conexion::executeRow($sql,$param);
    }

    /*Se crea el método que sirve para leer un dato especifico en base
    al campo ROWID de la tabla KT_USERSAPP*/
    public function getUserApp()
    {
        $sql = 'SELECT user_id,  level, correo , estado from kt_usersapp where rowid = ?';
        $param = array($this->id);
        return Conexion::getRow($sql, $param);
    }

    /*Se crea el método que sirve para buscar datos de la tabla KT_USERSAPP*/    
    public function searchUserApp($value)
    {
        $sql = 'SELECT ROWID , USER_ID , LEVEL, ESTADO , CORREO FROM KT_USERSAPP WHERE USER_ID ILIKE ? OR LEVEL ILIKE ? OR CORREO ILIKE ? ORDER BY ROWID';
        $params = array("%$value%","%$value%", "%$value%");
        return Conexion::getRows($sql, $params);
    }

    /*Métodos que sirven para la funcionalidad de iniciar sesión o registrarse*/

    /*Método que verifica que esté correcto y exista el nombre de usuario*/
    public function checkAlias($usuario)
    {
        $sql = 'SELECT rowid , correo FROM KT_USERSAPP WHERE USER_ID = ? AND ESTADO = 1';
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
        $sql = 'SELECT password FROM KT_USERSAPP WHERE ROWID = ? AND ESTADO = 1';
        $params = array($this->id);
        $data = Conexion::getRow($sql, $params);
        if ( password_verify($contrasena, $data['password']) ) {
            return true;
        } else {
            return false;
        }
    }

    /*Método que verifica que esté correcto y exista el nombre de usuario*/
    public function checkEmail($correo)
    {
        $sql = 'SELECT rowid , level FROM KT_USERSAPP WHERE CORREO = ? AND USER_ID = ? AND ESTADO = 1';
        $params = array($correo, $this->user_id);
        if ( $data = Conexion::getRow($sql, $params) ) {
            $this->id = $data['rowid'];
            $this->level = $data['level'];
            $this->correo = $correo;
            return true;
        } else {
            return false;
        }
    }

    /*Se crea el método que sirve para insertar en la tabla KT_USERSAPP*/
    public  function registrarUsuario()
    {
        $hash =  password_hash($this->password, PASSWORD_DEFAULT);
        $sql =  'INSERT INTO kt_usersapp(USER_ID, PASSWORD , LEVEL, CORREO, ESTADO) VALUES(?,?,?,?, 1)';
        $param = array($this->user_id, $hash, $this->level, $this->correo);
        return Conexion:: executeRow($sql,$param);
    }

    public function verificarCuenta()
        {
        $sql = 'SELECT correo , user_id , password FROM KT_USERSAPP WHERE USER_ID = ? AND CORREO = ? AND ESTADO = 1';
        $params = array($this->user_id , $this->correo);
        if ($data = Conexion::getRow($sql, $params)) {
            $this->user_id = $data['user_id'];
            $this->correo = $data['correo'];
            $this->password = $data['password'];
            return Conexion::getRow($sql, $params);
        } else {
            return false;
        }
        }

        public function enviarCorreo( $correo , $nombreusuario )
        {
            $this->codigo = rand(100000 , 999999);
            $receptor = $correo;
            $asunto = 'Código de confirmación';
            $mensaje = 'Hola '.$nombreusuario.', el código es: '.$this->codigo.' deja de olvidar las mierd4s, dice el homeboy que te pongas a estudiar o sino te van a verguear 18 segundos otra vez';
            $encabezados = 'From: fatimacarrillo300@gmail.com' . "\r\n" .
                'Reply-To: fatimacarrillo300@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            mail( $receptor , $asunto , $mensaje , $encabezados );
            return $this->codigo;
        }

        public function updatePasswordUser()
        {
            $hash =  password_hash($this->password, PASSWORD_DEFAULT);
            $sql = 'UPDATE kt_usersapp set password = ? where user_id = ?';
            $param = array($hash, $this->user_id);
            return Conexion::executeRow($sql,$param);
        }

        public function changePassword()
        {
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = 'UPDATE kt_usersapp SET password = ? WHERE rowid = ?';
        $params = array($hash, $this->id);
        return Conexion::executeRow($sql, $params);
        }

        /*Se crea el método que sirve para actualizar datos de la tabla KT_USERSAPP*/
        public function banearP3ndejo()
        {
            $sql = 'UPDATE kt_usersapp set estado = 2 where user_id = ?';
            $param = array($this->user_id);
            return Conexion::executeRow($sql,$param);
        }

        public function verificarRango($id_usuario)
        {
            $sql = 'SELECT level FROM KT_USERSAPP WHERE ROWID = ?';
            $params = array($id_usuario);
            if ( $data = Conexion::getRow($sql, $params) ) {
                $this->level = $data['level'];
                return true;
            } else {
                return false;
            }
        }
}
?>