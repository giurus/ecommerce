<?php

class ControladorUsuarios{
    /*public function ctrRegistroUsuario(){
        if(isset($_POST["nombreUsu"])){
            if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/',$_POST["nombreUsu"]) && preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/',$_POST["correoUsu"]) && preg_match('/^[a-zA-Z0-9]*$/',$_POST["passwordUsu"])){
                $encriptar = crypt($_POST["passwordUsu"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $encriptarEmail = md5($_POST["correoUsu"]);
                $datos = array("nombre"=>$_POST["nombreUsu"],
                                "apellido"=>$_POST["apellidoUsu"],
                                "password"=>$encriptar,
                                "email"=>$_POST["correoUsu"],
                                "modo"=>"directo",
                                "verificacion"=> 1,
                                "emailEncriptado" => $encriptarEmail
                            );
                $tabla = "usuarios";
                $respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla,$datos);
                if($respuesta == "ok"){
                    
                    $traerNotificaciones = ModeloUsuarios::mdlMostrarNotificaciones('notificaciones');
                    $nuevoUsuario = $traerNotificaciones['usuarios']+1;
                    ModeloUsuarios::mdlActualizarNotificaciones('notificaciones','usuarios',$nuevoUsuario);
                    
                    date_default_timezone_set("America/Lima");
                    $url = Ruta::ctrRuta();
                    $mail = new PHPMailer;
                    $mail->CharSet = 'UTF-8';
                    $mail->isMail();
                    $mail->setFrom('giuseppe19.genovez@hotmail.com', 'Anafer Mascotas');
                    $mail->addReplyTo('giuseppe19.genovez@hotmail.com', 'Anafer Mascotas');
                    $mail->Subject = "Por favor verifique su dirección de correo electrónico";
                    $mail->addAddress($_POST["correoUsu"]);
                    $mail->msgHTML('
                            <div
                            style="
                                width: 100%;
                                background: #eee;
                                position: relative;
                                font-family: sans-serif;
                                padding-bottom: 40px;
                            "
                        >
                            <div
                                style="
                                    position: relative;
                                    margin: auto;
                                    width: 600px;
                                    background: white;
                                    padding: 20px;
                                "
                            >
                                <center>
                                    <img
                                        style="padding: 20px; width: 15%"
                                        src="https://publicatefacil.com/wp-content/uploads/2019/03/email-icon2_w1200xh1200_96dpi-324x324.png"
                                        alt=""
                                    />
                                    <h3 style="font-weight: 100; color: #999">
                                        VERIFIQUE SU DIRECCIÓN DE CORREO ELECTRÓNICO
                                    </h3>
                                    <hr style="border: 1px solid #ccc; width: 80%" />
                                    <h4 style="font-weight: 100; color: #999; padding: 0 20px">
                                        Para empezar a usar su cuenta en Anafer Mascotas online, debe
                                        confirmar su dirección de correo electrónico.
                                    </h4>
                                    <a
                                        href="'.$url.'verificar/'.$encriptarEmail.'"
                                        target="_black"
                                        style="text-decoration: none"
                                    >
                                        <div
                                            style="
                                                line-height: 60px;
                                                background: #0aa;
                                                width: 60%;
                                                color: white;
                                            "
                                        >
                                            Verifique su dirección de correo electrónico
                                        </div>
                                    </a>
                                    <br />
                                    <hr style="border: 1px solid #ccc; width: 80%" />
                                    <h5 style="font-weight: 100; color: #999">
                                        Si no se inscribió en esta cuenta, por favor ignore este mensaje.
                                    </h5>
                                </center>
                            </div>
                        </div>
                    ');

                    $envio = $mail->Send();

                    if(!$envio){
                        echo '<script>
                                swal(
                                    {
                                        title: "¡Error!",
                                        text: "Ha ocurrido un problema en el envio de la verificación del correo electrónico a '.$_POST["correoUsu"].$mail->ErrorInfo.'",
                                        type: "error",
                                        confirmButtonText: "Cerrar",
                                        closeOnConfirm: false
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            history.back();
                                        }
                                    }
                                );
                                </script>';
                    }else{
                        echo '<script>
                        swal(
                            {
                                title: "¡Cuenta creada!",
                                text: "Se le ha enviado un email de confirmación al correo '.$_POST["correoUsu"].', favor de activar su cuenta.",
                                type: "success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    history.back();
                                }
                            }
                        );
                        </script>';
                    }
                }
            }else{
                echo '<script>
                    swal(
                        {
                            title: "¡Error!",
                            text: "Error al crear la cuenta",
                            type: "error",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                history.back();
                            }
                        }
                    );
                    </script>';
            }
        }
    }*/

    /**MOSTRAR USUARIOS**/
    static public function ctrMostrarUsuario($item,$valor){
        $tabla = "usuarios";
        $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla,$item, $valor);
        return $respuesta;
    }

    /**ACTUALIZAR LA VERIFICACION DEL CORREO USUARIO**/
    static public function ctrActualizarUsuario($id,$item,$valor){
        $tabla = "usuarios";
        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla,$id,$item, $valor);
        return $respuesta;
    }

    /**INGRESO DE USUARIOS**/
    public function ctrIngresoUsuario(){
        if(isset($_POST["ingEmail"])){
            if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["ingEmail"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){
                $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $tabla = "usuarios";
                $item = "email";
                $valor = $_POST["ingEmail"];
                $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla,$item, $valor);
                if($respuesta["email"] == $_POST["ingEmail"] && $respuesta["password"] == $encriptar){
                    if($respuesta["verificacion"]==1){
                        echo '<script>
                        swal(
                            {
                                title: "¡No ha verificado su correo electrónico!",
                                text: "Para poder usar su cuenta por favor ingrese a su correo electrónico e ingrese al enlace enviado.",
                                type: "error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    history.back();
                                }
                            }
                        );
                        </script>';
                    }else{
                        $_SESSION["validarSesion"] = "ok";
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["nombre"] = $respuesta["nombre"];
                        $_SESSION["apellido"] = $respuesta["apellido"];
                        $_SESSION["email"] = $respuesta["email"];
                        $_SESSION["telefono"] = $respuesta["telefono"];
                        $_SESSION["password"] = $respuesta["password"];
                        $_SESSION["modo"] = $respuesta["modo"];

                        echo '<script>
                            window.location = localStorage.getItem("rutaActual");
                        </script>';
                    }
                }else{
                    echo '<script>
                        swal(
                            {
                                title: "¡Error al ingresar!",
                                text: "¡Por favor revise que el email exista o la contraseña coincida con la registrada!",
                                type: "error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    window.location = localStorage.getItem("rutaActual")
                                }
                            }
                        );
                        </script>';
                }
            }else{
                echo '<script>
                        swal(
                            {
                                title: "¡Error!",
                                text: "¡Error al ingresar al sistema, no se permiten caracteres especiales!",
                                type: "error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    history.back();
                                }
                            }
                        );
                        </script>';
            }
        }
    }

    /**OLVIDO DE CONTRASEÑA**/
    public function ctrOlvidoPassword(){
        /*if(isset($_POST["passEmail"])){
            if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["passEmail"])){
                
                function generarPassword($longitud){
                    $key = "";
                    $patter = "1234567890abcdefghijklmnopqrstuvwxyz";
                    $max = strlen($patter)-1;
                    for($i=0;$i<$longitud;$i++){
                        $key .= $patter{mt_rand(0,$max)};
                        
                    }
                    return $key;
                }
                $nuevaPassword = generarPassword(11);
                $encriptar = crypt($nuevaPassword, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $tabla = "usuarios";
                $item1 = "email";
                $valor1 = $_POST["passEmail"];
                $respuesta1 = ModeloUsuarios::mdlMostrarUsuario($tabla,$item1, $valor1);
                if($respuesta1){
                    $id = $respuesta1["id"];
                    $item2 = "password";
                    $valor2 = $encriptar;
                    $respuesta2 = ModeloUsuarios::mdlActualizarUsuario($tabla,$id,$item2, $valor2);
                    if($respuesta2 == "ok"){
                        
                        date_default_timezone_set("America/Lima");
                        $url = Ruta::ctrRuta();
                        $mail = new PHPMailer;
                        $mail->CharSet = 'UTF-8';
                        $mail->isMail();
                        $mail->setFrom('giuseppe19.genovez@hotmail.com', 'Anafer Mascotas');
                        $mail->addReplyTo('giuseppe19.genovez@hotmail.com', 'Anafer Mascotas');
                        $mail->Subject = "Solicitud de nueva contraseña";
                        $mail->addAddress($_POST["passEmail"]);
                        $mail->msgHTML('
                                <div style="width: 100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">
                                    <div style=" position: relative; margin: auto; width: 600px; background: white; padding: 20px;">
                                        <center>
                                            <img style="padding: 20px; width: 15%" src="https://upload.wikimedia.org/wikipedia/commons/9/97/Avast_Passwords_logo.png"/>
                                            <h3 style="font-weight: 100; color: #999">
                                                Solicitud de nueva contraseña
                                            </h3>
                                            <hr style="border: 1px solid #ccc; width: 80%" />
                                            <h4 style="font-weight: 100; color: #999; padding: 0 20px">
                                                <strong>Su nueva contraseña: </strong>'.$nuevaPassword.'
                                            </h4>
                                            <a href="'.$url.'" target="_black" style="text-decoration: none">
                                                <div style=" line-height: 60px; background: #0aa; width: 50%; color: white;">
                                                    ANAFER MASCOTAS
                                                </div>
                                            </a>
                                            <br />
                                            <hr style="border: 1px solid #ccc; width: 80%" />
                                            <h5 style="font-weight: 100; color: #999">
                                                Si no se inscribió en esta cuenta, por favor ignore este mensaje.
                                            </h5>
                                        </center>
                                    </div>
                                </div>
                        ');
    
                        $envio = $mail->Send();
    
                        if(!$envio){
                            echo '<script>
                                    swal(
                                        {
                                            title: "¡Error!",
                                            text: "Ha ocurrido un problema en el envio del cambio de contraseña a '.$_POST["passEmail"].$mail->ErrorInfo.'",
                                            type: "error",
                                            confirmButtonText: "Cerrar",
                                            closeOnConfirm: false
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                history.back();
                                            }
                                        }
                                    );
                                    </script>';
                        }else{
                            echo '<script>
                            swal(
                                {
                                    title: "¡Cambio de contraseña!",
                                    text: "Se le ha enviado un email con la nueva contraseña generada a '.$_POST["passEmail"].'.",
                                    type: "success",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        history.back();
                                    }
                                }
                            );
                            </script>';
                        }
                    }else{
                        echo '<script>
                            swal(
                                {
                                    title: "¡Error!",
                                    text: "¡El correo electrónico no existe!",
                                    type: "error",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        history.back();
                                    }
                                }
                            )
                            </script>';
                    }
                
                }else{
                    echo '<script>
                            swal(
                                {
                                    title: "¡Error!",
                                    text: "¡Error al enviar el correo electrónico, está mal escrito!",
                                    type: "error",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        history.back();
                                    }
                                }
                            );
                            </script>';
                }
            }
        }*/
    }

    /**ACTUALIZAR USUARIO**/
    public function ctrActualizarPerfil(){
        if(isset($_POST["editarNombre"])){
            if($_POST["idUsuario"]==$_SESSION["id"]){
                if($_POST["editarPassword"]==""){
                    $password = $_POST["passUsuario"];
                }else{
                    $password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                }
                if(preg_match('/^[a-zA-Z]*$/',$_POST["editarNombre"]) && preg_match('/^[a-zA-Z]*$/',$_POST["editarApellido"])){
                    $datos = array("nombre" => $_POST["editarNombre"],
                                    "apellido" => $_POST["editarApellido"],
                                    "email" => $_POST["editarEmail"],
                                    "telefono" => $_POST["editarTelefono"],
                                    "password" => $password,
                                    "id" => $_POST["idUsuario"]);
                    $tabla = "usuarios";
                    $respuesta = ModeloUsuarios::mdlActualizarPerfil($tabla, $datos);
                    if($respuesta == "ok"){
                        $_SESSION["validarSesion"] = "ok";
                        $_SESSION["id"] = $datos["id"];
                        $_SESSION["nombre"] = $datos["nombre"];
                        $_SESSION["apellido"] = $datos["apellido"];
                        $_SESSION["email"] = $datos["email"];
                        $_SESSION["telefono"] = $datos["telefono"];
                        $_SESSION["password"] = $datos["password"];
                        $_SESSION["modo"] = $_POST["modoUsuario"];
    
                        echo '<script>
                        swal(
                            {
                                title: "¡Actualizado!",
                                text: "¡Su cuenta ha sido actualizada correctamente!",
                                type: "success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    history.back();
                                }
                            }
                        );
                        </script>';
                    }
                }else{
                    echo '<script>
                        swal(
                            {
                                title: "Error!",
                                text: "¡Su cuenta no ha podido se modificada por tener caracteres no permitidos!",
                                type: "error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    history.back();
                                }
                            }
                        );
                        </script>';
                }
            }else{
                echo '<script>
                        swal(
                            {
                                title: "¡Oops!",
                                text: "¡Error en la actualización de!",
                                type: "error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    history.back();
                                }
                            }
                        );
                        </script>';
            }
        }
    }

    /**MOSTRAR COMPRAS DEL USUARIO**/
    static public function ctrMostrarCompras($item,$valor){
        $tabla = "compras";
        $respuesta = ModeloUsuarios::mdlMostrarCompras($tabla,$item, $valor);
        return $respuesta;
    }

    /**MOSTRAR COMENTARIOS POR PERFIL**/
    static public function ctrMostrarComentariosPerfil($datos){
        $tabla = "comentarios";
        $respuesta = ModeloUsuarios::mdlMostrarComentariosPerfil($tabla,$datos);
        return $respuesta;
    }

    /*MOSTRAR TODOS LOS COMENTARIOS*/
    static public function ctrComentarios(){
        $tabla = "comentarios";
        $respuesta = ModeloUsuarios::mdlComentarios($tabla);
        return $respuesta;
    }

    /***ACTUALIZAR COMENTARIO**/
    public function ctrActualizarComentario(){
        if(isset($_POST["idComentario"])){
            if(preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["comentario"])){
                if($_POST["comentario"]!=""){
                    $tabla = "comentarios";
                    $datos = array("id"=>$_POST["idComentario"],
                                    "calificacion"=>$_POST["puntaje"],
                                    "comentario"=>$_POST["comentario"]
                                    );
                    $respuesta = ModeloUsuarios::mdlActualizarComentario($tabla,$datos);
                    if($respuesta=="ok"){
                        echo '<script>
                                swal(
                                    {
                                        title: "¡Gracias por compartir su opinión!",
                                        text: "¡Su calificación y comentario ha sido guardado!",
                                        type: "success",
                                        confirmButtonText: "Cerrar",
                                        closeOnConfirm: false
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            history.back();
                                        }
                                    }
                                );
                                </script>';
                    }
                }else{
                    echo '<script>
                            swal(
                                {
                                    title: "¡Error al enviar su calificación!",
                                    text: "¡El comentario no puede estar vacío!",
                                    type: "error",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        history.back();
                                    }
                                }
                            );
                        </script>';
                }
            }else{
                echo '<script>
                            swal(
                                {
                                    title: "¡Error al enviar su calificación!",
                                    text: "¡El comentario no puede llevar caracteres especiales!",
                                    type: "error",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        history.back();
                                    }
                                }
                            );
                        </script>';
            }
        }
    }

    /***AGREGAR A LISTA DE DESEOS**/
    static public function ctrAgregarDeseo($datos){
        $tabla = "deseos";
        $respuesta = ModeloUsuarios::mdlAgregarDeseo($tabla, $datos);
        return $respuesta;
    }

    /**MOSTRAR LISTA DE DESEOS***/
    static public function ctrMostrarDeseos($item){
        $tabla = "deseos";
        $respuesta = ModeloUsuarios::mdlMostrarDeseos($tabla,$item);
        return $respuesta;
    }

    /**QUITAR LISTA DE DESEOS***/
    static public function ctrQuitarDeseo($datos){
        $tabla = "deseos";
        $respuesta = ModeloUsuarios::mdlQuitarDeseo($tabla,$datos);
        return $respuesta;
    }
}