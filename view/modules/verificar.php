<?php

    $valor = $rutas[1];
    $item = "emailEncriptado";
    $respuesta = ControladorUsuarios::ctrMostrarUsuario($item,$valor);
    $usuarioVerificado = false;
    if($valor == $respuesta["emailEncriptado"]){
        $id = $respuesta["id"];
        $item2 = "verificacion";
        $valor2 = 0;
            $respuesta2 = ControladorUsuarios::ctrActualizarUsuario($id,$item2,$valor2);
            if($respuesta2 == "ok"){
                $usuarioVerificado = true;
            }
    }
    
    
?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center verificar">
            <?php if($usuarioVerificado){ ?>
                <h3>¡Gracias!</h3>
                <h2><small>
                    ¡Hemos verificado su correo electrónico, ya puede ingresar al sistema!
                </small></h2>
                <br>
                <a href="#modalIngreso" data-toggle="modal"><button class="btn btn-default backColor btn-lg">Ingresar</button></a>
            <?php }else{ ?>
                <h3>¡Oops!</h3>
                <h2><small>
                    ¡No se ha podido verificar su correo electrónico!
                </small></h2>
                <br>
                <a href="#modalRegistro" data-toggle="modal"><button class="btn btn-default backColor btn-lg">Registro</button></a>
            <?php } ?>
        </div>
    </div>
</div>