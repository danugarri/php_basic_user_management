
<?php 

  require './controller/userController.php';
  global $connection;
  //variables to handle the result for the registry
  $registrySuccessful = '';
  $insertError = "";
  if(isset($_POST["signin"])){

      $insert_users_result = insert_users($_POST['id'],$_POST['password'],$_POST['email'],$_POST['userName']);
       if(isset($insert_users_result)){
           $registrySuccessful= 'El usuario se ha registrado correctamnete';
       }
       else{
           
           $insertError = ' </br>Error en el resgistro</br>';
       }
  }
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="styleSheet" type="text/css" href="../style.css">
    <link rel="styleSheet" type="text/css" href="signin.css">
    <title> Sign in</title>
</head>
<body>
  <header id="header">
    <a class="logout" href="index.html">Volver</a>
  </header>
  <main class="container">
      <section class="activity-box">
      </section>
      <!--html form-->
      <section id="form-box">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
            <h1>Regístrate</h1>
            <label for="userName">Usuario</label>
            <input type="text" name="userName" placeholder="Nombre completo" required/><br/>
            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Contraseña" required /><br/>
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Email" required /><br/>
            <label for="id">nickName</label>
            <input type="text" name="id" placeholder="ejemplo33" required /><br/>
            <input type="submit" value="Registrarse" name="signin"/>
        </form>
        <div id="signin-failed">
            <?php 
            if(isset($insertError)){
                echo $insertError;
                echo $connection->error; //error brought from insert.php 
            }?>
        </div>
        <div id="signin-success">
            <?php
            if(isset($registrySuccessful)){
                echo $registrySuccessful;
            }
                ?>
        </div>
    </section>
  </main>
</body>
</html>