<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Sistema_Contable</title>
        <meta name="description" content="FacturaScripts es un software de facturación y contabilidad para pymes. Es software libre bajo licencia GNU/LGPL." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php  echo FS_PATH;?>view/img/favicon.ico" />
        <link rel="stylesheet" href="<?php  echo FS_PATH;?>view/css/bootstrap-yeti.min.css" />
        <link rel="stylesheet" href="<?php  echo FS_PATH;?>view/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php  echo FS_PATH;?>view/css/custom.css" />
        <script type="text/javascript" src="<?php  echo FS_PATH;?>view/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php  echo FS_PATH;?>view/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-header">
                        <h1>
                            <span class="glyphicon glyphicon-exclamation-sign"></span> Error
                        </h1>
                        <?php if( $fsc->get_errors() ){ ?>

                        <div class="alert alert-danger hidden-print">
                            <ul><?php $loop_var1=$fsc->get_errors(); $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?><li><?php echo $value1;?></li><?php } ?></ul>
                        </div>
                        <?php } ?>

                        <?php if( $fsc->get_messages() ){ ?>

                        <div class="alert alert-success hidden-print">
                            <ul><?php $loop_var1=$fsc->get_messages(); $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?><li><?php echo $value1;?></li><?php } ?></ul>
                        </div>
                        <?php } ?>

                        <?php if( $fsc->get_advices() ){ ?>

                        <div class="alert alert-info hidden-print">
                            <ul><?php $loop_var1=$fsc->get_advices(); $counter1=-1; if($loop_var1) foreach( $loop_var1 as $key1 => $value1 ){ $counter1++; ?><li><?php echo $value1;?></li><?php } ?></ul>
                        </div>
                        <?php } ?>

                    </div>
                    <p class="help-block">
                        Ha sido imposible conectar a la base de datos. Los motivos suelen ser distintos
                        en función de dónde tengas instalado FacturaScripts.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <h3>
                        <i class="fa fa-desktop" aria-hidden="true"></i>
                        Instalado en tu PC...
                    </h3>
                    <ul>
                        <li>
                            Se ha desconectado <?php  echo FS_DB_TYPE;?>. Para solucionarlo debes reiniciar <?php  echo FS_DB_TYPE;?>.
                            Si estás usando Sistema_Contable, ve a la carpeta de Sistema_Contable, haz clic
                            en <b>xampp-control</b> y pulsa el botón <b>start</b>, al lado de <?php  echo FS_DB_TYPE;?>.
                        </li>
                        <li>
                            Has cambiado la contraseña de la base de datos. Para solucionarlo debes volver a poner
                            la contraseña original de la base de datos, o bien poner la nueva contraseña en el archivo
                            config.php de Sistema_Contable.
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </body>
</html>