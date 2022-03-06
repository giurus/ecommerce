$(document).ready(function () {
	$('.campos').val('');
	$('#regPoliticas').prop('checked', false);
});

/**CAPTURA DE RUTA**/
var rutaActual = location.href;
$('.btnIngreso').click(function () {
	localStorage.setItem('rutaActual', rutaActual);
});

/**FORMATEAR LOS INPUTS**/
$('input').focus(function () {
	$('.alert').remove();
});

/**VALIDAD EMAIL REPETIDO**/
var validarEmailRepetido = false;
$('#correoUsu').change(function () {
	var email = $('#correoUsu').val();
	var datos = new FormData();
	datos.append('validarEmail', email);
	$.ajax({
		url: rutaOculta + 'ajax/usuarios.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			if (respuesta == 'false') {
				$('.alert').remove();
				validarEmailRepetido = false;
			} else {
				$('#correoUsu')
					.parent()
					.before(
						'<div class="alert alert-warning">Este correo electrónico ya se encuentra registrado.</div>'
					);
				validarEmailRepetido = true;
			}
		}
	});
});

/**VALIDAR EL REGISTRO DE USUARIO**/
function registroUsuario() {
	/**VALIDAR NOMBRE Y APELLIDO**/
	var nombre = $('#nombreUsu').val();
	var apellido = $('#apellidoUsu').val();
	if (nombre != '' && apellido != '') {
		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;
		if (!expresion.test(nombre && apellido)) {
			$('#nombreUsu')
				.parent()
				.before(
					'<div class="alert alert-warning">No se permiten números ni caracteres especiales, números en el nombre o apellido</div>'
				);
			return false;
		}
	} else {
		$('#nombreUsu')
			.parent()
			.before(
				'<div class="alert alert-warning">Este campo es obligatorio</div>'
			);
	}
	/**VALIDAR EMAIL**/
	var email = $('#correoUsu').val();
	if (email != '') {
		var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
		if (!expresion.test(email)) {
			$('#correoUsu')
				.parent()
				.before(
					'<div class="alert alert-warning">Escriba correctamente el correo electrónico</div>'
				);
			return false;
		}
		if (validarEmailRepetido) {
			$('#correoUsu')
				.parent()
				.before(
					'<div class="alert alert-warning">Este correo electrónico ya se encuentra registrado.</div>'
				);
			return false;
		}
	} else {
		$('#correoUsu')
			.parent()
			.before(
				'<div class="alert alert-warning">Este campo es obligatorio</div>'
			);
	}

	/**VALIDAR CONTRASEÑA**/
	var password = $('#passwordUsu').val();
	if (password != '') {
		var expresion = /^[a-zA-Z0-9]*$/;
		if (!expresion.test(password)) {
			$('#passwordUsu')
				.parent()
				.before(
					'<div class="alert alert-warning">Vuelva a escribir su contraseña</div>'
				);
			return false;
		}
	} else {
		$('#passwordUsu')
			.parent()
			.before(
				'<div class="alert alert-warning">Este campo es obligatorio</div>'
			);
	}
	/**VALIDAR TERMINOS Y CONDICIONES**/
	var politicas = $('#regPoliticas:checked').val();
	if (politicas != false) {
		$('#regPoliticas')
			.parent()
			.before(
				'<div class="alert alert-warning"><strong>Atención:</strong> Debe aceptar nuestras politicas de privacidad</div>'
			);
		return false;
	}
	return true;
}

/**COMENTARIOS**/
$('.calificarProducto').click(function () {
	var idComentario = $(this).attr('idComentario');
	$('#idComentario').val(idComentario);
});

$('input[name="puntaje"]').change(function () {
	var puntaje = $(this).val();
	console.log(puntaje);
});

/**VALIDANDO EL CAMPO DE COMENTARIOS**/
function validarComentario() {
	var comentario = $('#comentario').val();
	if (comentario != '') {
		var expresion = /^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;
		if (!expresion.test(comentario)) {
			$('#comentario')
				.parent()
				.before(
					'<div class="alert alert-danger"><strong>Error!</strong> No se permiten caracteres especiales. <small>(!¡$%&¿?[]*)</small></div>'
				);
			return false;
		}
	} else {
		$('#comentario')
			.parent()
			.before(
				'<div class="alert alert-warning"><strong>Importante!</strong> Campo obligatorio.</div>'
			);
		return false;
	}
	return true;
}

/**LISTA DE DESEOS**/
$('.deseos').click(function () {
	var idProducto = $(this).attr('idProducto');
	var idUsuario = localStorage.getItem('usuario');
	if (idUsuario == null) {
		swal(
			{
				title: 'Debe iniciar sesión',
				text:
					'Para poder agregar un producto a la lista de deseos debe estar logeado.',
				type: 'warning',
				confirmButtonText: 'Cerrar',
				closeOnConfirm: false
			},
			function (isConfirm) {
				if (isConfirm) {
					window.location = rutaOculta;
				}
			}
		);
	} else {
		/**CAMBIANDO ICONO**/
		var icono = $(this).find('i');
		icono.attr(
			'class',
			icono.hasClass('far fa-heart')
				? 'fas fa-heart'
				: icono.attr('data-original')
		);
		/*******/
		var datos = new FormData();
		datos.append('idUsuario', idUsuario);
		datos.append('idProducto', idProducto);
		$.ajax({
			url: rutaOculta + 'ajax/usuarios.ajax.php',
			method: 'POST',
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function (respuesta) {}
		});
	}
});

/**BORRAR DE LA LISTA DESEOS***/
$('.quitarDeseo').click(function () {
	var idDeseo = $(this).attr('idDeseo');
	$(this).parent().parent().parent().parent().parent().parent().remove();
	var datos = new FormData();
	datos.append('idDeseo', idDeseo);
	$.ajax({
		url: rutaOculta + 'ajax/usuarios.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {
			console.log('rspta', respuesta);
		}
	});
});
