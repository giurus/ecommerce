/**CESTA DE LOS PRODUCTOS CARRITO**/
if (localStorage.getItem('cantidadCesta') != null) {
	$('.cantidadCesta').html(localStorage.getItem('cantidadCesta'));
	$('.sumaCesta').html(localStorage.getItem('sumaCesta'));
} else {
	$('.cantidadCesta').html('0');
	$('.sumaCesta').html('0');
}

function myRound(num, dec) {
	var exp = Math.pow(10, dec || 2); // 2 decimales por defecto
	return parseInt(num * exp, 10) / exp;
}

/**VISUALIZAR LOS PRODUCTOS EN LA PAGINA DEL CARRITO DE COMPRAS***/
if (localStorage.getItem('listaProductos') != null) {
	var listaCarrito = JSON.parse(localStorage.getItem('listaProductos'));
	listaCarrito.forEach(funcionForEach);
	function funcionForEach(item, index) {
		$('.cuerpoCarrito').append(
			'<div>' +
				'<div class="row itemCarrito">' +
				'<div class="col-md-1 col-12">' +
				'<br>' +
				'<center>' +
				'<button class="btn backColor quitarItemCarrito" idProducto="' +
				item.idProducto +
				'" peso="' +
				item.peso +
				'">' +
				'<i class="fas fa-times"></i>' +
				'</button>' +
				'</center>' +
				'</div>' +
				'<div class="col-md-1 col-12">' +
				'<img src="' +
				item.imagen +
				'" class="img-thumbnail">' +
				'</div>' +
				'<div class="col-md-4 col-12">' +
				'<br>' +
				'<p class="tituloCarritoCompra text-left">' +
				item.titulo +
				'</p>' +
				'</div>' +
				'<div class="col-lg-2 col-md-1 col-12">' +
				'<br>' +
				'<p class="precioCarritoCompra text-center">S/.<span>' +
				item.precio +
				'</span></p>' +
				'</div>' +
				'<div class="col-md-2 col-sm-3 col-8">' +
				'<br>' +
				'<div class="col-xs-8">' +
				'<center>' +
				'<input type="number" precio="' +
				item.precio +
				'" idProducto="' +
				item.idProducto +
				'" class="form-control cantidadItem" oninput="this.value=this.value.slice(0,this.maxLength||1/1);this.value=(this.value   < 1) ? (1/1) : this.value;" max="9999" maxlength="4" min="1" pattern="^[0-9]+" value="' +
				item.cantidad +
				'" name="" id="">' +
				'</center>' +
				'</div>' +
				'</div>' +
				'<div class="col-md-2 col-sm-1 col-4 text-center">' +
				'<br>' +
				'<p class="subTotal' +
				item.idProducto +
				' subtotales' +
				'"><strong>S/.<span>' +
				item.precio +
				'</span></strong></p>' +
				'</div>' +
				'</div>' +
				'<hr>' +
				'</div>'
		);
	}
} else {
	$('.cabeceraCarrito').hide();
	$('.aquiCarrito').html(
		'<div class="text-center text-muted"><h2><small>Aún no hay productos en el carrito de compras.</small></h2></div>'
	);
	$('.sumaCarrito').hide();
	$('.cabeceraCheckout').hide();
}

/**AGREGAR A CARRITO DE COMPRA***/
$('.agregarCarrito').click(function () {
	var idProducto = $(this).attr('idProducto');
	var imagen = $(this).attr('imagen');
	var titulo = $(this).attr('titulo');
	var precio = $(this).attr('precio');
	var peso = $(this).attr('peso');

	/**RECUPERAR ALMACENAMIENTO DEL LOCALSTORAGE**/
	if (localStorage.getItem('listaProductos') == null) {
		listaCarrito = [];
	} else {
		var listarProductos = JSON.parse(localStorage.getItem('listaProductos'));
		for (let i = 0; i < listarProductos.length; i++) {
			if (listarProductos[i]['idProducto'] == idProducto) {
				swal({
					title: 'El producto ya esta agregado al carrito de compras',
					text: '',
					type: 'warning',
					showCancelButton: false,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: '¡Volver!',
					closeOnConfirm: false
				});
				return;
			}
		}
		listaCarrito.concat(localStorage.getItem('listaProductos'));
	}

	/**ALMACENAR EN EL LOCALSTORAGE LOS PRODUCTOS AGREGADOS AL CARRITO**/
	listaCarrito.push({
		idProducto: idProducto,
		imagen: imagen,
		titulo: titulo,
		precio: precio,
		peso: peso,
		cantidad: 1
	});
	localStorage.setItem('listaProductos', JSON.stringify(listaCarrito));
	/**AZTUALIZAR CESTA CARRITO**/
	let cantidadCesta = Number($('.cantidadCesta').html()) + 1;
	let sumaCesta = (Number($('.sumaCesta').html()) + Number(precio)).toFixed(2);
	$('.cantidadCesta').html(cantidadCesta);
	$('.sumaCesta').html(sumaCesta);
	localStorage.setItem('cantidadCesta', cantidadCesta);
	localStorage.setItem('sumaCesta', sumaCesta);
	/**ALERTA DE PRODUCTO AGREGADO AL CARRITO**/
	swal(
		{
			title: '',
			text: titulo + ' ha sido añadido a tu carrito.',
			type: 'success',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			cancelButtonText: '¡Continuar comprando!',
			confirmButtonText: '¡Ir a mi carrito de compras!',
			closeOnConfirm: false
		},
		function (isConfirm) {
			if (isConfirm) {
				window.location = rutaOculta + 'carrito-de-compras';
			}
		}
	);
});

/**QUITAR ITEM DEL CARRITO***/
$('.quitarItemCarrito').click(function () {
	$(this).parent().parent().parent().parent().remove();
	let idProducto = $('.cuerpoCarrito button');
	let imagen = $('.cuerpoCarrito img');
	let titulo = $('.cuerpoCarrito .tituloCarritoCompra');
	let precio = $('.cuerpoCarrito .precioCarritoCompra span');
	let cantidad = $('.cuerpoCarrito .cantidadItem');
	/**SI AUN QUEDAN PRODUCTOS AL QUITAR ELEMENTOS AGREGAR AL CARRITO POR LOCALSTORAGE**/
	listaCarrito = [];
	if (idProducto.length != 0) {
		for (let i = 0; i < idProducto.length; i++) {
			var idProductoArray = $(idProducto[i]).attr('idProducto');
			var imagenArray = $(imagen[i]).attr('src');
			var tituloArray = $(titulo[i]).html();
			var precioArray = $(precio[i]).html();
			var pesoArray = $(idProducto[i]).attr('peso');
			var cantidadArray = $(cantidad[i]).val();
			listaCarrito.push({
				idProducto: idProductoArray,
				imagen: imagenArray,
				titulo: tituloArray,
				precio: precioArray,
				peso: pesoArray,
				cantidad: cantidadArray
			});
		}
		localStorage.setItem('listaProductos', JSON.stringify(listaCarrito));
		sumaSubTotales();
		cestaCarrito(listaCarrito.length);
	} else {
		/**YA NO QUEDAN PRODUCTOS EN LA CESTA ***/
		localStorage.removeItem('listaProductos');
		localStorage.setItem('cantidadCesta', '0');
		localStorage.setItem('sumaCesta', '0');

		$('.cantidadCesta').html('0');
		$('.sumaCesta').html('0');

		$('.cabeceraCarrito').hide();
		$('.aquiCarrito').html(
			'<div class="text-center"><h2><small>Aún no hay productos en el carrito de compras.</small></h2></div>'
		);
		$('.sumaCarrito').hide();
		$('.cabeceraCheckout').hide();
	}
});

/**GENERAR SUBOTAL LUEGO DE CAMBIAR CANTIDAD**/
$(document).on('change', '.cantidadItem', function () {
	var cantidad = $(this).val();
	var precio = $(this).attr('precio');
	var idProducto = $(this).attr('idProducto');
	$('.subTotal' + idProducto).html(
		'<strong>S/.<span>' + cantidad * precio + '</span></strong>'
	);

	/**ACTUALIZAR CANTIDAD EN LOCALSTORAGE**/
	var idProducto = $('.cuerpoCarrito button');
	var imagen = $('.cuerpoCarrito img');
	var titulo = $('.cuerpoCarrito .tituloCarritoCompra');
	var precio = $('.cuerpoCarrito .precioCarritoCompra span');
	var cantidad = $('.cuerpoCarrito .cantidadItem');

	listaCarrito = [];
	for (let i = 0; i < idProducto.length; i++) {
		var idProductoArray = $(idProducto[i]).attr('idProducto');
		var imagenArray = $(imagen[i]).attr('src');
		var tituloArray = $(titulo[i]).html();
		var precioArray = $(precio[i]).html();
		var pesoArray = $(idProducto[i]).attr('peso');
		var cantidadArray = $(cantidad[i]).val();
		listaCarrito.push({
			idProducto: idProductoArray,
			imagen: imagenArray,
			titulo: tituloArray,
			precio: precioArray,
			peso: pesoArray,
			cantidad: cantidadArray
		});
	}
	localStorage.setItem('listaProductos', JSON.stringify(listaCarrito));
	sumaSubTotales();
	cestaCarrito(listaCarrito.length);
});

function comprueba(valor) {
	this.value.slice(0, this.maxLength || 1 / 1);
	this.value = this.value < 1 ? 1 / 1 : this.value;
}

/**ACTUALIZAR SUBTOTAL**/
var precioCarritoCompra = $('.cuerpoCarrito .precioCarritoCompra span');
var cantidadItem = $('.cuerpoCarrito .cantidadItem');

for (var i = 0; i < precioCarritoCompra.length; i++) {
	var precioCarritoCompraArray = $(precioCarritoCompra[i]).html();
	var cantidadItemArray = $(cantidadItem[i]).val();
	var idProductoArray = $(cantidadItem[i]).attr('idProducto');

	$('.subTotal' + idProductoArray).html(
		'<strong>S/.<span>' +
			precioCarritoCompraArray * cantidadItemArray +
			'</span></strong>'
	);
	sumaSubTotales();
	cestaCarrito(precioCarritoCompra.length);
}

/**SUMA DE TODOS LOS SUBTOTALES**/
function sumaSubTotales() {
	var subtotales = $('.subtotales span');
	var arraySumaSubtotales = [];
	for (var i = 0; i < subtotales.length; i++) {
		var subtotalesArray = $(subtotales[i]).html();
		arraySumaSubtotales.push(Number(subtotalesArray));
	}
	function sumaArraySubtotales(total, numero) {
		return total + numero;
	}
	var sumaTotal = arraySumaSubtotales.reduce(sumaArraySubtotales);
	$('.sumaSubTotal').html(
		'<strong>S/.<span>' + sumaTotal.toFixed(2) + '</span></strong>'
	);
	$('.sumaCesta').html(sumaTotal.toFixed(2));
	localStorage.setItem('sumaCesta', sumaTotal.toFixed(2));
}

/**ACTUALIZAR CESTA AL CAMBIAR CANTIDAD**/
function cestaCarrito(cantidadProductos) {
	/**¿HAY PRODUCTOS EN EL CARRITO?**/
	if (cantidadProductos != 0) {
		var cantidadItem = $('.cuerpoCarrito .cantidadItem');
		var arraySumaCantidades = [];
		for (var i = 0; i < cantidadItem.length; i++) {
			var cantidadItemArray = $(cantidadItem[i]).val();
			arraySumaCantidades.push(Number(cantidadItemArray));
		}
		function sumaArrayCantidades(total, numero) {
			return total + numero;
		}
		var sumaTotalCantidades = arraySumaCantidades.reduce(sumaArrayCantidades);
		$('.cantidadCesta').html(sumaTotalCantidades);
		localStorage.setItem('cantidadCesta', sumaTotalCantidades);
	}
}

/********************************
------------CHECK OUT--------------
**********************************/
$('#btnCheckout').click(function () {
	$('.listarProductos table.tablaProductos tbody').html('');
	$('#checkpayu').prop('checked', true);
	$('#checkpaypal').prop('checked', false);

	var idUsuario = $(this).attr('idUsuario');
	var peso = $('.cuerpoCarrito button');
	var titulo = $('.cuerpoCarrito .tituloCarritoCompra');
	var cantidad = $('.cuerpoCarrito .cantidadItem');
	var subtotal = $('.cuerpoCarrito .subtotales span');
	var cantidadPeso = [];
	var sumaSubTotal = $('.sumaSubTotal span');
	$('.valorSubTotal').html($(sumaSubTotal).html());
	$('.valorSubTotal').attr('valor', $(sumaSubTotal).html());

	/**TASA DE IMPUESTO**/
	var impuestoTotal = ($('.valorSubTotal').html() * $('#impuesto').val()) / 100;
	$('.valorTotalImpuesto').html(impuestoTotal.toFixed(2));
	$('.valorTotalImpuesto').attr('valor', impuestoTotal.toFixed(2));

	/**ciclo for VARIABLES ARRAY**/
	for (let i = 0; i < titulo.length; i++) {
		var pesoArray = $(peso[i]).attr('peso');
		var tituloArray = $(titulo[i]).html();
		var cantidadArray = $(cantidad[i]).val();
		var subtotalArray = $(subtotal[i]).html();

		/**CALCULAR EL PESO POR LA CANTIDAD***/
		cantidadPeso[i] = pesoArray * cantidadArray;
		function sumaArrayPeso(total, numero) {
			return total + numero;
		}
		var sumaTotalPeso = cantidadPeso.reduce(sumaArrayPeso);

		/**MOSTRAR PRODUCTOS DEFINITIVOS**/
		$('.listarProductos table.tablaProductos tbody').append(
			'<tr><td class="valorTitulo">' +
				tituloArray +
				'</td><td class="valorCantidad">' +
				cantidadArray +
				'</td><td><span class="cambioDivisa">S/.</span><span class="valorItem" valor="' +
				subtotalArray +
				'">' +
				subtotalArray +
				'</span></td></tr>'
		);
	}
	$('#seleccionarDistrito').html(
		'<select id="seleccionarDistrito" class="form-control" required>' +
			'<option value="">-Seleccione un Distrito-</option>' +
			'</select>'
	);

	$.ajax({
		url: rutaOculta + 'view/js/distritos.json',
		type: 'GET',
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (respuesta) {
			respuesta.forEach(seleccionarDistrito);
			function seleccionarDistrito(item) {
				var distrito = item.name;
				$('#seleccionarDistrito').append(
					'<option value="' + distrito + '">' + distrito + '</option>'
				);
			}
		}
	});

	$('#seleccionarDistrito').change(function () {
		$('.alert').remove();
	});

	var resultadoPeso = (sumaTotalPeso * $('#envio').val()).toFixed(2);
	if (resultadoPeso < $('#tasaMin').val()) {
		$('.valorTotalEnvio').html($('#tasaMin').val());
		$('.valorTotalEnvio').attr('valor', $('#tasaMin').val());
	} else {
		$('.valorTotalEnvio').html(resultadoPeso);
		$('.valorTotalEnvio').attr('valor', resultadoPeso);
	}

	sumaTotalCompra();
	pagaPayu();
});

/**SUMA TOTAL TOTAL DE LA COMPRA**/
function sumaTotalCompra() {
	let sumaTotalCom =
		Number($('.valorSubTotal').html()) +
		Number($('.valorTotalEnvio').html()) +
		Number($('.valorTotalImpuesto').html());
	$('.valorTotalCompra').html(sumaTotalCom.toFixed(2));
	$('.valorTotalCompra').attr('valor', sumaTotalCom.toFixed(2));
}

/**METODO DE PAGO PARA CAMBIO DE DIVISA MEIDANTE UNA API**/

$("input[name='pago']").change(function () {
	var metodoPago = $(this).val();
	if (metodoPago == 'payu') {
		$('.btnPagar').hide();
		$('.formPayu').show();
		pagaPayu();
	} else {
		$('.btnPagar').show();
		$('.formPayu').hide();
	}
	pagaPaypal(metodoPago);
});

var divisaBase = 'PEN';
function pagaPaypal(metodoPago) {
	var divisa = $('input:radio[name=pago]:checked').attr('myDivisa');
	var signo = '';
	var conversion = 1;
	if (metodoPago == 'paypal') {
		signo = 'USD ';
		conversion = 0.28;
	} else {
		signo = 'S/.';
		conversion = 1;
	}

	//METODO CAMBIO DE DIVISA SIN API
	$('.cambioDivisa').html(signo);
	var valorItem = $('.valorItem');
	var conta = 0;
	for (var i = 0; i < valorItem.length; i++) {
		$(valorItem[i]).html(
			(conversion * Number($(valorItem[i]).attr('valor'))).toFixed(2)
		);
		//Obtengo la suma de los valores de mi tabla productos dependiendo si esta convertido en USD o PEN
		conta = conta + Number($(valorItem[i]).html());
	}

	var vte = (conversion * Number($('.valorTotalEnvio').attr('valor'))).toFixed(
		2
	);
	var vti = (
		conversion * Number($('.valorTotalImpuesto').attr('valor'))
	).toFixed(2);
	var tot = (Number(conta) + Number(vte) + Number(vti)).toFixed(2);

	$('.valorSubTotal').html(conta.toFixed(2));
	$('.valorTotalEnvio').html(vte);
	$('.valorTotalImpuesto').html(vti);
	$('.valorTotalCompra').html(tot);

	//METODO CAMBIO DE DIVISA CON API
	/*$.ajax({
		url:
			'https://free.currconv.com/api/v7/convert?apiKey=do-not-use-this-key&q=' +
			divisaBase +
			'_' +
			divisa +
			'&compact=y',
		type: 'GET',
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'jsonp',
		success: function (respuesta) {
			var conversion = respuesta['PEN_' + divisa].val.toFixed(2);
			if (divisa == 'PEN') {
				conversion = 1;
			}
			$('.cambioDivisa').html(signo);
			var valorItem = $('.valorItem');
			var conta = 0;
			for (var i = 0; i < valorItem.length; i++) {
				$(valorItem[i]).html(
					(conversion * Number($(valorItem[i]).attr('valor'))).toFixed(2)
				);
				//Obtengo la suma de los valores de mi tabla productos dependiendo si esta convertido en USD o PEN
				conta = conta + Number($(valorItem[i]).html());
			}
			/*var subtotalTabla = $('.cuerpoCarrito .subtotales span');
			var totaltabla = 0;
			for (let i = 0; i < subtotalTabla.length; i++) {
				var subtotalArray = $(subtotalTabla[i]).html();
				console.log(subtotalArray);
				totaltabla = totaltabla + Number(subtotalArray);
			}*/
	//var vst = (totaltabla * conversion).toFixed(2);
	/*var vte = (
				conversion * Number($('.valorTotalEnvio').attr('valor'))
			).toFixed(2);
			var vti = (
				conversion * Number($('.valorTotalImpuesto').attr('valor'))
			).toFixed(2);
			var tot = (Number(conta) + Number(vte) + Number(vti)).toFixed(2);

			$('.valorSubTotal').html(conta);
			$('.valorTotalEnvio').html(vte);
			$('.valorTotalImpuesto').html(vti);
			$('.valorTotalCompra').html(tot);
		}
	});*/
}

/**PAGO DE LOS PRODUCTOS**/
$('.btnPagar').click(function () {
	$('.alert').remove();
	if ($('#seleccionarDistrito').val() == '') {
		$('#seleccionarDistrito').after(
			'<div class="alert alert-warning">Debe seleccionar un distrito de envío</div>'
		);
		$('#seleccionarDistrito').focus();
		return;
	}
	if ($('.formEnvio #direccion').val() == '') {
		$('#direccion').focus();
		return;
	}

	var divisa = $('input:radio[name=pago]:checked').attr('myDivisa');
	var direccion =
		$('.formEnvio #direccion').val() + '-' + $('#seleccionarDistrito').val();
	var telefono = $('#telefono').val();
	var total = $('.valorTotalCompra').html();
	var impuesto = $('.valorTotalImpuesto').html();
	var envio = $('.valorTotalEnvio').html();
	var subtotal = $('.valorSubTotal').html();
	var titulo = $('.valorTitulo');
	var cantidad = $('.valorCantidad');
	var valorItem = $('.valorItem');
	var idProducto = $('.cuerpoCarrito button');

	var tituloArray = [];
	var cantidadArray = [];
	var valorItemArray = [];
	var idProductoArray = [];

	for (let i = 0; i < titulo.length; i++) {
		tituloArray[i] = $(titulo[i]).html();
		cantidadArray[i] = $(cantidad[i]).html();
		valorItemArray[i] = $(valorItem[i]).html();
		idProductoArray[i] = $(idProducto[i]).attr('idProducto');
	}

	var datos = new FormData();
	datos.append('divisa', divisa);
	datos.append('direccion', direccion);
	datos.append('telefono', telefono);
	datos.append('total', total);
	datos.append('impuesto', impuesto);
	datos.append('envio', envio);
	datos.append('subtotal', subtotal);
	datos.append('tituloArray', tituloArray);
	datos.append('cantidadArray', cantidadArray);
	datos.append('valorItemArray', valorItemArray);
	datos.append('idProductoArray', idProductoArray);

	$.ajax({
		url: rutaOculta + 'ajax/carrito.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function () {
			$('.listarProductos .btnPagar').html(
				'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Redirigiendo'
			);
		},
		success: function (respuesta) {
			//console.log(respuesta);
			window.location = respuesta;
		}
	});
});

function pagaPayu() {
	var apikey = $('.contenidoCheckout #apikey').val();
	var merchantId = $('.contenidoCheckout #merchantId').val();
	var accountId = $('.contenidoCheckout #accountId').val();
	var direccion =
		$('.formEnvio #direccion').val() + '-' + $('#seleccionarDistrito').val();
	var total = $('.valorTotalCompra').html();
	var impuesto = $('.valorTotalImpuesto').html();
	var envio = $('.valorTotalEnvio').html();
	var subtotal = $('.valorSubTotal').html();
	var titulo = $('.valorTitulo');
	var cantidad = $('.valorCantidad');
	var valorItem = $('.valorItem');
	var idProducto = $('.cuerpoCarrito button');
	var url = 'https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/';
	var tituloArray = [];
	var cantidadArray = [];
	var idProductoArray = [];
	var valorItemArray = [];

	for (let i = 0; i < titulo.length; i++) {
		tituloArray[i] = $(titulo[i]).html();
		cantidadArray[i] = $(cantidad[i]).html();
		idProductoArray[i] = $(idProducto[i]).attr('idProducto');
		valorItemArray[i] = $(valorItem[i]).html();
	}

	var valorItemString = valorItemArray.toString();
	var pago = valorItemString.replace(',', '-');

	var referenceCode = (
		Number(Math.ceil(Math.random() * 1000000000)) + Number(total)
	).toFixed();
	var description = tituloArray.toString();

	var productosString = idProductoArray.toString();
	var productos = productosString.replace(/,/g, '-');

	var cantidadString = cantidadArray.toString();
	var cantidadRee = cantidadString.replace(/,/g, '-');
	var signature = hex_md5(
		apikey +
			'~' +
			merchantId +
			'~' +
			referenceCode +
			'~' +
			total +
			'~PEN' +
			'~' +
			pago
	);

	$('.formPayu').attr('method', 'POST');
	$('.formPayu').attr('action', url);
	$('.formPayu input[name="merchantId"]').attr('value', merchantId);
	$('.formPayu input[name="accountId"]').attr('value', accountId);
	$('.formPayu input[name="description"]').attr('value', description);
	$('.formPayu input[name="referenceCode"]').attr('value', referenceCode);
	$('.formPayu input[name="amount"]').attr('value', total);
	$('.formPayu input[name="tax"]').attr('value', impuesto);
	$('.formPayu input[name="taxReturnBase"').attr('value', 0);
	$('.formPayu input[name="responseUrl"').attr(
		'value',
		rutaOculta +
			'index.php?ruta=finalizar-compra&payu=true&productos=' +
			productos +
			'&cantidad=' +
			cantidadRee +
			'&monto=' +
			valorItemArray
	);
	$('.formPayu input[name="declinedResponseUrl"').attr(
		'value',
		rutaOculta + 'carrito-de-compras'
	);
	$('.formPayu input[name="shippingValue"').attr('value', envio);
	$('.formPayu input[name="shippingAddress"').attr('value', direccion);
	$('.formPayu input[name="signature"').attr('value', signature);
}
