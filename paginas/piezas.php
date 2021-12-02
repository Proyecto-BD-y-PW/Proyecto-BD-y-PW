
<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    if($usuario=="" && $pass==""){
        
       echo "<script>
       var reply=confirm('No se ha iniciado sesion');
        if(reply){
            window.location='../index.html';
        
        }
       </script>";
        die();
    }
    
    $privilegios=$_SESSION['privilegios'];
    $acceso_reg="";
    $acceso_elim="";
    $acceso_actua="";
    $acceso_cons="";

    if(strcmp($privilegios,"administrador")==0){
        
    }else if(strcmp($privilegios,"usuario-cap")==0){
        $acceso_elim="disabled";
        $acceso_cons="";
        
    }else{
        $acceso_reg="disabled";
        $acceso_elim="disabled";
        $acceso_actua="disabled";
        
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piezas</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">

    <script src="https://kit.fontawesome.com/eefb3f6366.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <main class="contenedor">
     <input type="checkbox" name="" id="check" checked>

    <header class="site-header">
        
        <div class="site-elements">

            <div class="header-left">
                <label for="check"><i class="fas fa-bars" id="sidebar_btn"></i></label>
                <a href="home.php?op=0"><h1>IGNITION<span> PC</span></h1></a>
            </div>

            <div class="header-right">
               <a href="funciones/closeSession.php">
                    <button>REGRESAR</button>
                </a>
                <a href="funciones/closeSession.php">
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
        <a href="productos.php?op=1"><i class="fas fa-shopping-cart"></i><span>Productos</span></a>
        <a href="modelo.php?op=1"><i class="fas fa-shopping-cart"></i><span>Modelo</span></a>
        <a href="arquitecturas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Arquitecura</span></a>
        <a href="ventas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Venta</span></a>
        <a href="empleados.php?op=1"><i class="fas fa-shopping-cart"></i><span>Empleado</span></a>
        <a href="clientes.php?op=1"><i class="fas fa-shopping-cart"></i><span>Cliente</span></a>
        
    </div>

       
   <form action="enviar.php" method="post" class="registrar-mode">
       
        
       <div class="formulario">
           <h2>REGISTRAR PIEZAS</h2>
           <input class="entrada" type="text" id="id" name="id" placeholder="Ingresa el ID de la pieza" required>
           <select name="tipo" id="tipo" class="entrada" required>
                <option value="" selected disabled>Tipo de pieza</option>
                <option value="Venta">Venta</option>
                <option value="Ensamblado">Ensamblado</option>
            </select>
           
           <input class="entrada" type="text" id="descripción" name="descripcion" placeholder="Ingresa la descripción de la pieza" required>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
   </form>
    
    <form action="enviar.php" method="post" class="eliminar-mode">
       <div class="formulario">
           <h2>ELIMINAR PIEZAS</h2>
            <select name="id" id="id" class="entrada">
                <option value="" selected disabled>Piezas disponibles</option>
                
            </select>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
      
     
   </form>
    <form action="enviar.php" method="post" class="actualizar-mode">
       <div class="formulario">
           <h2>ACTUALIZAR PIEZAS</h2>
            <select name="id" id="id" class="entrada">
                <option value="" selected disabled>Piezas disponibles</option>
                
            </select>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
      
     
   </form>
 <form action="enviar.php" method="post" class="consultar-mode">
       <div class="formulario">
           <h2>CONSULTAR PIEZAS</h2>
            <select name="id" id="id" class="entrada">
                <option value="" selected disabled>Piezas disponibles</option>
                
            </select>
          
           
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn">
           <input id="borrar" type="reset" value="BORRAR" class="btn">  
           
       </div>
      
     
   </form>
    
    
     <div class="radios">
             <img class="entrada" type="radio" id="radio-1" name="radio" this.onclick=null  src="../imagenes/next.png">
             <label for="radio-1"></label>
         </div>
    </main>
       
       
        
        
    
    <script src="../javascript/opciones.js"></script>
</body>
</html>