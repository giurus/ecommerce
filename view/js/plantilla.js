/*PLANTILLA */
var rutaOculta = $("#rutaOculta").val();
//Tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

$.ajax({
  url: rutaOculta + "ajax/plantilla.ajax.php",
  success: function (respuesta) {
    var barraSuperior = JSON.parse(respuesta).barraSuperior;
    var textoSuperior = JSON.parse(respuesta).textoSuperior;
    var colorFondo = JSON.parse(respuesta).colorFondo;
    var colorTexto = JSON.parse(respuesta).colorTexto;

    $(".backColor, .backColor a").css({
      background: colorFondo,
      color: colorTexto,
    });

    $(".barraSuperior, .barraSuperior a").css({
      background: barraSuperior,
      color: textoSuperior,
    });
  },
});

/**CUADRICULA O LISTA**/
var btnList = $(".btnList");

for (let i = 0; i < btnList.length; i++) {
  $("#btnGrid" + i).click(function () {
    let numero = $(this).attr("id").substr(-1);
    $(".list" + numero).hide();
    $(".grid" + numero).show();
    $("#btnGrid" + numero).addClass("backColor");
    $("#btnList" + numero).removeClass("backColor");
  });

  $("#btnList" + i).click(function () {
    let numero = $(this).attr("id").substr(-1);
    $(".list" + numero).show();
    $(".grid" + numero).hide();
    $("#btnGrid" + numero).removeClass("backColor");
    $("#btnList" + numero).addClass("backColor");
  });
}

/**FLECHA PARA SUBIR**/
$.scrollUp({
  scrollText: "",
  scrollSpeed: 1300,
  easingType: "easeOutQuint",
});

/**BREADCRUMB**/
var pagActiva = $(".pagActiva").html();
if (pagActiva != null) {
  var regPagActiva = pagActiva.replace(/-/g, " ");
  $(".pagActiva").html(regPagActiva);
}

/**CONTADOR PROMOCIONES**/
var finOferta = $(".countdown");
var fechaFinOferta = [];
for (var i = 0; i < finOferta.length; i++) {
  fechaFinOferta[i] = $(finOferta[i]).attr("finOferta");
  $(finOferta[i]).dsCountDown({
    endDate: new Date(fechaFinOferta[i]),
    theme: "flat",
    titleDays: "Días",
    titleHours: "Horas",
    titleMinutes: "Minutos",
    titleSeconds: "Segundos",
  });
}

if ($(".moduloOfertas").children().length == 0) {
  $(".moduloOfertas").html(
    '<div class="col-12 error404 text-center"><h2>¡En estos momentos no hay promociones disponibles!</h2></div>'
  );
}
