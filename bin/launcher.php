<?php
  require_once(dirname(__FILE__). '/../vendor/autoload.php');

  if (! isset($_SERVER['TOBA_INSTALACION_DIR'])) {
      $_SERVER['TOBA_INSTALACION_DIR'] = realpath(dirname(__FILE__) . '/..').'/instalacion';

      echo 'ATENCION!!! Por favor, defina la ruta al directorio de instalacion de toba '.PHP_EOL;
      echo 'Por el momento, se toma '. $_SERVER['TOBA_INSTALACION_DIR'] . ' como ruta por defecto ' . PHP_EOL. PHP_EOL;
  }

  if (! isset($_SERVER['TOBA_DIR'])) {
    $_SERVER['TOBA_DIR'] = realpath(dirname(__FILE__) . '/../vendor/siu-toba/framework');
  }
  
  require_once($_SERVER['TOBA_DIR']. '/php/consola/run.php');


