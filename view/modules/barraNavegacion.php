<?php 
    $servidor = Ruta::ctrRutaServidor();
    $url = Ruta::ctrRuta();
?>
<div class="container shadow">
    <div class="navegacion">
        <nav>
            <ul>
                <li><a href="<?=$url?>" class="p-3"><i class="fas fa-home casita"></i></a></li>
                <?php
                    $categorias = ControladorProductos::ctrMostrarCategorias(null, null);
                    foreach ($categorias as $key => $value) {  
                    if($value['ruta']!='sin-categoria'){ 
                        $subcategorias = ControladorProductos::ctrMostrarSubCategorias('id_categoria',$value["id"]);               
                ?>
                <li>
                    <a href="<?=$url.$value["ruta"]?>" class="p-3"><?=$value["categoria"]?> <i class="fas fa-<?=($subcategorias)?'sort-down':'caret-right'?>"></i></a>
                    <div class="<?=($subcategorias)?'submenu p-2 shadow-sm':''?>">
                        <ul>
                            <?php for ($i=0; $i < count($subcategorias) ; $i++) { 
                                echo '<li class="clasesubcategorias pb-2"><a href="'.$url.$subcategorias[$i]['ruta'].'" class="p-2 m-3">'.$subcategorias[$i]['subcategoria'].' <i class="fas fa-caret-right ml-2"></i></a></li>';
                            } ?>
                        </ul>
                    </div>
                </li>
                <?php }} ?>
                <li class="float-right p-3"><a href="<?=$url?>contacto">Contacto</a></li>
                <li class="float-right p-3"><a href="<?=$url?>oferta" class="promociones font-weight-bold">Promociones</a></li>
            </ul>
        </nav>
    </div>
</div><br>