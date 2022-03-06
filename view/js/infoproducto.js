/**EFECTO LUPA**/
$('.infoproducto figure.visor img').mouseover(function (event) {
	var capturaImg = $(this).attr('src');
	$('.lupa img').attr('src', capturaImg);
	$('.lupa').fadeIn('fast');
	$('.lupa').css({
		height: $('.visorImg').height() + 'px',
		width: '100%'
	});
});

$('.infoproducto figure.visor img').mouseout(function (event) {
	$('.lupa').fadeOut('fast');
});

$('.infoproducto figure.visor img').mousemove(function (event) {
	var posX = event.offsetX;
	var posY = event.offsetY;
	$('.lupa img').css({
		'margin-left': -posX + 'px',
		'margin-top': -posY + 'px'
	});
});

/**CONTADOR DE VISTAS**/
var contador = 0;
$(window).on('load', function () {
	var vistas = $('span.vistas').html();
	var id = $('span.idPro').html();
	contador = Number(vistas) + 1;
	var datos = new FormData();
	var item = 'vistas';
	datos.append('valor', contador);
	datos.append('item', item);
	datos.append('id', id);

	$.ajax({
		url: rutaOculta + 'ajax/producto.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {}
	});
});

$('#verMas').click(function (e) {
	e.preventDefault();

	if ($('#verMas').html() == 'Ver más') {
		$('.comentarios').css({ overflow: 'inherit' });

		$('#verMas').html('Ver menos');
	} else {
		$('.comentarios').css({
			height: $('.comentarios .alturaComentarios').height() + 'px',
			overflow: 'hidden',
			'margin-bottom': '20px'
		});

		$('#verMas').html('Ver más');
	}
});
