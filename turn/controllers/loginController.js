function Login() {
    var usuariologin = document.getElementsByName('usuariologin')[0].value;
    var passwordlogin = document.getElementsByName('passwordlogin')[0].value;

    if (usuariologin.trim() === "" || passwordlogin.trim() === "") {
        Swal.fire({
            title: 'Notificación!',
            position: 'center',
            icon: 'info',
            text: 'Por favor ingrese un usuario y una contraseña',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    $.ajax({
        method: 'POST',
        url: '/Turnero/models/login.php',
        data: {
            accion: 'LoginUsuario', // 🔥 Asegura que se envía la acción
            usuario: usuariologin,
            password: passwordlogin
        },
        dataType: 'json', // 🔥 Asegura que la respuesta se trate como JSON
        success: function(response) {
            console.log('Server response:', response);
            if (response.codigo === 0) {
                Swal.fire({
                    title: 'Bienvenido!',
                    position: 'center',
                    icon: 'success',
                    text: 'Bienvenido ' + response.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                });
                localStorage.setItem('usuario', response.usuario);
                localStorage.setItem('servicio', response.servicio);
                localStorage.setItem('modulo', response.modulo);
                location.href = 'http://localhost/Turnero/views/inicio';
            } else {
                Swal.fire({
                    title: 'Error!',
                    position: 'center',
                    icon: 'error',
                    text: response.mensaje,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la llamada AJAX:', error);
            Swal.fire({
                title: 'Error!',
                position: 'center',
                icon: 'error',
                text: 'No se pudo conectar con el servidor',
                showConfirmButton: true
            });
        }
    });
}


