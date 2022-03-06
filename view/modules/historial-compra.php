<!--VALIDAR SESION-->
<?php
$servidor = Ruta::ctrRutaServidor();
$url = Ruta::ctrRuta();
if(!isset($_SESSION["validarSesion"])){
    echo '<script>
        window.location = "'.$url.'"
    </script>';
    exit();
}
?>

<!--BREADCRUMB PERFIL-->
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-uppercase">
                <li class="breadcrumb-item fondoBreadcrumb" aria-current="page"><a href="<?=$url?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?=$url.'perfil'?>">Perfil</a></li>
                <li class="breadcrumb-item active pagActiva"><?php if($rutas[0]=="historial-compra") echo "Historial de pedidos"; ?></li>
            </ol>
        </nav><br>
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <h2>Historial y Detalle de mis Pedidos</h2>
    </div><br>
    <div class="row">
                <?php
                    $item = "id_usuario";
                    $valor = $_SESSION["id"];
                    $compras = ControladorUsuarios::ctrMostrarCompras($item, $valor);
                    if(!$compras){
                        echo '
                        <div class="col-12 text-center error404">
                            <h2 class="text-muted"><small>Aún no tiene compras realizadas en esta tienda</small></h2>
                        </div>
                        ';
                    }else{ ?>
            <div class="card shadow">
            <?php       foreach ($compras as $key => $value) {
                            $ordenar = "id";
                            $item = "id";
                            $valor = $value["id_producto"];
                            $productos = ControladorProductos::ctrListarProductos($ordenar,$item,$valor); 
                            foreach ($productos as $key => $value3) { $nroEnvio = $value["envio"]; ?>
                                <div class="card-body row">
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                                        <img class="img-thumbnail" src="<?=$servidor.$value3["portada"]?>">
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <h3><small><?=$value3["titulo"]?></small></h3>
                                        <p><?=$value3["titular"]?></p>
                                        <div class="row text-center">
                                            <div class="col"><small>Despachado</small></div>
                                            <div class="col"><small>Enviando</small></div>
                                            <div class="col"><small>Entregado</small></div>
                                        </div>
                                        <?php 
                                        switch ($nroEnvio) {
                                            case 0:
                                                echo '
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 33.34%;" aria-valuenow="33.34" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-check"></i></div>
                                                    <div class="progress-bar" role="progressbar" style="width: 33.33%;" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-clock"></i></div>
                                                    <div class="progress-bar" role="progressbar" style="width: 33.33%;" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-clock"></i></div>
                                                </div>
                                                ';break;
                                            case 1:
                                                echo '
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 33.34%;" aria-valuenow="33.34" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-check"></i></div>
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 33.33%;" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-check"></i></div>
                                                    <div class="progress-bar" role="progressbar" style="width: 33.33%;" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-clock"></i></div>
                                                </div>
                                                ';break;
                                            case 2:
                                                echo '
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 33.34%;" aria-valuenow="33.34" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-check"></i></div>
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 33.33%;" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-check"></i></div>
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 33.33%;" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-check"></i></div>
                                                </div>
                                                ';break;
                                        }
                                        ?>
                                        <h6 class="text-muted float-right"><small>Comprado el <?=substr($value["fecha"],0,-8)?></small></h6>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <?php 
                                        $datos = array("idUsuario"=>$_SESSION["id"],"idProducto"=>$value3["id"]);
                                        $comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);
                                        ?>
                                        <div class="float-right">
                                            <a class="calificarProducto" href="#modalComentarios" data-toggle="modal" idComentario="<?=$comentarios["id"]?>">
                                                <button class="btn btn-sm backColor">Calificar Producto</button>
                                            </a>
                                        </div><br><br>
                                        <div class="float-right">
                                            <?php 
                                            if($comentarios["calificacion"] == 0 && $comentarios["comentario"]==""){
                                                echo '<h1 class="text-right">★★★★★</h1>';
                                            }else{
                                                switch ($comentarios["calificacion"]) {
                                                    case 1:echo '<h4 class="text-right"><span style="color: orange;">★</span>★★★★</h4>';break;
                                                    case 2:echo '<h4 class="text-right"><span style="color: orange;">★★</span>★★★</h4>';break;
                                                    case 3:echo '<h4 class="text-right"><span style="color: orange;">★★★</span>★★</h4>';break;
                                                    case 4:echo '<h4 class="text-right"><span style="color: orange;">★★★★</span>★</h4>';break;
                                                    case 5:echo '<h4 class="text-right"><span style="color: orange;">★★★★★</span></h4>';break;
                                                }
                                            }
                                            ?>
                                        </div><br><br>
                                        <?php if($comentarios["comentario"]!=''){ ?>
                                        <p class="card text-justify" style="padding:5px"><small><?=$comentarios["comentario"]?></small></p>
                                        <?php } ?>
                                    </div>
                                </div>
                    <?php   }   
                        } 
                    }
                ?>
            </div>
    </div>
</div>

<!--VENTANA MODAL PARA COMENTARIOS-->
<div class="modal fade modalFormulario" id="modalComentarios" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Calificar este producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modalTitulo">
            <form method="post" onsubmit="return validarComentario()">
                <input type="hidden" id="idComentario" value="" name="idComentario">
                <h1 class="clasificacion text-center">
                    <input id="radio1" type="radio" name="puntaje" value="5"><!--
                    --><label for="radio1">★</label><!--
                    --><input id="radio2" type="radio" name="puntaje" value="4"><!--
                    --><label for="radio2">★</label><!--
                    --><input id="radio3" type="radio" name="puntaje" value="3"><!--
                    --><label for="radio3">★</label><!--
                    --><input id="radio4" type="radio" name="puntaje" value="2"><!--
                    --><label for="radio4">★</label><!--
                    --><input id="radio5" type="radio" name="puntaje" value="1"><!--
                    --><label for="radio5">★</label>
                </h1>
                <div class="form-group">
                    <label class="text-muted">Tu opinión acerca de este producto: <span><small>(máximo 300 carácteres)</small></span></label>
                    <textarea class="form-control" rows="5" name="comentario" id="comentario" maxlength="300" required></textarea><br>
                    <input type="submit" class="btn btn-default backColor btn-block" value="Calificar">
                </div>
                <?php
                    $actualizarComentario = new ControladorUsuarios();
                    $actualizarComentario -> ctrActualizarComentario();
                ?>
            </form>
      </div>
    </div>
  </div>
</div>