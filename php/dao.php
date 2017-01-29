<?php
/**
* Definicion de Base de datos y tablas
*/
define ('DATABASE','incidenciasJuanAntonio');
define('MYSQL_HOST', 'mysql:dbname='.DATABASE.';host=localhost;');
define('MYSQL_USER', 'incidenceJuan');
define('MYSQL_PASSWORD', '123');

define('TABLE_TEACHER', 'teachers');
define('TABLE_INCIDENCE', 'incidence');
define('TABLE_TYPEINCIDENCE', 'type_incidence');

define('USER_NAME', 'user');
define('USER_PASSWORD', 'password');

define('INCIDENCE_ID', 'id');
define('INCIDENCE_IDTEACHER', 'id_teacher');
define('INCIDENCE_NAMEALUMN', 'name_alumno');
define('INCIDENCE_TITLE', 'title');
define('INCIDENCE_IDTYPEINCIDENCE', 'id_typeincidence');
define('INCIDENCE_DATE', 'fecha');

define('TYPEINCIDENCE_ID', 'id');
define('TYPEINCIDENCE_DESCRIPTION', 'description');

/**
* Creacion de la clase DAO para la conexion
*/
    class Dao{
        protected $connection;
        public $error;

        /** Se crea un objeto de conexion a la base de datos en el constructor
        y se inicializaría el resto de datos*/
        public function __construct(){
            try{
                $this->connection = new PDO(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
            } catch (PDOException $e){
                $this->error = "Error en la conexión: ".$e.getMessage();
                $this->connection = null;
                echo $this->error;
            }
        }

        /**
        * Funcion que destruye la conexión si está conectado
        */
        function __destruct(){
            if ($this->isConnected()){
                $this->connection = null;
            }
        }

        /**
        * Funcion para comprobar si el usuario esta conectado.
        */
        function isConnected(){
            if ($this->connection != null){
                return $this->connection;
            } else
                return false;
        }




        /**
        * Funcion que chequea el usuario en la base de datos sql
        */
        function checkUser($username, $password){
            //sentencia sql
            $sql = "SELECT * FROM ".TABLE_TEACHER." WHERE user='".$username."' AND password=sha1('".$password."')";
            $result =0;
            //Sentencia que devuelve un objeto con los datos de la consulta
            $statement = $this->connection->prepare($sql);
            $statement->execute();
           
            //Comprobar 
            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(PDO::FETCH_ASSOC);
            } 
            return $result;
        }

        

        /**
        * Funcion que añade un nuevo profesor en la base de datos
        */
        function addTeacher($name, $pass){
            $sql = "INSERT INTO teachers (user, password) VALUES (".$name.",sha1('".$pass."')";
            $sentencia = $this->connection->prepare($sql);
            try{
                $sentencia->execute();
                return true;
            } catch(PDOException $e){
                return false;
            }
            
        }

        /**
        * Funcion que modifica un nuevo profesor en la base de datos
        */
        function alterTeacher($name, $pass){
            $sql = "INSERT INTO teachers (user, password) VALUES (".$name.",sha1('".$pass."')";
            $sentencia = $this->connection->prepare($sql);
            try{
                $sentencia->execute();
                return true;
            } catch(PDOException $e){
                    return false;
            }
        }


        function listarIncidenciasToday(){
            $sql = "SELECT * FROM incidence WHERE fecha = CURDATE()";
            $sentencia = $this->connection->query($sql);
            //$sentencia->execute($sql);
            return $sentencia;
                
        }
        function listarIncidenciasAll(){
            $sql = "SELECT * FROM incidence";
            $sentencia = $this->connection->query($sql);
            //$sentencia->execute($sql);
            return $sentencia;
                
        }

        function getIncidencia($id){
            $sqlName="SELECT description FROM type_incidence where id=".$id;
            $description =  $this->connection->query($sqlName);
            $incid=$description->fetch();
            return $incid[0];
        }
        function getNameProfe($id){
            $sql= "SELECT user FROM teachers WHERE id =".$id."";
            $sentencia = $this->connection->query($sql);
            $nombre = $sentencia->fetch();
            return $nombre[0];
        }

        function deleteIncidencia($id){
            $sql= "DELETE FROM incidence WHERE id =".$id."";
            $sentencia = $this->connection->query($sql);
        }

        function dameIncidencias(){
            $sql= "SELECT * FROM type_incidence";
            $sentencia = $this->connection->query($sql);
            return $sentencia->fetchAll();
        }

        function filtroIncidencias($desde, $hasta){
            $sql1="SELECT * FROM incidence WHERE fecha >= '".$desde."' and fecha <= '".$hasta."' ORDER BY fecha" ;
                $sentencia = $this->connection->query($sql1);
            return $sentencia;
        }

        function otraIncidencia($id,$name, $title,$description, $date){
            $sql ="UPDATE incidence SET  name_alumno = '".$name."', title = '".$title."', id_typeincidence = ".$description.", fecha = '".$date."' WHERE id = ".$id;
            try{
                $sentencia = $this->connection->query($sql);
                return true;
            } catch(PDOException $e){
                return false;
            }
        }

        function otraIncidenciaMas($id,$name, $title,$description){
            $sql ="INSERT INTO incidence (id_teacher, name_alumno, title, id_typeincidence,fecha) VALUES (".$id.", '".$name."','".$title."',".$description.",CURDATE())";
            try{
                $sentencia = $this->connection->query($sql);
                return true;
            } catch(PDOException $e){
                return false;
            }
        }

        function listarProfes(){
            $sql = "SELECT * FROM teachers";
            $sentencia = $this->connection->query($sql);
            //$sentencia->execute($sql);
            return $sentencia;
        }

        function deleteTeacher($idinc){
            $sql= "UPDATE teachers SET borrado = 1 WHERE id =".$idinc."";
            $sentencia = $this->connection->query($sql);
        }

        function getProfe($id){
            $sql = "SELECT * FROM teachers WHERE id=".$id."";
            $sentencia = $this->connection->query($sql);
            //$sentencia->execute($sql);
            return $sentencia;
        }

        function otroTeacher($name, $pass, $idinc){
            $sql = "UPDATE teachers SET user = '".$name."' , password = sha('".$pass."') WHERE id =".$idinc."";
            try{
                $sentencia = $this->connection->query($sql);
                return true;
            } catch(PDOException $e){
                return false;
            }
        }


        function newTeacher($name, $pass){
            $sql = "INSERT INTO teachers(user, password) VALUES ('".$name."',sha1('".$pass."'))";
            try{
                $sentencia = $this->connection->query($sql);
                return true;
            } catch(PDOException $e){
                return false;
            }
        }

        function getIncidence($id){
            $sql = "SELECT * FROM incidence WHERE id=".$id."";
            $sentencia = $this->connection->query($sql);
            //$sentencia->execute($sql);
            return $sentencia;
        }
    }

?>
