<?php 
include 'connection.php';

function checkLogin() {
    //LOGIN
if(!isset($_SESSION["user"])){//if there is no session
  if(isset($_COOKIE["activities_user"])){//if the $_COOKIE[] variable is defined
    
    $_SESSION["user"] = getUserById($_COOKIE["activities_user"]);
    // storing in the cookie the user ID
  }
}
if(!isset($_SESSION["user"])){
   //begin with the login page

    header("Location: login/login.php");// muy importante la L en mayúscula y los : ponerlos seguidos sin espacio
    exit();

}
}

  // function to obtain the user from the db

  function getUser($userName, $password) {
      
        global $connection;
        //sql query
        // using ? to avoid missintended sql injection in the data base
        $query = "SELECT id, nombre, correo 
                FROM usuarios
                WHERE nombre = ? AND contrasena = ?"; //  avoid this nombre = '{$userName}'
        //template
        //stmt = statement
        $stmt = $connection->prepare($query); 
        $stmt->bind_param('ss', $userName, $password); // ss means that there are twp parameters which are strings
        $stmt->execute();
        //storing the result for that query using a method from the $smtp object
        $result =  $stmt->get_result();
        //control query errors
        if($result){
            //if the query is correct

            // iterate through each table row
          $loggedUser = mysqli_fetch_assoc($result);   
          return $loggedUser;
        }   
        else{
            //if not
            echo $connection->error; // IMPORTANT!! error not $error, since it is not a variable we define
        
        }
   }
 // get user from the cookie
 
  function getUserById($id) {
      
        global $connection;
        //sql query
        // using ? to avoid missintended sql injection in the data base
        $query = "SELECT id, nombre, correo 
                FROM usuarios
                WHERE id = ?"; //  avoid this nombre = '{$userName}'
        //template
        //stmt = statement
        $stmt = $connection->prepare($query); 
        $stmt->bind_param('s', $id); 
        $stmt->execute();
        //storing the result for that query using a method from the $smtp object
        $result =  $stmt->get_result();
        //control query errors
        if($result){
            //if the query is correct

            // iterate through each table row
          $loggedUser = mysqli_fetch_assoc($result);   
          return $loggedUser;
        }   
        else{
            //if not
            echo $connection->error; // IMPORTANT!! error not $error, since it is not a variable we define
        
        }
  }
  function doLogin($user) {
      
          //  $user_name = $_POST["username"]; // con esto no guardo los datos que me llegan por base de datos
          //the line above is replaced with: to connect to the column id from the data base
          $user_id = $user["id"]; 
          $_SESSION["user"]  = $user;//asigning session to logged user
          setcookie("activities_user", $user_id, time() + 86400, "/"); // persistency during 1 day
          // we only strore the id on the cookie
          //redirection
          header("Location: ../index.php");
          exit();
  }
  //insert user
  function insert_users($id,$password,$email,$userName) {
      
        global $connection;
        //sql query
        //very important if i use a ñ in contraseña it will return an error with the 'cotejamiento' in phpmyadmin
        $insert_query = "INSERT INTO usuarios (id,contrasena,correo,nombre)
                         VALUES(?,?,?,?)";

                          //template
        //stmt = statement
        $stmt = $connection->prepare($insert_query); 
        $stmt->bind_param( 'ssss', $id,$password,$email,$userName);
        $stmt->execute();
        //storing the result for that query using a method from the $smtp object
        $insert_result =  $stmt->get_result();
       
        
        //control insert errors
        if(isset($insert_result)){
            //if the insert is correct
            return true;
        }
        else{
            //if not
            //echo $connection->error .'</br>'; // IMPORTANT!! error not $error, since it is not a variable we define
            //this will display a detailed error about why the insert has failed
            return false;
        
        }
   }
?>