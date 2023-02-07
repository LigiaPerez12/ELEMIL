<?php
$id = mysqli_real_escape_string($con, $_REQUEST['id'] ?? '');
$queryProducto = "SELECT id,nombre,precio,existencia FROM productos where id='$id';  ";
$resProducto = mysqli_query($con, $queryProducto);
$rowProducto = mysqli_fetch_assoc($resProducto);
?>
<!-- Default box -->
<br>
<div class="container">
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none"><?php echo $rowProducto['nombre'] ?></h3>
                    <?php
                $queryImagenes = "SELECT 
                f.web_path
                FROM
                productos AS p
                INNER JOIN productos_files AS pf ON pf.producto_id=p.id
                INNER JOIN files AS f ON f.id=pf.file_id
                WHERE p.id='$id';
                ";
                $resPrimerImagen = mysqli_query($con, $queryImagenes);
                $rowPrimerImaen=mysqli_fetch_assoc($resPrimerImagen);
                ?>
                    <div class="col-12">
                        <img src="<?php echo $rowPrimerImaen['web_path'] ?>" width = "200" height = "300">
                    </div>
                    <div class="col-12 product-image-thumbs">
                        <?php
                    $resImagenes = mysqli_query($con, $queryImagenes);
                    while ($rowImagenes = mysqli_fetch_assoc($resImagenes)) {
                    ?>

                        <div class="product-image-thumb"><img src="<?php echo $rowImagenes['web_path'] ?>"></div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3"><?php echo $rowProducto['nombre'] ?></h3>
                    <p>El agua es uno de los elementos más valiosos que tenemos en nuestro planeta, pues no solo otorga
                        vida a las plantas, sino que es fuente vital para nosotros mismos. La vida no es posible sin
                        agua.</p>

                    <hr>
                    <h4>Existencias: <?php echo $rowProducto['existencia'] ?></h4>



                    <div class="bg-gray py-2 px-3 mt-4">
                        <h2 class="mb-0">
                            $: <?php echo floatval($rowProducto['precio'])  ?>
                        </h2>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary btn-lg btn-flat" id="agregarCarrito"
                            data-id="<?php echo $_REQUEST['id'] ?>" data-nombre="<?php echo $rowProducto['nombre'] ?>"
                            data-web_path="<?php echo $rowPrimerImaen['web_path'] ?>"
                            data-precio="<?php echo $rowProducto['precio'] ?>">
                            <i class="fas fa-cart-plus fa-lg mr-2"></i>
                            Añadir al carrito
                        </button>
                    </div>
                    <div class="mt-4">
                        Cantidad
                        <input type="number" class="form-control" id="cantidadProducto" value="1">
                    </div>

                    <div class="mt-4 product-share">
                        <a href="#" class="text-gray">
                            <i class="fab fa-facebook-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fab fa-twitter-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fas fa-envelope-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fas fa-rss-square fa-2x"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- /. -->
    </div>
</div>
<!-- /.card -->