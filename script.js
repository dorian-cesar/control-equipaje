let configuracionViaje = {};

$(document).ready(function() {
    // Obtener las ciudades y cargarlas en los select de Origen y Destino
    $.getJSON('https://araucania.wit.la/control-equipaje/backend/obtener_ciudades.php', function(data) {
        var opciones = '';
        $.each(data, function(key, val) {
            opciones += '<option value="' + val + '">' + val + '</option>';
        });
        $('#origen').html(opciones);
        $('#destino').html(opciones);
    });

    $(document).ready(function() {
        $("#rut").keyup(function() {
          var rut = $(this).val().replace(/\./g, '').replace('-', ''); // Remove pontos e hífen existentes
          rut = rut.replace(/(\d{7,8})(\d{1})/, '$1-$2'); // Insere o hífen após os 7 ou 8 primeiros dígitos
          $(this).val(rut);
        });
      });

    // Guardar la configuración del viaje
    $('#guardarViaje').on('click', function() {
        configuracionViaje.origen = $('#origen').val();
        configuracionViaje.destino = $('#destino').val();
        configuracionViaje.fechaHoraViaje = $('#fechaHoraViaje').val();

        if (configuracionViaje.origen && configuracionViaje.destino && configuracionViaje.fechaHoraViaje) {
            alert('Configuración del viaje guardada.');
            $('#registro_user').show();
            $('#configuracion').hide();
        } else {
            alert('Por favor complete todos los campos de configuración del viaje.');
        }
    
    });

    // Obtener el nombre del pasajero al ingresar el RUT
    $('#rut').on('blur', function() {
        var rut = $('#rut').val();
        $.ajax({
            url: 'https://s1.ntic.cl/RUT/',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ rut: rut }),
            success: function(response) {
                $('#nombre').val(response.razonSocial);
            },
            error: function() {
                alert('Error al obtener el nombre.');
            }
        });
    });

    // Enviar el formulario de registro de pasajero y generar los tickets
    $('#equipajeForm').on('submit', function(e) {
        e.preventDefault();
        if (!configuracionViaje.origen || !configuracionViaje.destino || !configuracionViaje.fechaHoraViaje) {
            alert('Debe configurar el viaje antes de registrar pasajeros.');
            return;
        }

        var formData = $(this).serialize();
        formData += '&origen=' + configuracionViaje.origen;
        formData += '&destino=' + configuracionViaje.destino;
        formData += '&fechaHoraViaje=' + configuracionViaje.fechaHoraViaje;


        var servicio = $('#servicio').val();
        var rut = $('#rut').val();
        var codigoEquipaje = servicio + rut;

        $.post('https://araucania.wit.la/control-equipaje/backend/registrar.php', formData + '&codigoEquipaje=' + codigoEquipaje, function(data) {
            $('#ticket').html(data);
             
        });
        $('#registrar').hide();
        $('#nuevoRegistro').show();
    });

    // Resetear la configuración del viaje
    $('#finalizarRegistro').on('click', function() {
        configuracionViaje = {};
        $('#viajeForm')[0].reset();
        alert('Registro finalizado. Puede configurar un nuevo viaje.');
        $('#registro_user').hide();
        $('#configuracion').show();
    });
//nuevoRegistro

$('#nuevoRegistro').on('click', function() {
    
    $('#equipajeForm')[0].reset();
    alert('ingresa tu nuevo registro');
    $('#registrar').show();
    $('#nuevoRegistro').hide();
    $('#ticket').html('Ticket:');
  
});


    

});
