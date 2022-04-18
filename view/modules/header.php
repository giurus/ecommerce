<?php 

    $logotipo = ControladorPlantilla::ctrEstiloPlantilla();
    $estiloPlantilla = ControladorPlantilla::ctrEstiloPlantilla();
    $servidor = Ruta::ctrRutaServidor();
    $url = Ruta::ctrRuta();

    /**INICIO DE SESION DEL USUARIO**/
    if(isset($_SESSION["validarSesion"])){
        if($_SESSION["validarSesion"]=="ok"){
            echo '
            <script>
                localStorage.setItem("usuario", "'.$_SESSION["id"].'")
            </script>
            ';
        }
    }

?>
<!----------------------------------------------->
<!--------------------TOP BARRA------------------>
<!----------------------------------------------->
<div class="container-fluid barraSuperior" id="top">
    <div class="container">
        <div class="row">
            <!--TEXTO SUPERIOR IZQUIERDA-->
            <div class="col-lg-6 col-sm-12 numeroContacto">
                <p><?=$estiloPlantilla['textoEditTop']?></p>
            </div>
            <!---------------------------->
            <!------ENLACES TOP DERECHA------->
            <div class="col-lg-6 col-sm-12 registro">
                <ul>
                    <?php
                    if(isset($_SESSION["validarSesion"])){
                        if($_SESSION["validarSesion"]=="ok"){
                            if($_SESSION["modo"]=="directo"){
                                echo '
                                <li><a href="'.$url.'perfil">'.$_SESSION["nombre"]." ".$_SESSION["apellido"].'</a></li>
                                <li>|</li>
                                <li><a href="'.$url.'salir">Desconectar</a></li>
                                ';
                            }
                        }
                    }else{
                        echo '
                        <li><a href="#modalIngreso" data-toggle="modal">Ingresar</a></li>
                        <li>|</li>
                        <li><a href="#modalRegistro" data-toggle="modal">Registro</a></li> 
                        ';
                    }
                    ?>
                </ul>
            </div>
            <!-------------------------------->
        </div>
    </div>
</div>
<!----------------------------------------------->
<!----------SEGUNDA BARRA TOP HEADER------------->
<!----------------------------------------------->
<header class="container-fluid backColor">
    <div class="container">
        <div class="row" id="cabezote">
            <!--------LOGO------->
            <div class="col-xl-3 col-md-3 col-sm-2 col-12" id="logotipo">
                <a href="<?=$url?>">
                    <img src="<?=$servidor?><?=$logotipo["logo"]?>" alt="logo" class="pt-2" style="width: 90%;">
                </a>
            </div>
            <!--------BUSCADOR----->
            <div class="col-xl-6 col-md-6 col-sm-8 col-12 mt-4">
                <div id="buscador">
                    <div class="input-group mb-3">
                        <input type="search" class="form-control" placeholder="Buscar..." name="buscar">
                        <div class="input-group-append">
                            <a href="<?=$url?>buscador/1">
                                <button type="submit" class="btn btn-light">
                                    <i class="fas fa-search"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--CARRITO DE COMPRAS-->
            <div class="col-xl-3 col-md-3 col-sm-2 col-12 mt-4 d-flex flex-row justify-content-end" id="carrito">
                <div>
                    <a href="<?=$url?>carrito-de-compras">
                        <button class="btn btn-light pull-left">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                        </button>
                    </a>
                </div>
                <div class="p-1">
                    <p><strong> Productos <span class="cantidadCesta badge badge-light"></span></strong></p>
                </div>
            </div>
        </div>
    </div>
</header><br>

<!--MODALES DEL INGRESO-->
<div class="modal fade" id="modalIngreso" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ingresar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post">
                <div class="form-group">
                    <input type="email" class="form-control campos" id="ingEmail" name="ingEmail"
                        placeholder="Correo electrónico" style="text-transform: lowercase;" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control campos" id="ingPassword" name="ingPassword"
                        placeholder="Contraseña" required>
                </div>
                <?php 
                    /*$ingreso = new ControladorUsuarios();
                    $ingreso ->ctrIngresoUsuario();*/
                ?>
                <button type="submit" class="btn backColor btn-lg btn-block btnIngreso">¡Ingresar!</button><br>
                <a href="#modalPassword" data-dismiss="modal" data-toggle="modal">¿Olvidaste tu contraseña?</a>
            </form>
      </div>
      <div class="modal-footer">
            <label>¿No tienes cuenta?, registrate aqui <a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">¡Registrarse!</a></label>
      </div>
    </div>
  </div>
</div>


<!--MODALES DEL REGISTRO-->
<div class="modal fade" id="modalRegistro" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post" onsubmit="return registroUsuario()">
                <div class="form-group">
                    <input type="text" class="form-control campos" id="nombreUsu" name="nombreUsu" placeholder="Nombre"
                        required maxlength="30">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control campos" id="apellidoUsu" name="apellidoUsu"
                        placeholder="Apellidos" required maxlength="30">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control campos" id="correoUsu" name="correoUsu"
                        placeholder="Correo electrónico" style="text-transform: lowercase;" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control campos" id="passwordUsu" name="passwordUsu"
                        placeholder="Contraseña" minlength="8" required>
                </div>
                <!--Politicas de privacidad-->
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" value="" id="regPoliticas">
                    <label class="form-check-label" for="regPoliticas">He leído y aceptado la <a href="#">política de privacidad</a></label>
                </div>
                <?php 
                    /*$registro = new ControladorUsuarios();
                    $registro ->ctrRegistroUsuario();*/
                ?>
                <button type="submit" class="btn btn-success btn-lg btn-block">¡Crear cuenta!</button>
            </form>
      </div>
      <div class="modal-footer">
            <label>¿Ya tienes cuenta? <a href="#modalIngreso" data-dismiss="modal" data-toggle="modal">¡Inicie sesión!</a></label>
      </div>
    </div>
  </div>
</div>

<!--MODAL DE OLVIDE MI CONTRASEÑA-->
<div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Solicitud de nueva contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post">
                <div class="form-group">
                <label>Escribe tu correo electrónico</label>
                    <input type="email" class="form-control campos" id="passEmail" name="passEmail"
                        placeholder="Correo electrónico" required>
                </div>
                <?php 
                    /*$password = new ControladorUsuarios();
                    $password ->ctrOlvidoPassword();*/
                ?>
                <button type="submit" class="btn backColor btn-lg btn-block">Enviar</button> 
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>