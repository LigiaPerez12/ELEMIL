<?php
session_start();
include_once "admin/db.ventas.php";
$con = mysqli_connect($host, $user, $pass, $db);

$queryRecibe = "SELECT nombre,email,direccion 
from recibe 
where idCli='" . $_SESSION['idCliente'] . "';";
$resRecibe = mysqli_query($con, $queryRecibe);
$rowRecibe = mysqli_fetch_assoc($resRecibe);

$queryCli = "SELECT nombre,email,direccion 
from clientes 
where id='" . $_SESSION['idCliente'] . "';";
$resCli = mysqli_query($con, $queryCli);
$rowCli = mysqli_fetch_assoc($resCli);

$idVenta = mysqli_real_escape_string($con, $_REQUEST['idVenta'] ?? '');
$queryVenta = "SELECT v.id,v.fecha
FROM ventas AS v
WHERE v.id = '$idVenta';";
$resVenta = mysqli_query($con, $queryVenta);
$rowVenta = mysqli_fetch_assoc($resVenta);
?>
<?php ob_start(); ?>
<body>
<div>
<h1 class="mb-4">ELEMIL-WATER</h1>
<h3 class="mb-4">LLEGAMOS HASTA DONDE TU ESTES CON NUESTRO PRODUCTO</h3>   
</div>
    <div class="container">
            <table style="width: 750px;margin-top: 20px;">
    <thead>
      
    </thead>
    <tbody>
        <tr>
            <td>
                <strong>Cliente</strong>
                <br>
                <strong>Nombre:</strong><?php echo $rowCli['nombre'] ?><br>
                <strong>Email:</strong><?php echo $rowCli['email'] ?><br>
                <strong>Dirección:</strong><?php echo $rowCli['direccion'] ?><br>
            </td>
            <td>
                <strong>Recibe</strong>
                <br>
                <strong>Nombre:</strong><?php echo $rowRecibe['nombre'] ?><br>
                <strong>Email:</strong><?php echo $rowRecibe['email'] ?><br>
                <strong>Dirección:</strong><?php echo $rowRecibe['direccion'] ?><br>
            </td>
            <td>
                <strong>Datos de la factura</strong>
                <br>
                <strong>Factura: 00000000</strong><?php echo $rowVenta['id'] ?><br>
                <strong>Fecha de Venta:</strong><?php echo $rowVenta['fecha'] ?><br>
            </td>
        </tr>
    </tbody>
    <br>
    <br>
            </table>
            <table style="width: 750px;margin-top: 30px;">
    <thead>
        <tr>
        </tr>
    </thead>
    <tbody>
        <?php
        $queryDetalle = "SELECT
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
        $resDetalle = mysqli_query($con, $queryDetalle);
        $total = 0;
        while ($row = mysqli_fetch_assoc($resDetalle)) {
            $total = $total + $row['subTotal'];
        ?>
            <tr>
                <td>
                    <strong>Nombre del Producto</strong>
                    <br>
                    <?php echo $row['nombre'] ?>
                </td>
                <td>
                    <strong>Cantidad</strong>
                    <br>
                    <?php echo $row['cantidad'] ?>
                </td>
                <td>
                    <strong>Precio Unitario</strong>
                    <br>
                
                    <?php echo "$".floatval($row['precio']); ?>
                    
                </td>
                <td>
                    <strong>Sub Total</strong>
                    <br>
                    
                    <?php echo "$".floatval($row['subTotal']); ?>
                    
                    </td>
            </tr>
            <br>
        <?php
        }
        ?>
        <tr>
            <td colspan="3" class="text-right"  style="text-align: right;">Total:</td>
            <td><?php echo "$".floatval($total); ?></td>
        </tr>

        </tbody>
            </table>
</div>
        <br>
        <br>
        <br>
        <div class="container-fluid pt-5">
            <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5"><span class="px-2">GRACIAS POR PREFERIRNOS</span></p>
                <h1 class="mb-4">Tus comprás llegaran dentro de 48 horas al punto indicado</h1>
            </div>
            </div>
        </div> 
</body>


<?php $html= ob_get_clean(); ?>
<?php
include_once "dompdf/autoload.inc.php";
use Dompdf\Dompdf;
$pdf=new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper("A4","landingscape");
$pdf->render();
$pdf->stream();
?>