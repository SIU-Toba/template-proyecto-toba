# Creación de un nuevo proyecto Toba

## Prerequisitos
 * Hay que tener instalado [Composer](https://getcomposer.org/)

## Descarga
 * Ejecutar
```
  php composer.phar create-project siu-toba/template-proyecto-vacio <CARPETA DESTINO>
```
 * Modificar el archivo ```composer.json``` reemplazando la entrada ```name``` con lo que corresponda.
 * Ejecutar en la carpeta el comando
```
  composer install
```

## Instalación y creación del proyecto con Docker
 * Instalar [Docker](https://docs.docker.com/engine/installation/linux/ubuntulinux/) y [Docker Compose](https://docs.docker.com/compose/install/)
 * Reemplazar en el archivo ```docker-compose.yml``` todas las apariciones del string ```<NOMBRE PROYECTO>``` por el nombre real
 del proyecto (los requisitos de este nombre son los mismos que para un identificador en PHP).
 * Ejecutar el comando
```
  docker-compose up -d
```
 * Conectarse al contenedor
```
  docker exec -it <NOMBRE PROYECTO> bash
```
 * Ejecutar el comando
 ```
   bin/crear-proyecto.sh
 ```
 * Reiniciar apache
 ```
   service apache2 reload
 ```
 * Salir del contenedor y en el directorio de la aplicación (donde está ```proyecto.ini```) ejecutar:
 ```
   sudo chown -R $USER:$USER metadatos php temp www proyecto.ini
 ```
 * Listo, el proyecto ya se puede acceder desde la url ```http://localhost:7008/toba_editor/2.7```. Recomendamos en este
 punto crear el commit inicial en el CVS. Si no se está usando Git hay que ignorar los directorios y archivos que se ecuentran
  en el archivo ```.gitignore```, si se utiliza Git no es necesario.

### Trabajando
#### Carpeta de instalación de Toba
Por defecto la carpeta de instalación queda montada en la carpeta llamada ```instalacion``` en la raíz del proyecto.
 Si se desea cambiar esto se hace desde la sección ```volumes``` del ```docker-compose.yml```
#### Comandos administrativos
Utilizando la instalación de Docker se recomiendo correr los comandos administrativos (exportar y regenerar metadatos e
interacción con el CVS) desde dentro del contenedor del proyecto. Para acceder al mismo se ejecuta el siguiente comando:
```
  docker exec -it <NOMBRE PROYECTO> bash
```


