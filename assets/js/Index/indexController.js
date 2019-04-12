// JS CONTROLLER - CAMALEON MicroFramework

(function ($) {
    // Globals DASHBOARD
    var URL_SINGLE = $("#urlSelector").val();
    console.log("Index works!, " + URL_SINGLE);
    var objEdit = {"id": 0, "name": ""};
    //---------------------------------------------------------------------------------

    // UI controls
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    // L O G I N 
    $("#btnInicioSesion").on("click", function(){
        var log    = $("#login").val();
        var pass = $("#password").val();

        // Validation
        if (log== "") {
            $("#login").addClass("is-invalid");
        }
        if (pass== "") {
            $("#password").addClass("is-invalid");
        }

        if (log=!"" && pass != "" ) {
            $("#login").addClass("is-valid");
            $("#password").addClass("is-valid");

            let dataSend = {
                login: $("#login").val(),
                password: pass
            }

            // ajax
            var promesa = $.ajax({
                url: URL_SINGLE + 'Login/signInLogin',
                type: 'POST',
                data:  dataSend,
                dataType: 'json',
                success: function(response){                    
                    let data = (response.nick);
                    // ACCESS VALIDATE
                    if (response.res == "success" && response.statusLogin == 1) {
                        // Redireccionar a la dashboard
                        window.location.href = URL_SINGLE + "Dashboard/index";
                        console.log(response);
                    }
                },
                error: function(err) {
                    console.log("err ¿? : "+ err);
                }
            });
        }
    });

})(jQuery);
