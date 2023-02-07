<?php
include_once "db.ventas.php";
$con = mysqli_connect($host, $user, $pass, $db);

  ?>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

<!-- Content Header (Page header) -->

<section class="content-header">

    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">

                <h1>VENTAS REALIZADAS</h1>

            </div>

        </div>

    </div><!-- /.container-fluid -->

</section>

<!-- Main content -->

<section class="content">

    <div class="row">

        <div class="col-12">

            <div class="card">

                <!-- /.card-header -->

                <div class="card-body">

                    <table id="example2" class="display responsive nowrap">

                        <thead>

                            <tr>
                                <th>Factura</th>    
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>                                              

                            </tr>

                        </thead>

                        <tbody>

                            <?php
                             
                              $query = "SELECT  idVenta, cantidad, precio,subtotal
                              FROM detalleventas "; 

                              $res = mysqli_query($con, $query);

                              while ($row = mysqli_fetch_assoc($res)) {

                              ?>
                                <tr>
                                <td><?php echo $row['idVenta'] ?></td>
                                <td><?php echo $row['cantidad'] ?></td>
                                <td><?php echo $row['precio'] ?></td>
                                <td><?php echo $row['subtotal'] ?></td>
                           
                                                       
                                </tr>

                            <?php

                              }

                              ?>

                        </tbody>

                    </table>

                </div>

                <!-- /.card-body -->

            </div>

            <!-- /.card -->




        </div>

        <!-- /.col -->

    </div>

    <!-- /.row -->

</section>

<!-- /.content -->

</div>
