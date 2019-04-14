<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo $this->title; ?></title>

        <!-- <base href="views/"> -->

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

        <!-- Estilos propios -->
        <link rel="stylesheet" href="<?php echo ASSET_URL ?>styles/styles.css">
    </head>

    <body class="index-dashboard">

        <main>
            <header>            
                <nav class="navbar navbar-expand-lg navbar-light bg-light">                    
                    <a class="navbar-brand" href="#">Dashboard | Tienda virtual</a>

                    <?php if (isset($_SESSION['nickUser'])): ?>
                        <?= "Bienvenido: ".$_SESSION['nickUser']; ?>
                    <?php endif; ?>

                    <a href="<?php echo SINGLE_URL; ?>Login/signOutLogin" class="btn btn-secondary">&nbsp;Logout (salir de la plataforma)</a>
                    <!-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalLogin">
                        <i class="icon-plus"></i>&nbsp;Logout (salir de la plataforma)
                    </button> -->
                </nav>                
            </header>

            <div id="wrapper">

                <!-- Sidebar -->
                <div id="sidebar-wrapper">
                    <ul class="sidebar-nav">
                        <li class="sidebar-brand">
                            <a href="<?php echo SINGLE_URL; ?>Login/signOutLogin">Cerrar sesión</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo SINGLE_URL; ?>Dashboard/index">Dashboard (principal)</a>
                        </li>
                        <li>
                            <a class="" href="<?php echo SINGLE_URL; ?>Dashboard/categorias">Categorías (Producto)</a>
                        </li>
                        <li>
                            <a class="" href="<?php echo SINGLE_URL; ?>Producto/index">Productos (gestión)</a>
                        </li>
                    </ul>
                </div>
                <!-- /#sidebar-wrapper -->

                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">

                            <!-- GRAFICA -->
                            <div class="col-12">
                                <h2 class="h2">Gráfico de barras | Publicaciones individuales de productos por días de la semana</h2>
                                <div class="chart-container">
                                    <canvas id="publicacionesDia" width="600" height="400" class="grafico-barras"></canvas>
                                </div>                                
                            </div>
                            <hr class="hr">
                            <div class="col-lg-12 mt-2">
                                <h1 class="h2">VENDA + FACIL - Listado de productos en la tienda (Gestionar) <?php //echo $this->test; ?></h1>
                                <p>Crud of Categories</p>
                                <div class="container mx-0 px-0">
                                    <div class="row">

                                        <!-- Recorrer los productos que están publicados -->
                                        <!-- programación defensiva para cuando NO hayan productos -->
                                        <?php if(empty($this->productosList)) :?>
                                            <div>No hay productos creados en la base de datos</div>
                                        <?php else: ?>
                                            <?php foreach($this->productosList as $prod) :?>
                                                <?php if($prod->prod_estado == 1): ?>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mt-4 mb-4">
                                                        <div class="card shadow bg-light">
                                                            <div class="card-body">
                                                                <h5 class="card-title">Nombre: <?= $prod->prod_nombres?></h5>
                                                                <p class="card-text"><?= $prod->prod_descripcion?></p>
                                                                <p>Categoría: <?= $prod->nombreCategoria?></p>
                                                                <p>Precio:  $ <span class="badge badge-success"><?= number_format($prod->prod_precio_publicacion, 0, '', '.'); ?>  COP</span></p>

                                                                <?php if($prod->prod_estado_publicacion == 1) :?>                                                                
                                                                    <a href="#" data-id="<?= $prod->prod_id_pk;?>" class="btn btn-warning pausar-producto">
                                                                        <i class="fas fa-eye-slash"></i> Pusar
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if($prod->prod_estado_publicacion == 0): ?>
                                                                    <a href="#" data-id="<?= $prod->prod_id_pk;?>" class="btn btn-primary activar-producto">
                                                                        <i class="fas fa-eye"></i> publicar
                                                                    </a>
                                                                <?php endif; ?>
                                                                
                                                                <a href="#" class="btn btn-danger">Finalizar</a>                                                                
                                                                <!-- Ocultos -->
                                                                <input type="hidden" id="idProd" value="<?= $prod->prod_id_pk; ?>">
                                                                <input type="hidden" id="pesoProd" value="<?= $prod->prod_peso; ?>">
                                                                <input type="hidden" id="precioProd" value="<?= $prod->prod_precio_usd; ?>">
                                                                <input type="hidden" id="tipoPublicacion" value="<?= $prod->prod_tipo_publicacion; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /#page-content-wrapper -->
            </div>
            <!-- /#wrapper -->


            <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Iniciar sesión en la tienda virtual</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre de usuario (Login)</label>
                                    <div class="col-md-9">
                                        <input type="text" id="login" name="login" class="form-control" placeholder="Ingrese el nombre de usuario">
                                        <span class="help-block">(*) Ingrese el nombre de la categoría</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Escriba su contraseña">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="btnInicioSesion">Iniciar sesión</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </main>    
        
        <!-- Mecanismo para saber la url base -->
        <input id="urlSelector" type="hidden" name="url" value="<?php echo SINGLE_URL; ?>">

        <!-- Scripts -->
        <script src="<?php echo ASSET_URL ?>js/libraries/jquery-plugins/jquery-3.2.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>        

        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>

        <!-- CUSTOM -->
        <input id="urlSelector" type="hidden" name="url" value="<?php echo SINGLE_URL; ?>">
        <script src="<?php echo ASSET_URL ?>js/Dashboard/dashboardController.js">
            var URL_SINGLE = <?php echo SINGLE_URL ?>;
        </script>
    </body>
</html>