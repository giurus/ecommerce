<!--VALIDAR SESION-->
<?php
$servidor = Ruta::ctrRutaServidor();
$url = Ruta::ctrRuta();
?>

<!--BREADCRUMB PERFIL-->
<div class="container">
    <div class="row">
        <!--BREADCRUMB-->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item" aria-current="page"><a href="<?=$url?>">Inicio</a></li>
                    <li class="breadcrumb-item active pagActiva"><?=$rutas[0]?></li>
                </ol>
            </nav>
        <!---->
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <h2>Contáctenos</h2>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
                <div class="col-md-8"><br>
                    <form method="post">
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="editarNombre">Nombre:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="enviarNombre" name="enviarNombre" maxlength="30" placeholder="Nombre" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="editarEmail">Correo Electrónico:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="enviarEmail" name="enviarEmail" placeholder="Correo Electrónico" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="editarPassword">Mensaje:</label>
                            <div class="col-sm-8">
                                <textarea name="enviarMensaje" class="form-control" id="enviarMensaje" cols="30" rows="10" placeholder="Mensaje"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-8">
                                <button type="submit" class="btn btn-default backColor btn-lg pull-right">Enviar</button>
                            </div>
                        </div>
                    </form>

                </div>
    </div>
</div>