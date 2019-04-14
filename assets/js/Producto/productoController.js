// JS CONTROLLER - CAMALEON MicroFramework

(function ($) {
    // Globals DASHBOARD
    var URL_SINGLE = $("#urlSelector").val();
    console.log("Products works!, " + URL_SINGLE);
    var objEdit = {"id": 0, "name": ""};

    //alert((((9.99 + (12 * 10) + 0.15) * 0.76) + 0.16).toFixed(2))
    //---------------------------------------------------------------------------------

    // UI controls
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    // Product 
    function disabledSaveProduct() {
        $("#saveProduct").addClass('disabled'); // Disables visually
        $("#saveProduct").prop('disabled', true); // Disables visually + functionally
    }
    function enabledSaveProduct() {
        $("#saveProduct").removeClass('disabled'); // Disables visually
        $("#saveProduct").prop('disabled', false); // Disables visually + functionally
    }
    function disabledEditProduct() {
        $("#editProduct").addClass('disabled'); // Disables visually
        $("#editProduct").prop('disabled', true); // Disables visually + functionally
    }
    function enabledEditProduct() {
        $("#editProduct").removeClass('disabled'); // Disables visually
        $("#editProduct").prop('disabled', false); // Disables visually + functionally
    }


    enabledSaveProduct();
    disabledEditProduct();
    let objProductEdit = {"idProduct": 0}

    // Click Save
    $("#saveProduct").on("click", function() {

        if (validarCamposProducto()) {
            let confirmSave = confirm("¿Desea realmente almacenar el producto con estos datos?");
            if (confirmSave) {
                // get data
                let nombres             = $("#nombres").val();
                let descripcion         = $("#descripcion").val();
                let categoriaProducto   = $("#categoriasProducto").val();
                let peso                = $("#peso").val();
                let cantidad            = $("#cantidad").val();
                let precio              = $("#precio").val();
                let tipoPublicacion     = $("#tipoPublicacion").val();
    
                var formData = new FormData($("#formProduct")[0]);
                formData.append('nombres', nombres);
                formData.append('descripcion', descripcion);
                formData.append('categoriaProducto', categoriaProducto);
                formData.append('peso', peso);
                formData.append('cantidad', cantidad);
                formData.append('precio', precio);
                formData.append('tipoPublicacion', tipoPublicacion);
    
                // Request 
                let promiseProduct = $.ajax({
                    url: URL_SINGLE + 'Producto/addProductRequest',
                    type: 'POST',
                    data:  formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,            
                    success: function(response){
                        console.log("response: ", response);
                        if (response.res == 1 || response.res == true) {
                            console.log("add Product ok");
                            alert("El producto se ha guardado correctamente, ahora deberá publicarlo para que se muestre el precio COP en la vista de la tienda...");
                            // refresh
                            location.reload();
                        }
                    },
                    error: function(err) {
                        console.log("err : "+ err);
                    }
                });
    
                promiseProduct.done(function() {
                    console.log("flujo #1")    
                });
    
                console.log("flujo #2")
            } else {
                return false;
            }      
    
        } else {
            //console.log(errores);
        }
    });

    // Valida campos del formulario
    function validarCamposProducto() {
            // get data
            let nombres             = $("#nombres").val();
            let descripcion         = $("#descripcion").val();
            let categoriaProducto   = $("#categoriasProducto").val();
            let peso                = $("#peso").val();
            let cantidad            = $("#cantidad").val();
            let precio              = $("#precio").val();
            let tipoPublicacion     = $("#tipoPublicacion").val();        

        let flagValidaciones = true;

        if ($("#nombres").val() == "") {
            flagValidaciones = false;
            $("#nombres").addClass("is-invalid")
        }
        if ($("#descripcion").val() == "") {
            flagValidaciones = false;
        }
        if ($("#peso").val() == "") {
            flagValidaciones = false;
        }
        if ($("#cantidad").val() == "") {
            flagValidaciones = false;
        }
        if ($("#precio").val() == "") {
            flagValidaciones = false;
        }
        // selects
        if ($("#categoriasProducto").val() == 0) {
            $(this).hasClass("is-invalid")
        } else {
            $(this).hasClass("is-valid")
        }
        if ($("#tipoPublicacion").val() == 0) {
            flagValidaciones = false;
            $(this).hasClass("is-invalid");
            alert("Debe seleccionar el tipo de publicación del producto(BASICO O PREMIUM)");
        } else {
            $(this).hasClass("is-valid")
        }
        // números
        if ($("#peso").val() < 0) {
            flagValidaciones = false;
        }
        if ($("#cantidad").val() < 0) {
            flagValidaciones = false;
        }
        if ($("#precio").val() < 0) {
            flagValidaciones = false;
        }        
        return flagValidaciones;
    }

    // Retorna el TRM actual mediante la API
    async function  getTRMSimple(id, precio, peso, tipoPublicacion) {
        let endpoint  = 'live';
        let keySecret = '89dd481d423f920afcb058422d4e4f72';
        let url       = 'http://apilayer.net/api/'+ endpoint + '?access_key=' + keySecret + '&currencies=COP&source=USD&format=1';
        let trm = 0;

        let peticion = await $.ajax({
            url: url,
            dataType: 'jsonp',
            success: function(json) {
                // exchange rata data is stored in json.quotes
                trm = json.quotes.USDCOP;

                let confirmEdit = confirm("¿Realmente desea publicar en la tienda este producto?")
                if (confirmEdit) {
                    // ajax request
                    var formData = new FormData();
                    formData.append('idProducto', id);
                    formData.append('precioUsd', precio);
                    formData.append('pesoProducto', peso);
                    formData.append('tipoPublicacion', tipoPublicacion);
                    formData.append('valorTrm', trm);
        
                    $.ajax({
                        url: URL_SINGLE + 'Producto/postProductListRequest',
                        type: 'POST',
                        data:  formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,            
                        success: function(response){
                            console.log("response: ", response);
                            if (response.res == true || response.res == 1) {
                                enabledSaveProduct();
                                disabledEditProduct();
                                alert("¡Producto publicado en la tienda (lista)!");
                                showAlert($(".alert alert-success"), true);
                            }
                        },
                        error: function(err) {
                            console.log("err : "+ err);
                        }
                    });
                }                
            }
        });
        return trm;
    }

    $(".refRequerido").blur( function(){
        console.log($(this).val())
        if ($(this).val() == '') {
            $(this).removeClass("is-valid").addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid").addClass("is-valid");
        }
    })
    // jorge.duque@vendamasfacil.com
    

    // Eclit Edit | link table
    $(".edit-product").on("click", function() {
        let id              = $(this).parent().next().find("#idProd").val();
        let nombre          = $(this).parent().next().find("#nombreProd").val();
        let descripcion     = $(this).parent().next().find("#descripcionProd").val();
        let categoriaId     = $(this).parent().next().find("#categoriaProd").val();
        let peso            = $(this).parent().next().find("#pesoProd").val();
        let cantidad        = $(this).parent().next().find("#cantidadProd").val();
        let precio          = $(this).parent().next().find("#precioProd").val();

        let tPublicacion    = $(this).parent().next().find("#tipoPublicacionProd").val();
        console.log("val: " + id + ", "+ nombre + " , "+ categoriaId + " , " + precio);
        // Set category
        $("select#categoriasProducto option").each((i,j)=>{
            if ($(j).val() == categoriaId) {
                $(j).attr("selected", true);
            }
        });
        // Set  tipo publicación
        $("select#tipoPublicacion option").each((i,j)=>{
            if ($(j).val() == tPublicacion) {
                $(j).attr("selected", true);
            }
        });
        // 
        objProductEdit.idProduct = id;
        $("#nombres").val(nombre);
        $("#descripcion").val(descripcion);
        $("#categoriasProducto").val(categoriaId);
        $("#peso").val(peso);
        $("#cantidad").val(cantidad);
        $("#precio").val(precio);
        $("#tipoPublicacion").val(tPublicacion);
        // accionando estado de botones
        disabledSaveProduct();
        enabledEditProduct();
    })

    // Click Edit | Main action
    $("#editProduct").on("click", function() {
        let confirmEdit = confirm("¿Está seguro que desea llevar a cabo la edición del producto?")
        if (confirmEdit) {
            // get data
            let nombre          = $("#nombres").val();
            let descripcion     = $("#descripcion").val();
            let categoriaProd   = $("#categoriasProducto").val();
            let peso            = $("#peso").val();
            let cantidad        = $("#cantidad").val();
            let precio          = $("#precio").val();
            let tPublicacion    = $("#tipoPublicacion").val();
    
            var formData = new FormData($("#formProduct")[0]);
            formData.append('idProduct', objProductEdit.idProduct);
            formData.append('nombres', nombre);
            formData.append('descripcion', descripcion);
            formData.append('categoriaProducto', categoriaProd);
            formData.append('peso', peso);
            formData.append('cantidad', cantidad);
            formData.append('precio', precio);
            formData.append('tipoPublicacion', tPublicacion);
    
            let promiseProduct = $.ajax({
                url: URL_SINGLE + 'Producto/editProductRequest',
                type: 'POST',
                data:  formData,
                dataType: 'json',
                contentType: false,
                processData: false,            
                success: function(response){
                    console.log("response: ", response);
                    if (response.res == 1 || response.res == true) {
                        alert("¡El producto se ha actualziado exitosamente!");
                        enabledSaveProduct();
                        disabledEditProduct();
                        // refresh
                        location.reload();
                    }
                },
                error: function(err) {
                    console.log("err : "+ err);
                }
            });   
        }
    });

    // Eliminado lógico del producto / finalizar
    $(".delete-product").on("click", function() {
        let idData = $(this).attr("data-id");

        let confirmEdit = confirm("¿Realmente desea eliminar este producto?")
        if (confirmEdit) {
            // ajax request
            var formData = new FormData();
            formData.append('idProduct', idData);
            $.ajax({
                url: URL_SINGLE + 'Producto/deleteProductRequest',
                type: 'POST',
                data:  formData,
                dataType: 'json',
                contentType: false,
                processData: false,            
                success: function(response){
                    console.log("response: ", response);
                    if (response.res == true || response.res == 1) {
                        enabledSaveProduct();
                        disabledEditProduct();
                        alert("¡Producto elimiado!");
                        showAlert($(".alert alert-success"), true);
                    }
                },
                error: function(err) {
                    console.log("err : "+ err);
                }
            });
        }
    });

    // publicar producto
    $(".activar-producto").on("click", function() {
        let id = $(this).parent().next().find("#idProd").val();

        // Obtener los valores para calcular TRM y resto de la fórmula
        let precio          = $(this).parent().next().find("#precioProd").val();
        let peso            = $(this).parent().next().find("#pesoProd").val();
        let tipoPublicacion = $(this).parent().next().find("#tipoPublicacionProd").val();
        // calculando TRM
        let valorTRM = getTRMSimple(id, precio, peso, tipoPublicacion);      
    });  


    // Pausar producto / quitar publicación
    $(".pausar-producto").on("click", function() {
        let id = $(this).parent().next().find("#idProd").val();

        let confirmEdit = confirm("¿Realmente desea pausar este producto (quitar temporalmente de la tienda)?")
        if (confirmEdit) {
            // ajax request
            var formData = new FormData();
            formData.append('idProduct', id);
            $.ajax({
                url: URL_SINGLE + 'Producto/pauseProductListRequest',
                type: 'POST',
                data:  formData,
                dataType: 'json',
                contentType: false,
                processData: false,            
                success: function(response){
                    console.log("response: ", response);
                    if (response.res == true || response.res == 1) {
                        enabledSaveProduct();
                        disabledEditProduct();
                        alert("¡Producto pausado (se ha quitado de la tienda, podrá volver a publicar este producto cuando lo desee)!");
                        showAlert($(".alert alert-success"), true);
                    }
                },
                error: function(err) {
                    console.log("err : "+ err);
                }
            });
        }
    });  

    // Show and Hide warning - action  ***********************************************************
    function showAlert($jqueryAlert, reload=false) {
        console.log("alert warning")
        $jqueryAlert.removeClass("d-none");

        setTimeout(function() { 
            $jqueryAlert.addClass("d-none");
        }, 3000);

        if (reload) {
            reloadCurrentPage();
        }
    }

    function reloadCurrentPage() {
        location.reload();
    }   

})(jQuery);
