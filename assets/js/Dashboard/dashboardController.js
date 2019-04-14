// JS CONTROLLER - CAMALEON MicroFramework

(function ($) {
    // Globals DASHBOARD
    var URL_SINGLE = $("#urlSelector").val();
    console.log("Dashboard works!, " + URL_SINGLE);
    var objEdit = {"id": 0, "name": ""};
    //---------------------------------------------------------------------------------

    // UI controls
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    function disabledSave() {
        $("#saveCategory").addClass('disabled'); // Disables visually
        $("#saveCategory").prop('disabled', true); // Disables visually + functionally
    }
    function enabledSave() {
        $("#saveCategory").removeClass('disabled'); // Disables visually
        $("#saveCategory").prop('disabled', false); // Disables visually + functionally
    }

    function disabledEdit() {
        $("#editCategory").addClass('disabled'); // Disables visually
        $("#editCategory").prop('disabled', true); // Disables visually + functionally
    }
    function enabledEdit() {
        $("#editCategory").removeClass('disabled'); // Disables visually
        $("#editCategory").prop('disabled', false); // Disables visually + functionally
    }
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


    disabledEdit();
    enabledSave();


    // CRUD actions
    $("#saveCategory").on("click", function(){
        
        let nameCat = $("#categoryName").val();
        console.log("cat: "+ nameCat);
        if(nameCat == "" || nameCat == undefined || nameCat== null) {
            $("#categoryName").focus();
        } else {
            // Save
            var dataForm=$("#formCategory").serialize()
            var promise = $.ajax({
                url: URL_SINGLE + 'Dashboard/saveCategory',
                type: 'POST',
                data:  dataForm,
                dataType: 'json',
                success: function(response){
                    console.log("response: ", response);
                    if (response.res == "success") {
                        showAlert($(".alert alert-success"));
                        location.reload();
                    }
                },
                error: function(err) {
                    console.log("err : "+ err);
                }
            });

        }
    });

    // Update Category
    $(".edit-category").on("click", function(){
        let categoryId = $(this).attr("data-id");
        if (categoryId!= "") {
            enabledEdit();
            disabledSave();
            var name = $(this).parent().prev().text();
            $("#categoryName").val(name);
            objEdit.id = categoryId
            objEdit.name = name
            alert("datos: "+ categoryId + "  ,  "+ name);
        }
    });

    // Edit Category :: Ajax request
    $("#editCategory").on("click", function(){
        // Edit
        var formData = new FormData();
        formData.append('id', objEdit.id);
        formData.append('categoryname', $("#categoryName").val());
        console.log("data json: "+ objEdit.name + " , " + objEdit.id + ", " + URL_SINGLE);

        $.ajax({
            url: URL_SINGLE + 'Dashboard/editCategory',
            type: 'POST',
            data:  formData,
            dataType: 'json',
            contentType: false,
            processData: false,            
            success: function(response){
                console.log("response: ", response);
                if (response.res == "success") {
                    console.log("edit ok");
                    disabledEdit();
                    enabledSave();
                    alert("Updated Category!");
                    showAlert($(".alert alert-success"), true);
                }
            },
            error: function(err) {
                console.log("err : "+ err);
            }
        });
    });

    // DELETE CATEGORY
    $(".delete-category").on("click", function(){

        let confirmDelete = confirm("Are you sure you want to delete the category?");

        if (confirmDelete) {
            let categoryId = $(this).attr("data-id");
            if (categoryId!= "") {
                var formData = new FormData();
                formData.append('id', categoryId);
    
                $.ajax({
                    url: URL_SINGLE + 'Dashboard/deleteCategory',
                    type: 'POST',
                    data:  formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,            
                    success: function(response){
                        console.log("response: ", response);
                        if (response.res == "success") {
                            console.log("delete ok");
                            disabledEdit();
                            enabledSave();
                            alert("Deleted Category!");
                            showAlert($(".alert alert-success"), true);
                        }
                    },
                    error: function(err) {
                        console.log("err : "+ err);
                    }
                });
            }
        } else {

        }
    });


    // PAUSAR / FINALIZAR PRODUCTOS
    // Pausar producto / quitar publicación
    $(".pausar-producto").on("click", function() {
        let id = $(this).parent().find("#idProd").val();

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
    
    // publicar producto
    $(".activar-producto").on("click", function() {
        let id = $(this).parent().find("#idProd").val();        

        // Obtener los valores para calcular TRM y resto de la fórmula
        let precio          = $(this).parent().find("#precioProd").val();
        let peso            = $(this).parent().find("#pesoProd").val();
        let tipoPublicacion = $(this).parent().find("#tipoPublicacion").val();
        // calculando TRM
        let valorTRM = getTRMSimple(id, precio, peso, tipoPublicacion);      
    });      

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


    // Grafico de barras
    let arrayDiasPub = {};

    function getDatosGraficoPublicaciones(){

        let objDias = {
            "LUNES": 0,
            "MARTES": 0,
            "MIERCOLES": 0,
            "JUEVES": 0,
            "VIERNES": 0,
            "SABADO": 0,
            "DOMINGO": 0,
        }

        $.ajax({
            url: URL_SINGLE + 'Producto/getPublicacionesPorDia',
            type: 'GET',
            data:  {'grafica': true},
            dataType: 'json',
            contentType: false,
            processData: false,            
            success: function(response){
                console.log("response: ", response.res);
                if (response.data == true || response.data == 1) {

                    let eachDay = response.res;
                    $.each(eachDay, function(i,j){
                        console.log("elemento: ", j)
                        switch(j.dia) {
                            case "LUNES":
                                objDias["LUNES"] = j.totalPublicaciones;
                                break;
                            case "MARTES":
                                objDias["MARTES"] = j.totalPublicaciones;
                                break;
                            case "MIERCOLES":
                                objDias["MIERCOLES"] = j.totalPublicaciones;
                                break;
                            case "JUEVES":
                                objDias["JUEVES"] = j.totalPublicaciones;
                                break;
                            case "VIERNES":
                                objDias["VIERNES"] = j.totalPublicaciones;
                                break;
                            case "SABADO":
                                objDias["SABADO"] = j.totalPublicaciones;
                                break;
                            case "DOMINGO":
                                objDias["DOMINGO"] = j.totalPublicaciones;
                                break;
                        }
                    });

                    console.log("ress each :: ", objDias);
                    // ordenando por días de la semana los valores:
                    let res = asignarValoresAlArrDiasPub(objDias);
                    dibujarGrafico(res);
                    
                } else {
                    console.log("false")
                }

            },
            error: function(err) {
                console.log("err : "+ err);
            }
        });        
    }

    if ($("body.index-dashboard").length > 0) {
        getDatosGraficoPublicaciones();
    }
    

    // Pinta el gráfico mediante el mecanismo de canvas (Chart.js)
    function dibujarGrafico(arrOrdenadoDatos) {
        var ctx = document.getElementById('publicacionesDia').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                datasets: [{
                    label: '# publicaciones por día',
                    data: arrOrdenadoDatos,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            responsive:true,
            maintainAspectRatio: false,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        }); 
    }
   
    // Ordena los valores por día de la semana
    function asignarValoresAlArrDiasPub(arregloDias) {
        
        let arrValores = [];
        // LUNES
        arrValores.push(arregloDias.LUNES)
        arrValores.push(arregloDias.MARTES)
        arrValores.push(arregloDias.MIERCOLES)
        arrValores.push(arregloDias.JUEVES)
        arrValores.push(arregloDias.VIERNES)
        arrValores.push(arregloDias.SABADO)
        arrValores.push(arregloDias.DOMINGO)
        return arrValores;
    }









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
