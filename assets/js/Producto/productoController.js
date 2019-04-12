// JS CONTROLLER - CAMALEON MicroFramework

(function ($) {
    // Globals DASHBOARD
    var URL_SINGLE = $("#urlSelector").val();
    console.log("Products works!, " + URL_SINGLE);
    var objEdit = {"id": 0, "name": ""};
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

        let confirmSave = confirm("Are you sure you want to create a new product?");

        if (confirmSave) {

            // get data
            let nombres             = $("#nombres").val();
            let descripcion         = $("#descripcion").val();
            let categoriaProducto   = $("#categoriasProducto").val();
            let peso                = $("#peso").val();
            let cantidad            = $("#cantidad").val();
            let precio              = $("#precio").val();
            let tipoPublicacion     = $("#tipoPublicacion").val();

            // TODO: comment - Request API CURRENCY
            //var res = convertCurrency(priceProd);
            // todo: comment end

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
                    if (response.res == "success") {
                        console.log("add Product ok");
                        alert("The product has been saved successfully");
                        // refresh
                        location.reload();
                    }

                    if (response.res == "fail" && response.uploadStatus == 0) {
                        alert("You must add a photo with a valid image format, usually .ico formats are not accepted for you to take it into account");
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
    });
    // jorge.duque@vendamasfacil.com
    

    // Eclit Edit | link table
    $(".edit-product").on("click", function() {
        let id              = $(this).parent().next().find("#idProd").val();
        let nombre          = $(this).parent().next().find("#nombreProd").val();
        let descripcion     = $(this).parent().next().find("#descripcionProd").val();
        let categoriaId     = $(this).parent().next().find("#categoriaProd").val();
        let peso            = $(this).parent().next().find("#pesoProd").val();
        let cantidad        = $(this).parent().next().find("#cantidaProd").val();
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

        // set name
        objProductEdit.idProduct = id;
        $("#nombres").val(nombre);
        $("#descripcion").val(descripcion);
        $("#categoriasProducto").val(categoriaId);
        $("#peso").val(peso);
        $("#cantidad").val(cantidad);
        $("#precio").val(precio);
        $("#tipoPublicacion").val(tPublicacion);

        disabledSaveProduct();
        enabledEditProduct();
    })




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
