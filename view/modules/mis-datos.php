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
        <!--BREADCRUMB-->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item" aria-current="page"><a href="<?=$url?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?=$url.'perfil'?>">Perfil</a></li>
                    <li class="breadcrumb-item active pagActiva"><?=$rutas[0]?></li>
                </ol>
            </nav>
        <!---->
    </div>
    <hr>
</div>

<div class="container">
    <div class="row">
        <h2>Sus Datos Personales</h2>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
                <div class="col-md-8"><br>
                    <form method="post">
                        <?php
                            echo '
                            <input type="hidden" name="idUsuario" value="'.$_SESSION["id"].'">
                            <input type="hidden" name="passUsuario" value="'.$_SESSION["password"].'">
                            <input type="hidden" name="modoUsuario" value="'.$_SESSION["modo"].'">
                            ';
                        ?>
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="editarNombre">Nombre:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editarNombre" name="editarNombre" maxlength="30" placeholder="Nombre" value="<?=$_SESSION["nombre"]?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="editarApellido">Apellido:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editarApellido" name="editarApellido" maxlength="40" placeholder="Apellido" value="<?=$_SESSION["apellido"]?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="editarTelefono">Teléfono:</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="editarTelefono" name="editarTelefono" maxlength="40" value="<?=$_SESSION["telefono"]?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="editarEmail">Correo Electrónico:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editarEmail" name="editarEmail" placeholder="Correo Electrónico" value="<?=$_SESSION["email"]?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-4" for="editarPassword">Contraseña:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="editarPassword" name="editarPassword" placeholder="Nueva Contraseña">
                            </div>
                        </div><br><br>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-8">
                                <button type="submit" class="btn btn-default backColor btn-lg pull-right">Guardar Cambios</button>
                            </div>
                        </div>
                        <?php 
                            $actualizarPerfil = new ControladorUsuarios();
                            $actualizarPerfil -> ctrActualizarPerfil();
                        ?>
                    </form>

                </div>
    </div>
</div>