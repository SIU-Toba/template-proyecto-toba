# Creación de un nuevo proyecto Toba

## Prerequisitos
Hay que tener instalado [Composer](https://getcomposer.org/)

## Creación
 * Crear el archivo ```composer.json``` con el siguiente contenido reemplazando la entrada ```name``` con lo que corresponda:
 ```
  {
    "name": "<NOMBRE INSTITUCION>/<NOMBRE PROYECTO>",
    "description": "",
    "repositories": [
      {
        "type": "composer",
        "url": "https://satis.siu.edu.ar"
      }
    ],
    "require": {
      "siu-toba/framework": "2.7.x-dev"
    },
    "minimum-stability": "dev",
    "prefer-stable": true
  }
```
 * Si se usa git crear el archivo ```.gitignore``` e ignorar la carpeta ```vendor```.
   Si se usa svn agregar la carpeta ```vendor``` a la propiedad ```svn:ignore```.

 * Ejecutar en la carpeta donde se ha creado el archivo el comando
```
  composer install
```

### Instalación por Docker
 * Ejecutar el comando
```
  docker-compose up -d
```
 * Conectarse al contenedor
```
  docker exec -it <NOMBRE PROYECTO> bash
```
 * 