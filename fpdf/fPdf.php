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


    require('../fpdfFuente/fpdf.php');
    class MyPdf extends  FPDF{
        
        private $fuente='Arial';
        function titulo($title){
            
            $this->SetTextColor(100, 149, 237);
            $this->setFont($this->fuente,'B',24);
            $this->Cell(0,10,utf8_decode($title),0,1,'C');
            
            
            
            
        }
        function texto($text,$alinear){
            $this->SetTextColor(51,51,51);
            $this->setFont($this->fuente,'I',16);
            $this->MultiCell(0,7,utf8_decode($text),0,$alinear);
            
            
        }
        function saltoLinea(){
            
            $this->Ln();
            
        }
        
    }

    $conexion=mysqli_connect('localhost','root','','inventarios');
    $op="SELECT MAX(id) AS id FROM venta";
    $ultimo_id=mysqli_query($conexion,$op);
    $row=mysqli_fetch_array($ultimo_id);
    $ultimo_id=$row['id'];
    
    $op="SELECT *,c.nombre 'nombre_cliente',v.id 'id_venta' FROM venta v JOIN cliente c ON v.RFC_cliente=c.RFC JOIN empleado e ON e.id=v.id_empleado WHERE v.id='$ultimo_id'";
    $resultado=mysqli_query($conexion,$op);
    $row=mysqli_fetch_array($resultado);
    $id_venta=$row['id_venta'];
    $mensaje="Venta numero ".$row['id_venta']." a ".str_replace('-','/',date('d M Y',strtotime($row['fecha'])));
    
    $pdf=new MyPdf();
    $pdf->AddPage();
    $pdf->Image('../imagenes/logo_ignition.png',$pdf->GetX()+10,$pdf->GetY()-4,45);
    $pdf->Image('../imagenes/logo_ignition.png',$pdf->GetX()+140,$pdf->GetY()-4,45);
    $pdf->titulo("IGNITION PC");
    $pdf->saltoLinea();
    $pdf->texto($mensaje,'C');
    $pdf->texto("Cliente: ".$row['nombre_cliente']." RFC: ".$row['RFC']."        Vendedor: ".$row['nombre']." Id: ".$row['id'],'J');
    
    $pdf->saltoLinea();
    $op="SELECT * FROM venta_pieza vp JOIN pieza_venta pv ON vp.id_pieza=pv.id JOIN pieza p ON p.id=pv.id WHERE vp.id_venta='$id_venta'";    
    $pdf->texto("Articulos que se compraron:                                 precio",'J');
    $pdf->saltoLinea();
    $resultado=mysqli_query($conexion,$op);
    while($row2=mysqli_fetch_array($resultado)){
        $pdf->texto($row2['nombre']." ".$row2['modelo']."                                                  $".$row2['precio_publico'],'J');
       
        
    }
    
     $op="SELECT * FROM venta_producto vp JOIN producto p ON vp.no_serie=p.no_serie WHERE vp.id_venta='$id_venta'";    
    $resultado=mysqli_query($conexion,$op);
    while($row2=mysqli_fetch_array($resultado)){
        $pdf->texto("Computadora ".$row2['nombre_modelo']."                                                $".$row2['costo'],'J');
       
        
    }
     $pdf->saltoLinea(); 
     $pdf->texto("Total a pagar: $".$row['total'],'J');
    $pdf->titulo("¡GRACIAS POR SU COMPRA!");
   

    $pdf->Output();

    mysqli_close($conexion);
?>