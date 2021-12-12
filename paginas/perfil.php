<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="perfil";
    if($usuario=="" && $pass==""){
        
       echo "<script>
       var reply=confirm('No se ha iniciado sesion');
        if(reply){
            window.location='../index.html';
        
        }
       </script>";
        die();
    }
    
    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
    $op="SELECT * FROM usuario WHERE nombre='$usuario'";
    $resultado=mysqli_query($conexion,$op);
    $row=mysqli_fetch_array($resultado);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link rel="stylesheet" href="../estilos/estilosfondos/fondoperfil.css">
    <script src="https://kit.fontawesome.com/eefb3f6366.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <main class="contenedor">
     <input type="checkbox" name="" id="check" checked>

    <header class="site-header">
        
        <div class="site-elements">

            <div class="header-left">
                <label for="check"><i class="fas fa-bars" id="sidebar_btn"></i></label>
                <h1>IGNITION<span> PC</span></h1>
            </div>

            <div class="header-right">
               <a href="../paginas/perfil.php">
                    <button>PERFIL DEL USUARIO</button>
                </a>
                <a href="../funciones/closeSession.php">
                    <button>CERRAR SESIÓN</button>
                </a>
            </div>

        </div>

    </header>
     <div class="sidebar">

        <div class="profile-data">
           
        </div>

     
        <a href="proveedores.php?op=1"><i class="fas fa-shopping-cart"></i><span>Proveedores</span></a>
        <a href="compras.php?op=1"><i class="fas fa-shopping-cart"></i><span>Compras</span></a>
        <a href="almacen.php?op=1"><i class="fas fa-shopping-cart"></i><span>Almacen</span></a>
        <a href="piezas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Piezas</span></a>
        <a href="pieza_venta.php?op=1"><i class="fas fa-shopping-cart"></i><span>Piezas de venta</span></a>
        <a href="pieza_armado.php?op=1"><i class="fas fa-shopping-cart"></i><span>Piezas de armado</span></a>
        <a href="catalogo_piezas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Catálogo de Piezas</span></a>
        <a href="productos.php?op=1"><i class="fas fa-shopping-cart"></i><span>Productos</span></a>
        <a href="modelo.php?op=1"><i class="fas fa-shopping-cart"></i><span>Modelo</span></a>
        <a href="arquitecturas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Arquitecura</span></a>
        <a href="ventas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Venta</span></a>
        <a href="empleados.php?op=1"><i class="fas fa-shopping-cart"></i><span>Empleado</span></a>
        <a href="clientes.php?op=1"><i class="fas fa-shopping-cart"></i><span>Cliente</span></a>
        
    </div>

       <form action="" class="registrar-mode">
        <h2>DATOS DEL USUARIO <?php echo strtoupper($row['nombre']); ?> </h2>
           
       <table>
          <tr>
              <th>NOMBRE</th>
              <th>PRIVILEGIOS</th>
              <th>CORREO</th>
          
          </tr>
           
           <tr>
               <td><?php echo $row['nombre']; ?></td>
               <td><?php echo $row['privilegios']; ?></td>
               <td><?php echo $row['correo']; ?></td>
               
           </tr>
           
           
       </table>
    </form>
    <form action="../mysql/eliminar.php" method="post" class="eliminar-mode">
          <div class="formulario"></div>
          <h2>¿DESEAS ELIMINAR ESTE USUARIO?</h2>

       <div class="botones">
           <input id="enviar" name="tipo-elim" type="submit" value="Aceptar" class="btn" >
           
       </div>
      
   </form>
    <form action="../mysql/actualizar.php" method="post" class="actualizar-mode">
       
        <h2>ACTUALIZACIONES</h2>
        <div class="formulario">
        <input name="nombre" type="text" placeholder="Ingresa nuevo nombre. Actual: <?php echo $row['nombre'];?>">
        <input name="correo" type="text" placeholder="Ingresa nuevo correo. Actual: <?php echo $row['correo'];?>">
          <select name="privilegios" id="">
            <option value="nada" >Privilegios actuales: <?php echo $row['privilegios'];?></option>
            <option value="administrador">Administrador</option>
            <option value="usuario-cap">Usuario de captura</option>
            <option value="usuario-cons">Usuario de consulta</option>
            
            
        </select>
        <input name="contrasena_antigua" type="text" placeholder="Si deseas cambiar contraseña coloca la actual">
        <input name="contrasena_nueva" type="text" placeholder="Contraseña nueva">
        </div>
       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" >
           <input id="borrar" type="reset" value="BORRAR" class="btn" >  
           
       </div>
      
    
   </form>
 <form action="enviar.php" method="post" class="consultar-mode">
      <h2>INFORMACION DE LA EMPRESA</h2>
       <div class="formulario">
           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro nihil facere soluta dolores deserunt, magnam doloribus excepturi sunt earum maxime aut maiores perspiciatis dolorum tenetur voluptatum, hic neque nesciunt reiciendis.</p>
        </div>
   </form>
  <!---->
    
    
     <div class="radios">
             <img class="entrada" type="radio" id="radio-1" name="radio" this.onclick=null  src="../imagenes/next.png">
             <label for="radio-1"></label>
      </div>
    </main>
       
    
    <script src="../javascript/perfil.js"></script>
</body>
</html>


<?php mysqli_close($conexion); ?>