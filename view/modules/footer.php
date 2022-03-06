<?php 
    $url = Ruta::ctrRuta();
    $plantilla = ControladorPlantilla::ctrEstiloPlantilla();
    $comercio = ControladorPlantilla::ctrMostrarComercio();
    $redSocial = json_decode($plantilla['redesSociales'],true);
?>
<hr><br>
<div class="container-fluid clearfix">
    <div class="container text-center">
        <div class="newsletter">
            <div class="row backColor p-3">
                <div class="col-lg-7">
                    <h3><i class="fas fa-bullhorn"></i> ¡Entérate de las últimas novedades de Anafer! Suscríbete. </h3>
                </div>
                <div class="input-group mb-3 col-lg-5 formSuscribirse">
                    <input type="email" class="form-control" placeholder="Correo Electrónico..." name="">
                    <div class="input-group-append">
                        <a href="#">
                            <button class="btn btnSuscribirse">Suscribirse</button>
                        </a>
                    </div>
                </div>
            </div>
        </div><br><br>
        <div class="row info">
            <div class="col-lg-4">
                <h4>Nuestra Empresa</h4>
                <a href="">Políticas de envío</a><br>
                <a href="">Pago Seguro</a><br>
                <a href="">Contacto</a>
            </div>
            <div class="col-lg-4">
                <h4>Información de la tienda</h4>
                <h6><i class="fas fa-map-marked-alt"></i> | <?=$comercio['direccion']?></h6><br>
                <h6><i class="fas fa-phone-alt"></i> | <?=$comercio['telefono']?></h6><br>
                <h6><i class="fas fa-envelope"></i> | <?=$comercio['email']?></h6>
            </div>
            <div class="col-lg-4">
                <h4>Redes Sociales</h4>
                <?php 
                $iface = 'fa-facebook-f';
                $iinsta = 'fa-instagram';
                foreach ($redSocial as $key => $value) { ?>
                    <h6><a href="<?=$value['url']?>"><i class="fab <?=$value['nombre']=='facebook'?$iface:$iinsta ?>"></i></a></h6>
                <?php } ?>
            </div>
        </div>
    </div>
</div><br>
<div class="container-fluid barraFinal">
    <div class="container text-center">
        <div class="iconos p-4">
            <a href=""><img src="<?=$url?>view/img/plantilla/libro-de-reclamaciones.png" alt=""></a>
        </div>
        <p class="pt-2"><small>© 2020 - Todo los derechos reservados - <a href="<?=$url?>">Anafer Mascotas.</a></small></p>
    </div>
</div>