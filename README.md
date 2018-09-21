# Creación de un nuevo proyecto Toba

## Prerequisitos
 * Hay que tener instalado [Composer](https://getcomposer.org/)
 * Hay que tener instalado [Yarn](https://yarnpkg.com/) (para SIU-Toba v3.1+)
 * Hay que tener instalado [Bower](https://bower.io/) (v1.8.4 o superior) para la rama 3.0.x

## Descarga
 * Descargar este proyecto como zip (botón verde 'clone or download'). Luego extraerlo dentro de una carpeta deseada
 * Modificar el archivo ```composer.json``` reemplazando la entrada ```name``` con lo que corresponda.
 * Ejecutar en la carpeta el comando  
```shell
composer install
```

## Instalación y creación del proyecto con Docker
 * Instalar [Docker](https://docs.docker.com/engine/installation/linux/ubuntulinux/) y [Docker Compose](https://docs.docker.com/compose/install/)
 * Reemplazar en el archivo ```docker-compose.yml``` todas las apariciones del string ```<NOMBRE PROYECTO>``` por el nombre real
 del proyecto (los requisitos de este nombre son los mismos que para un identificador en PHP).
 * Ejecutar el comando  
```shell
docker-compose up -d
```
 * Conectarse al contenedor  
```shell
docker exec -it <NOMBRE PROYECTO> bash
```
 * Ejecutar el comando  
```shell
bin/crear-proyecto.sh
```
 * Reiniciar apache  
```shell
service apache2 reload
```
 * Listo, el proyecto ya se puede acceder desde la url ```http://localhost:7008/toba_editor/3.1```.  
    Las credenciales por defecto son ```toba:toba```
 
    Recomendamos en este punto crear el commit inicial en el CVS. Si no se está usando Git hay que ignorar los directorios y archivos que se ecuentran en el archivo ```.gitignore```, si se utiliza Git no es necesario.  
    
    La estructura del proyecto Toba nuevo quedó en la raíz.

### Trabajando
#### Permisos de los archivos
Por defecto el contenedor crea los archivos de código con permisos de root, esto puede ser molesto. Dentro del directorio del proyecto (fuera del contenedor) ejecutar esto por única vez para poder editar tranquilamente los archivos:
```shell
sudo chown -R $USER:$USER metadatos php temp www proyecto.ini
```
Una vez hecho esto se puede levantar con cualquier IDE la carpeta del proyecto y trabajar normalmente.
#### Carpeta de instalación de Toba
Por defecto la carpeta de instalación queda montada en la carpeta llamada ```instalacion``` en la raíz del proyecto.
 Si se desea cambiar esto se hace desde la sección ```volumes``` del ```docker-compose.yml```
#### Comandos administrativos
Utilizando la instalación de Docker se recomiendo correr los comandos administrativos (exportar y regenerar metadatos e
interacción con el CVS) desde dentro del contenedor del proyecto. Para acceder al mismo se ejecuta el siguiente comando:
```shell
docker exec -it <NOMBRE PROYECTO> bash
```

## Instalación en Máquina Host (Ubuntu)
 * Instalar [Apache](https://help.ubuntu.com/lts/serverguide/httpd.html) o [manualmente](https://httpd.apache.org/docs/current/es/install.html)
 * Instalar [PHP] (http://php.net/manual/en/install.unix.debian.php) o [manualmente] (http://php.net/manual/es/install.php)
 * Instalar [Postgres] (https://www.postgresql.org/download/linux/ubuntu/) o [manualmente] (https://www.postgresql.org/docs/current/static/install-procedure.html)
 * Instalar [Subversion](https://subversion.apache.org/packages.html) y/o [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
 * Instalar [Graphviz](http://graphviz.org/Download..php)
 * Editar el/los archivos de configuracion de PHP(php.ini) de acuerdo a la plataforma y cambiar las siguientes configuraciones:
   ```
    #Mínimos
    magic_quotes_gpc  =  Off
    magic_quotes_runtime  =  Off

    #Recomendados
    error_reporting  =  E_ALL           #Solo para desarrollo
    display_errors = On                 #Solo para desarrollo
    memory_limit = 512M
    post_max_size = 8 M
    upload_max_filesize = 8 M
   ```
 * Instalar o activar las siguientes extensiones de PHP
 
   ```
    extension=curl.so
    extension=gd.so
    extension=json.so
    extension=pdo.so
    extension=pdo_pgsql.so
    extension=mbstring.so
    extension=mcrypt.so
    extension=phar.so
    extension=xsl.so
    extension=xmlwriter.so
    extension=xmlreader.so
    extension=zip.so
    extension=zlib.so        
   ```
 * Ejecutar los comandos 
 
   ```shell
    export TOBA_INSTANCIA=desarrollo    
    bin/toba instalacion instalar
   ```     
   E indicar los valores para los parametros solicitados

##Creación del proyecto
 * Ejecutar el comando
 
   ```shell
    bin/toba proyecto crear -p <NOMBRE PROYECTO> -d `pwd`
   ```
 * Crear un link simbolico al archivo ``instalacion/toba.conf`` para que Apache pueda servirlo
 
   ```shell
    sudo ln -s `pwd`/instalacion/toba.conf  /etc/apache2/sites-available/<NOMBRE PROYECTO>.conf
   ```
 * Activar el sitio en la configuración de Apache  
 
   ```shell
    sudo a2ensite <NOMBRE PROYECTO>
   ```
 * Reiniciar apache  
 
   ```shell
    service apache2 reload
   ```   
 * Listo, el proyecto ya se puede acceder desde la url ```http://localhost/toba_editor/3.1```.  
    Las credenciales son las que haya incluido en los parametros solicitados
 
    Recomendamos en este punto crear el commit inicial en el CVS. Si no se está usando Git hay que ignorar los directorios y archivos que se ecuentran en el archivo ```.gitignore```, si se utiliza Git no es necesario.  
    
    La estructura del proyecto Toba nuevo quedó en la raíz.

### Trabajando
#### Carpeta de instalación de Toba
Por defecto la carpeta de instalación queda montada en la carpeta llamada ```instalacion``` en la raíz del proyecto.

#### Comandos administrativos
Para persistir las modificaciones realizadas con toba_editor, se recomienda correr los comandos administrativos en interacción con el CVS
  * Ejecutar al abrir una nueva consola el comando 
  
    ```shell
     . instalacion/entorno_toba.env
    ```
  Luego de ello acceder normalmente a los comandos administrativos, mediante el comando lanzador `toba`. 
  
