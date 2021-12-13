
<?php
    
    session_start();
    $usuario=$_SESSION['user'];
    $pass=$_SESSION['password'];
    $_SESSION['pagina']="proveedor";
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
    <title>Proveedores</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/normalize.css">
    <link rel="stylesheet" href="../estilos/home.css">
    <link rel="stylesheet" href="../estilos/estilosfondos/fondoproveedores.css">
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
        <a href="catalogo_piezas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Catálogo de Piezas</span></a>
        <a href="productos.php?op=1"><i class="fas fa-shopping-cart"></i><span>Productos</span></a>
        <a href="modelo.php?op=1"><i class="fas fa-shopping-cart"></i><span>Modelo</span></a>
        <a href="arquitecturas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Arquitectura</span></a>
        <a href="ventas.php?op=1"><i class="fas fa-shopping-cart"></i><span>Venta</span></a>
        <a href="empleados.php?op=1"><i class="fas fa-shopping-cart"></i><span>Empleado</span></a>
        <a href="clientes.php?op=1"><i class="fas fa-shopping-cart"></i><span>Cliente</span></a>
        
    </div>

       

   <form action="../mysql/insertar.php" method="post" class="registrar-mode" >

   <!--<form action="../mysql/inserciones/enviarProveedores.php" method="post" class="registrar-mode" >-->

          <div class="formulario" >
           <h2>REGISTRAR PROVEEDORES</h2>

         
               <input class="entrada" type="text" id="rfc" name="rfc" placeholder="Ingresa el RFC de la empresa" required <?php echo $acceso_reg; ?>>
               <input class="entrada" type="text" id="empresa" name="empresa" placeholder="Ingresa el nombre de la empresa" required <?php echo $acceso_reg; ?>>
               <input class="entrada" type="text" id="nproveedor" name="nproveedor" placeholder="Ingresa el nombre del proveedor" required <?php echo $acceso_reg; ?>>
               <input class="entrada" type="text" id="descripción" name="descripcion" placeholder="Ingresa la descripción de la empresa" required <?php echo $acceso_reg; ?>>

               <input class="entrada" type="text" id="telefono" name="telefono" placeholder="Ingresa tu numero telefonico" required <?php echo $acceso_reg; ?>>
               <input class="entrada" type="text" id="correo" name="correo" placeholder="Ingresa el correo" required <?php echo $acceso_reg; ?>>
    
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" <?php echo $acceso_reg; ?>>
           <input id="borrar" type="reset" value="BORRAR" class="btn" <?php echo $acceso_reg; ?>>  
           
       </div>


   </form>
    
    <form action="../mysql/eliminar.php" method="post" class="eliminar-mode">
       <div class="formulario">
           <h2>ELIMINAR PROVEEDORES</h2>

            <select name="id-elim" id="elim-dis" class="entrada-1" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Proveedores disponibles</option>
                <?php 
                    $op="SELECT * FROM proveedores";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['RFC'];
                        if($row['estatus']){
                            echo "<option value='".$i."' >"."*RFC: ".$row['RFC']."  *EMPRESA: ".$row['empresa']."</option>";
                        }
                        
                    }
                    mysqli_close($conexion);
                ?>
            </select>

            <select name="tipo-elim" id="eliminaciones" class="entrada-1" required <?php echo $acceso_elim ;?>>

                <option value="" selected disabled>Selecciona tipo de eliminacion</option>
                <option value="unico" id="unico">Solo un registro</option>
                <option value="todo" >Eliminar todos los registros</option>
            </select>

       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" <?php echo $acceso_elim ;?>>
           <input id="borrar" type="reset" value="BORRAR" class="btn" <?php echo $acceso_elim ;?>>  
           
       </div>
      
   </form>
    <form action="../cambiosPaginas/cam_proveedores.php" method="post" class="actualizar-mode">
       
       <div class="formulario">
           <h2>ACTUALIZAR PROVEEDORES</h2>

            <select name="rfc" id="id" class="entrada" required <?php echo $acceso_actua ;?>>

                <option value="" selected disabled>Proveedores disponibles</option>
                <?php 
                    $op="SELECT * FROM proveedores";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['RFC'];
                        echo "<option value='".$i."' >"."RFC: ".$row['RFC']."  Empresa: ".$row['empresa']."</option>";
                        
                        
                    }
                    mysqli_close($conexion);
                ?>
            </select>
       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" <?php echo $acceso_actua ;?>>
           <input id="borrar" type="reset" value="BORRAR" class="btn" <?php echo $acceso_actua ;?>>  
           
       </div>
      
    
   </form>
 <form action="../consultas/proveedor.php" method="post" class="consultar-mode">
       
       <div class="formulario">
           <h2>CONSULTAR PROVEEDORES</h2>
             <select name="tipo-cons" id="consultas" class="entrada" required <?php echo $acceso_cons ;?>>

                <option value="" selected disabled>Selecciona tipo de consulta</option>
                <option value="unico" id="unico">Solo un registro</option>
                <option value="todo" >Consultar todos los registros</option>
            </select>
            <select name="id" id="disponibles" class="remove" required <?php echo $acceso_cons ;?>>

                <option value="" selected disabled>Proveedores disponibles</option>
                <?php 
                    $op="SELECT * FROM proveedores";
                    $conexion=mysqli_connect("localhost",$usuario,$pass,"inventarios");
                    $resultado=mysqli_query($conexion,$op);
                  
                    
                    while($row=mysqli_fetch_array($resultado)){
                        $i=$row['RFC'];
                             echo "<option value='".$i."' >"."*RFC: ".$row['RFC']."  *EMPRESA: ".$row['empresa']."</option>";
                        
                        
                    }
                    mysqli_close($conexion);
                ?>
            </select>
 
           

       </div>

       <div class="botones">
           <input id="enviar" type="submit" value="Enviar" class="btn" <?php echo $acceso_cons ;?>>
           <input id="borrar" type="reset" value="BORRAR" class="btn" <?php echo $acceso_cons ;?>>  
           
       </div>
    
   </form>
  <!---->
    
    
     <div class="radios">
             <img class="entrada" type="radio" id="radio-1" name="radio" this.onclick=null  src="../imagenes/next.png">
             <label for="radio-1"></label>
         </div>
    </main>
       
    
    <script src="../javascript/opciones.js"></script>
</body>
</html>