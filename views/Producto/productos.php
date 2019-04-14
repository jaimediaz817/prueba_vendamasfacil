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

    <body>

        <main>
            <header>            
                <nav class="navbar navbar-expand-lg navbar-light bg-light">                    
                    <a class="navbar-brand" href="#">Productos | Tienda virtual</a>
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
                            <a class="" href="<?php echo SINGLE_URL; ?>Dashboard/index">Dashboard (principal)</a>
                        </li>
                        <li>
                            <a class="" href="<?php echo SINGLE_URL; ?>Dashboard/categorias">Categorías (Producto)</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo SINGLE_URL; ?>Producto/index">Productos (gestión)</a>
                        </li>
                    </ul>
                </div>
                <!-- /#sidebar-wrapper -->

                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1>VENDA + FACIL - PRODUCTOS <?php echo $x = round(407736.016)/1000*1000; echo "<br>"; echo round($x, -3); //imprime900 ?></h1>

                                <div class="container mx-0 px-0">
                                    <div class="row">
                                        <div class="col-5">

                                            <div class="card">
                                                <h5 class="card-header">Nuevo Producto</h5>
                                                <div class="card-body">
                                                    <form class="form" id="formProduct">

                                                        <!-- NOMBRES -->
                                                        <div class="form-group">
                                                            <label for="categoryName">Nombre:</label>
                                                            <input type="text" name="nombres" id="nombres" class="form-control refRequerido" required>
                                                            <div class="invalid-feedback">
                                                                Debe escribir un nombre de producto
                                                            </div>
                                                        </div>

                                                        <!-- DESCRIPCIÓN -->
                                                        <div class="form-group">
                                                            <label for="categoryName">Descripción:</label>
                                                            <input type="text" name="descripcion" id="descripcion" class="form-control refRequerido">
                                                            <div class="invalid-feedback">
                                                                Debe escribir una descripción breve del producto
                                                            </div>
                                                        </div>

                                                        <!-- CATEGORIAS -->
                                                        <div class="form-group">
                                                            <label for="categoriasProducto">Category:</label>
                                                            <?php if(empty($this->categoriaList)) :?>
                                                                <div>No categories!</div>
                                                            <?php else: ?>
                                                                <select class="selectpicker form-control" id="categoriasProducto">
                                                                    <option value="0" selected>Seleccione una categoria</option>
                                                                    <?php foreach($this->categoriaList as $val) :?>                                                                
                                                                        <option value="<?= $val->cate_id_pk ?>"><?= $val->cate_nombres ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-6">
                                                                <!-- Peso -->
                                                                <div class="form-group">
                                                                    <label for="peso">Peso:</label>
                                                                    <input type="number" name="peso" id="peso" class="form-control refRequerido">
                                                                    <div class="invalid-feedback">
                                                                        Debe ingresar un peso mínimo del producto y que NO sea un valor negativo
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <!-- Cantidad -->
                                                                <div class="form-group">
                                                                    <label for="cantidad">Cantidad:</label>
                                                                    <input type="number" name="cantidad" id="cantidad" class="form-control refRequerido">
                                                                    <div class="invalid-feedback">
                                                                        Debe ingrar la cantidad de productos
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-6">
                                                                <!-- Precio -->
                                                                <div class="form-group">
                                                                    <i class="fas fa-dollar-sign"></i>
                                                                    <label for="precio">Precio:</label>
                                                                    <input type="number" name="precio" id="precio" class="form-control refRequerido">
                                                                    <div class="invalid-feedback">
                                                                        Debe ingresar un precio mínimo del producto en Dolares (USD)
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <!-- Tipo publicación -->
                                                                <div class="form-group">
                                                                    <label for="tipoPublicacion">Tipo de publicación:</label>
                                                                    <select class="selectpicker form-control" id="tipoPublicacion">
                                                                        <option selected value="0">Seleccione un tipo de publicación</option>
                                                                        <option value="01">Básica</option>
                                                                        <option value="02">Premium</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <a href="#" class="btn btn-primary" id="saveProduct">Guardar Producto</a>
                                                            <a href="#" class="btn btn-success" id="editProduct">Editar Producto</a>
                                                        </div>
                                                    </form>
                                                    <div class="alert alert-success d-none" role="alert">
                                                        El producto se ha guardado correctamente
                                                    </div>
                                                    <div class="alert alert-warning d-none" role="alert">                               
                                                        Ingrese un nombre de Producto
                                                    </div>                                                
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-7">
                                        <?php if(empty($this->productoList)) :?>
                                            <div>No hay productos creados en la base de datos</div>
                                        <?php else: ?>
                                            <table class="table table-dark">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">id</th>
                                                        <th scope="col">Nombre</th>
                                                        <th scope="col">Precio</th>
                                                        <th scope="col">Categoría</th>                                                        
                                                        <th scope="col">acciones</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($this->productoList as $val) :?>
                                                        <?php if($val->prod_estado != 0): ?>
                                                        <tr>
                                                            <td><?= $val->prod_id_pk ?></td>
                                                            <td><?= $val->prod_nombres ?></td>
                                                            <td><span>$ </span><?= $val->prod_precio_usd ?> <span class="small" style="color: #dc3545;"> USD</span></td>
                                                            <td><?= $val->nombreCategoria ?></td> 
                                                            <td>
                                                                <a href="#" data-id="<?= $val->prod_id_pk;?>" class=" btn btn-success edit-product tipo-small">Editar</a>
                                                                <a href="#" data-id="<?= $val->prod_id_pk;?>" class="btn btn-danger delete-product tipo-small">Eliminar/Finalizar</a>
                                                                <?php if($val->prod_estado_publicacion == 0): ?>
                                                                    <a href="#" data-id="<?= $val->prod_id_pk;?>" class="btn btn-primary activar-producto tipo-small">
                                                                    <i class="fas fa-eye"></i> publicar
                                                                    </a>
                                                                <?php elseif($val->prod_estado_publicacion == 1): ?>
                                                                    <a href="#" data-id="<?= $val->prod_id_pk;?>" class="btn btn-warning pausar-producto tipo-small">
                                                                    <i class="fas fa-eye-slash"></i> Pusar</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" id="idProd" value="<?= $val->prod_id_pk; ?>">
                                                                <input type="hidden" id="nombreProd" value="<?= $val->prod_nombres; ?>">
                                                                <input type="hidden" id="descripcionProd" value="<?= $val->prod_descripcion; ?>">
                                                                <input type="hidden" id="categoriaProd" value="<?= $val->cate_id_fk; ?>">
                                                                <input type="hidden" id="pesoProd" value="<?= $val->prod_peso; ?>">
                                                                <input type="hidden" id="cantidadProd" value="<?= $val->prod_cantidad; ?>">
                                                                <input type="hidden" id="precioProd" value="<?= $val->prod_precio_usd; ?>">
                                                                <input type="hidden" id="tipoPublicacionProd" value="<?= $val->prod_tipo_publicacion; ?>">
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php endif; ?>
                                        </div>
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

        </main>    
        
        <!-- Mecanismo para saber la url base -->
        <input id="urlSelector" type="hidden" name="url" value="<?php echo SINGLE_URL; ?>">

        <!-- Scripts -->
        <script src="<?php echo ASSET_URL ?>js/libraries/jquery-plugins/jquery-3.2.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>        

        <!-- CUSTOM -->
        <input id="urlSelector" type="hidden" name="url" value="<?php echo SINGLE_URL; ?>">
        <script src="<?php echo ASSET_URL ?>js/Producto/productoController.js">
            var URL_SINGLE = <?php echo SINGLE_URL ?>;
        </script>
    </body>
</html>