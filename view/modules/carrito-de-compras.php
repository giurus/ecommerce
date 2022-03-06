<?php 
    $servidor = Ruta::ctrRutaServidor();
    $url = Ruta::ctrRuta();
        
?>
<!--BREADCRUMB PERFIL-->
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-uppercase">
                <li class="breadcrumb-item fondoBreadcrumb" aria-current="page"><a href="<?=$url?>">Inicio</a></li>
                <li class="breadcrumb-item active pagActiva"><?=$rutas[0]?></li>
            </ol>
        </nav><br>
    </div>
</div>

<!--TABLA CARRITOS DE COMPRAS-->
<div class="container aquiCarrito">
    <div class="card">
        <!--CABECERA-->
        <div class="card-header cabeceraCarrito">
            <div class="row text-center">
                <div class="col-md-6">
                    <h4 class="text-muted"><small>Producto</small></h4>
                </div>
                <div class="col-md-2">
                    <h4 class="text-muted"><small>Precio</small></h4>
                </div>
                <div class="col-md-2">
                    <h4 class="text-muted"><small>Cantidad</small></h4>
                </div>
                <div class="col-md-2">
                    <h4 class="text-muted"><small>Sub Total</small></h4>
                </div>
            </div>
        </div>
        <!---CUERPO-->
        <div class="card-body cuerpoCarrito">
        </div>
        <!--TOTAL-->
        <div class="card-body sumaCarrito">
            <div class="col-md-4 col-sm-6 col-12 float-right card">
                <div class="row">
                    <div class="col-6"><h4>Total:</h4></div>
                    <div class="col-6"><h4 class="sumaSubTotal"></h4></div>
                </div>
            </div>
        </div>
        <!--BOTON DE IR CAJA-->
        <div class="card-footer cabeceraCheckout">
        <?php 
        if(isset($_SESSION["validarSesion"])){
            if($_SESSION["validarSesion"]=='ok'){
                echo '<a id="btnCheckout" idUsuario="'.$_SESSION["id"].'" href="#modalCheckout" data-toggle="modal"><div class="btn backColor btn-lg float-right">Realizar Pago</div></a>';
            }
        }else{
            echo '<a href="#modalIngreso" data-toggle="modal"><div class="btn backColor btn-lg float-right">Realizar Pago</div></a>';
        }
        ?>   
        </div>
    </div>
</div>

<!--VENTANA MODAL PARA LOS PAGOS CHECKOUT-->
<div class="modal fade" id="modalCheckout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Realizar Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="contenidoCheckout">
            <?php
                $respuesta = ControladorCarrito::ctrMostrarTarifas();
                echo '
                    <input type="hidden" id="impuesto" name="" value="'.$respuesta["impuesto"].'">
                    <input type="hidden" id="envio" name="" value="'.$respuesta["envio"].'">
                    <input type="hidden" id="tasaMin" name="" value="'.$respuesta["tasaMin"].'">
                    <input type="hidden" id="apikey" name="" value="'.$respuesta["apikey"].'">
                    <input type="hidden" id="merchantId" value="'.$respuesta["merchantId"].'">
                    <input type="hidden" id="accountId" value="'.$respuesta["accountId"].'">
                ';
            ?>
            <div class="form-group formEnvio">
                <h6>Información de envío</h6>
                <div class="col-12">
                    <select id="seleccionarDistrito" class="form-control" required>
                        <option value="">-Seleccione un Distrito-</option>
                    </select>
                </div>
                <small class="form-text text-muted">Envíos solo Lima.</small><br>
                <h6>Dirección</h6>
                <div class="col-12">
                    <input class="form-control" type="text" name="direccion" id="direccion" placeholder="Dirección..." required>
                </div>
                <small class="form-text text-muted">Escribe tu dirección exacta.</small><br>
                <h6>Telefono</h6>
                <div class="col-12">
                    <input class="form-control" type="number" name="telefono" id="telefono" value="<?=$_SESSION['telefono']?>" required>
                </div><br>
            </div>
            <h4 class="text-center">Métodos de pago</h4><br>
            <div class="d-inline-flex">
                <div class="col-6">
                    <img src="<?=$servidor?>view/img/plantilla/payu.png" class="img-thumbnail">
                    <input id="checkpayu" type="radio" name="pago" class="form-control" value="payu" checked mydivisa="PEN">
                </div>
                <div class="col-6">
                    <img src="<?=$servidor?>view/img/plantilla/paypal.png" class="img-thumbnail">
                    <input id="checkpaypal" type="radio" name="pago" class="form-control" value="paypal" mydivisa="USD">
                </div>
            </div><br><br><hr>
            <div class="listarProductos">
                <h4 class="text-center text-muted">Productos a comprar</h4>
                <table class="table table-striped tablaProductos">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="col-sm-6 col-12 float-right">
                    <table class="table table-striped tablaTasas">
                        <tbody>
                            <tr>
                                <td>SubTotal</td>
                                <td><span class="cambioDivisa">S/.</span><span class="valorSubTotal" valor="0"></span></td>
                            </tr>
                            <tr>
                                <td>Envío</td>
                                <td><span class="cambioDivisa">S/.</span><span class="valorTotalEnvio" valor="0"></span></td>
                            </tr>
                            <tr>
                                <td>IGV</td>
                                <td><span class="cambioDivisa">S/.</span><span class="valorTotalImpuesto" valor="0"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td><strong><span class="cambioDivisa">S/.</span><span class="valorTotalCompra" valor="0"></span></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <form class="formPayu">
                    <input type="hidden" name="merchantId" value="">
                    <input type="hidden" name="accountId" value="">
                    <input type="hidden" name="description" value="">
                    <input type="hidden" name="referenceCode" value="">
                    <input type="hidden" name="amount" value="">
                    <input type="hidden" name="tax" value="">
                    <input type="hidden" name="taxReturnBase" value="">
                    <input type="hidden" name="currency" value="PEN">
                    <input type="hidden" name="lng" value="es">
                    <input type="hidden" name="confirmationUrl" value="">
                    <input type="hidden" name="responseUrl" value="">
                    <input type="hidden" name="declinedResponseUrl" value="">
                    <input type="hidden" name="shippingValue" value="">
                    <input type="hidden" name="shippingAddress" value="">
                    <input name="test" type="hidden"  value="1" >
                    <input type="hidden" name="signature" value="">
                    <input name="Submit" class="btn btn-block btn-lg backColor" type="submit"  value="Realizar Pago" >
                </form>
                <button class="btn btn-block btn-lg backColor btnPagar" style='display:none'>Realizar Pago</button>
            </div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>