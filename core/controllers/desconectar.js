/*Variable que cuenta los minutos transcurridos*/
contador_minutos = 0;

/*Función que se ejecuta cuando el documento cargo completamente*/
$(document).ready(function() {
    /*Se ejecuta la función de incrementar tiempo cada minuto*/
    var intervalo_tiempo = setInterval("incrementarTiempo()", 60000);

    /*Si se movio el mouse, la variable de minutos será igual a 0*/
    $(this).mousemove(function(e) {
        contador_minutos = 0;
    });
    /*Si se presiono alguna tecla, la variable de minutos será igual a 0*/
    $(this).keypress(function(e) {
        contador_minutos = 0;
    });
});

/*Función que incrementa la variable que cuenta los minutos de inactividad*/
function incrementarTiempo() {
    contador_minutos = contador_minutos + 1;
    /*Si la cantidad de minutos sin actividad es igual o mayor a 5 se abrira la siguente página*/
    if (contador_minutos >= 5) {
        window.open('/Matrices/ExpoTecnica/core/helpers/desconectar.php','_top');
    }
}
