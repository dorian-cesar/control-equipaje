let configuracionViaje = {};
let totalEquipaje = 0;
let equipajeActual = 1; // Para rastrear qué pieza de equipaje se está imprimiendo

$(document).ready(function () {
    // Obtener las ciudades y cargarlas en los select de Origen y Destino
    $.getJSON('https://araucania.wit.la/control-equipaje/backend/obtener_ciudades.php', function (data) {
        var opciones = '';
        $.each(data, function (key, val) {
            opciones += '<option value="' + val + '">' + val + '</option>';
        });
        $('#origen').html(opciones);
        $('#destino').html(opciones);
    });

    // Formatear RUT
    $("#rut").keyup(function () {
        var rut = $(this).val().replace(/\./g, '').replace('-', '');
        rut = rut.replace(/(\d{7,8})(\d{1})/, '$1-$2');
        $(this).val(rut);
    });

    $('#btnVolver').click(function(){
        window.history.back(); // Esto te llevará a la página anterior
    });

    // Guardar la configuración del viaje
    $('#guardarViaje').on('click', function () {
        configuracionViaje.origen = $('#origen').val();
        configuracionViaje.destino = $('#destino').val();
        configuracionViaje.fechaHoraViaje = $('#fechaHoraViaje').val();
        configuracionViaje.codServicio = $('#codServicio').val();
        configuracionViaje.patente = $('#patente').val();
        configuracionViaje.conductor = $('#conductor').val();
        configuracionViaje.rut_conductor = $('#rut_conductor').val();
    
           
        // Verifica si todos los campos tienen valores
        if (configuracionViaje.origen && configuracionViaje.destino && configuracionViaje.fechaHoraViaje && configuracionViaje.codServicio && configuracionViaje.patente && configuracionViaje.conductor && configuracionViaje.rut_conductor) {
            var viajeData = {
                origen: configuracionViaje.origen,
                destino: configuracionViaje.destino,
                fechaHoraViaje: configuracionViaje.fechaHoraViaje,
                codServicio: configuracionViaje.codServicio,
                patente: configuracionViaje.patente,
                conductor: configuracionViaje.conductor
            };
    
         
            $('#registro_user').show();
            $('#finalizarRegistro').show();
            $('#configuracion').hide();
            
           
           
        } else {
            alert('Por favor complete todos los campos de configuración del viaje.');
        }
    });

    // Obtener el nombre del pasajero al ingresar el RUT
    $('#rut').on('blur', function () {
        var rut = $('#rut').val();
        $.ajax({
            url: 'https://s1.ntic.cl/RUT/',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ rut: rut }),
            success: function (response) {
                $('#nombre').val(response.razonSocial);
            },
            error: function () {
                alert('Error al obtener el nombre.');
            }
        });
    });

    // Enviar el formulario de registro de pasajero y mostrar el botón de impresión
    $('#equipajeForm').on('submit', function (e) {
        e.preventDefault();

        if (!configuracionViaje.origen || !configuracionViaje.destino || !configuracionViaje.fechaHoraViaje || !configuracionViaje.codServicio || !configuracionViaje.patente || !configuracionViaje.conductor) {
            alert('Debe configurar el viaje antes de registrar pasajeros.');
            return;
        }

        var formData = $(this).serialize();
        formData += '&origen=' + configuracionViaje.origen;
        formData += '&destino=' + configuracionViaje.destino;
        formData += '&fechaHoraViaje=' + configuracionViaje.fechaHoraViaje;
        formData += '&codServicio=' + configuracionViaje.codServicio;
        formData += '&patente=' + configuracionViaje.patente;
        formData += '&conductor=' + configuracionViaje.conductor;
        formData += '&rut_conductor=' + configuracionViaje.rut_conductor;

        totalEquipaje = $('#equipaje').val(); // Obtenemos la cantidad total de maletas

        // Registro en bbdd
        $.post('backend/registrar.php', formData, function (data) {
            $('#ticket').html(data);
            window.location = 'printerplus://send?text=' + document.getElementById('ticket').innerHTML;
            $('#imprimirEquipaje').show(); // Mostrar botón para empezar a imprimir maletas
            equipajeActual = 1; // Reiniciar el contador de equipaje
        });

        $('#registrar').hide();
        $('#nuevoRegistro').show();
    });

    // Imprimir cada pieza de equipaje una por una
    $('#imprimirEquipaje').on('click', function () {
        if (equipajeActual <= totalEquipaje) {
            var formData = $('#equipajeForm').serialize();
            formData += '&pieza=' + equipajeActual;
            formData += '&origen=' + configuracionViaje.origen;
            formData += '&destino=' + configuracionViaje.destino;
            formData += '&fechaHoraViaje=' + configuracionViaje.fechaHoraViaje;
            formData += '&codServicio=' + configuracionViaje.codServicio;
            formData += '&patente=' + configuracionViaje.patente;
            formData += '&conductor=' + configuracionViaje.conductor;

            // Añadimos el número de la pieza actual
            $.post('https://araucania.wit.la/control-equipaje/backend/imprimir_equipaje.php', formData, function (data) {
                $('#ticket').html(data);
                $('#imprimirEquipaje').text('Imprimir: ' + (equipajeActual + 1) + ' de ' + totalEquipaje);
                window.location = 'printerplus://send?text=' + document.getElementById('ticket').innerHTML;

                equipajeActual++; // Avanzamos a la siguiente pieza
                if (equipajeActual > totalEquipaje) {
                    $('#imprimirEquipaje').hide(); // Ocultar el botón cuando se hayan impreso todas las piezas
                    $('#imprimirEquipaje').text('Imprimir Primer Equipaje');
                }
            });
        }
    });

    // Resetear la configuración del viaje
    $('#finalizarRegistro').on('click', function () {
        configuracionViaje = {};
        $('#viajeForm')[0].reset();
        $('#equipajeForm')[0].reset();
        alert('Registro finalizado. Puede configurar un nuevo viaje.');
        $('#registro_user').hide();
        $('#configuracion').show();
        $('#imprimirEquipaje').hide();
    });

    // Nuevo registro de pasajero
    $('#nuevoRegistro').on('click', function () {
        $('#equipajeForm')[0].reset();
        alert('Ingrese un nuevo registro.');
        $('#registrar').show();
        $('#nuevoRegistro').hide();
        $('#ticket').html('Ticket:');
    });
});
