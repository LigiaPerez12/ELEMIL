


<?php
    $total=$_REQUEST['total']??'';
    
    include_once "stripe/init.php";
    \Stripe\Stripe::setApiKey("sk_test_51MDzV1FOY5tFKuofp8xaa9TRQdKKVxKVk4bfXOSsrLYxJWZYjUEPUTjdGPCnikJ9rWyhdR6Wy5dmrpkefnyfMoEz00Ko4y8xnW");
    $toke=$_POST['stripeToken'];
    $charge=\Stripe\Charge::create([
        'amount'=>$total,
        'currency'=>'usd',
        'description'=>'Pago de ecommerce',
        'source'=>$toke
    ]);
    if($charge['captured']){
        $queryVenta="INSERT INTO ventas 
        (idCli                       ,idPago             ,fecha) values
        ('".$_SESSION['idCliente']."','".$charge['id']."',now());
        ";
        $resVenta=mysqli_query($con,$queryVenta);
        $id=mysqli_insert_id($con);
        
        /*
        if($resVenta){
            echo "La venta fue exitosa con el id=".$id;
        }
        */
        $insertaDetalle="";
        $cantProd=count($_REQUEST['id']);
        for($i=0;$i<$cantProd;$i++){
            $subTotal=$_REQUEST['precio'][$i]*$_REQUEST['cantidad'][$i];
            $insertaDetalle=$insertaDetalle."('".$_REQUEST['id'][$i]."','$id','".$_REQUEST['cantidad'][$i]."','".$_REQUEST['precio'][$i]."','$subTotal'),";
        }
        $insertaDetalle=rtrim($insertaDetalle,",");
        $queryDetalle="INSERT INTO detalleVentas 
        (idProd, idVenta, cantidad, precio, subTotal) values 
        $insertaDetalle;";
        var_dump($queryDetalle);
        $resDetalle=mysqli_query($con,$queryDetalle);
        if($resVenta && $resDetalle){
        ?>
        <div class="container">
        <br>
        <div class="container-fluid pt-5">
            <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5"><span class="px-2">ELEMIL-WATER</span></p>
                <h1 class="mb-4">Tús compras son:</h1>
            </div>
            </div>
        </div>  
        <br> 

        <div class="row">
            <div class="col-6">
                <?php muestraRecibe($id); ?>
            </div>
            <div class="col-6">
                <?php muestraDetalle($id); ?>
            </div>
        </div>

        <div class="container-fluid pt-5">
            <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5"><span class="px-2">GRACIAS POR PREFERIRNOS</span></p>
                <h1 class="mb-4">Tus comprás llegaran dentro de 48 horas al punto indicado</h1>
            </div>
            </div>
        </div> 
        </div>
        <?php
        borrarCarrito();
        }
    }
    function borrarCarrito(){
        ?>
            <script>
                $.ajax({
                    type: "post",
                    url: "ajax/borrarCarrito.php",
                    dataType: "json",
                    success: function (response) {
                        $("#badgeProducto").text("");
                        $("#listaCarrito").text("");
                    }
                });
            </script>
        <?php
    }
    function muestraRecibe($idVenta){
    ?>
    
    <div class="container">
        <table class="table">
        <thead>
            <tr>
                <th colspan="3" class="text-center">Persona que recibe</th>
            </tr>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            <?php
                global $con;
                $queryRecibe="SELECT nombre,email,direccion 
                from recibe 
                where idCli='".$_SESSION['idCliente']."';";
                $resRecibe=mysqli_query($con,$queryRecibe);
                $row=mysqli_fetch_assoc($resRecibe);
            ?>
            <tr>
                <td><?php echo $row['nombre'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['direccion'] ?></td>
            </tr>
        </tbody>
        </table>
    </div>
    <?php
    }
    function muestraDetalle($idVenta){
        var_dump($idVenta);
        ?>
        <div class="container">
            <table class="table">
            <thead>
                <tr>
                    <th colspan="3" class="text-center">Detalle de venta</th>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>SubTotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    global $con;
                    $queryDetalle="SELECT
                    p.nombre,
                    dv.cantidad,
                    dv.precio,
                    dv.subTotal
                    FROM
                    ventas AS v
                    INNER JOIN detalleVentas AS dv ON dv.idVenta = v.id
                    INNER JOIN productos AS p ON p.id = dv.idProd
                    WHERE
                    v.id = '$idVenta'";
                    $resDetalle=mysqli_query($con,$queryDetalle);
                    $total=0;
                    while($row=mysqli_fetch_assoc($resDetalle)){
                        $total=$total+$row['subTotal'];
                ?>
                <tr>
                    <td><?php echo $row['nombre'] ?></td>
                    <td><?php echo $row['cantidad'] ?></td>
                    <td><?php echo $row['precio'] ?></td>
                    <td><?php echo $row['subTotal'] ?></td>
                </tr>
                <?php
                    }
                ?>
                <tr>
                    <td colspan="3" class="text-right">Total:</td>
                    <td><?php echo $total; ?></td>
                </tr>

            </tbody>
            </table>
             <a class="btn btn-secondary float-right" target="_blank" href="imprimirFactura.php?idVenta=<?php echo $idVenta; ?>" role="button">Imprimir nota de venta <i class="fas fa-file-pdf"></i> </a>
        </div>
        <?php
        }
    
?>