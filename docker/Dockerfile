# syntax=docker/dockerfile:1.0-experimental
ARG APP
ARG COMPOSER_CACHE_DIR=../composer-cache

# stage base
FROM siudocker/php:8.1-cli-v1.0.2 as base

RUN apk --no-cache add \
    git yarn php81-xmlreader

WORKDIR /usr/local/build

RUN curl -sS "https://getcomposer.org/download/latest-2.x/composer.phar" -o /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

#VER ESTO https://github.com/moby/buildkit/issues/1009#issuecomment-492868494
RUN echo "composer optimizado" \
    && composer config -g cache-dir $COMPOSER_CACHE_DIR 


########################################################################################################################
# stage source <PROYECTO>
########################################################################################################################
FROM base as src-<PROYECTO>

COPY docker /usr/local/build/docker

COPY ./composer.json /usr/local/build/<PROYECTO>/composer.json
COPY ./composer.lock /usr/local/build/<PROYECTO>/composer.lock

RUN composer install -d ./<PROYECTO> --no-dev --ignore-platform-reqs --prefer-dist --no-progress -n --no-autoloader --no-scripts

COPY <PROYECTO> /usr/local/build/<PROYECTO>

RUN echo "composer autoload" \
    # https://getcomposer.org/doc/articles/autoloader-optimization.md
    && composer dump-autoload -d ./<PROYECTO> --apcu \
    && composer run-script post-install-cmd -d ./<PROYECTO>

RUN echo "preparar el proyecto" \
    && cp -R ./<PROYECTO>/templates/app/instalacion <PROYECTO>/instalacion \
    && cp ./<PROYECTO>/templates/app/entorno_toba.env <PROYECTO>/entorno_toba.env \
    && cp -R ./<PROYECTO>/templates/app/www <PROYECTO>/www/ \
    && echo > ./<PROYECTO>/<PROYECTO>.log

RUN echo "eliminar archivos innecesarios para alivianar la imagen" \
    && rm -R ./<PROYECTO>/vendor/siu-toba/framework/proyectos \
    && rm -R ./<PROYECTO>/vendor/siu-toba/framework/php/modelo/ddl/mysql \
    && rm -R ./<PROYECTO>/vendor/siu-toba/framework/php/3ros/jpgraph \
    && rm -R ./<PROYECTO>/vendor/siu-toba/framework/php/3ros/poidsy \
    && rm -R ./<PROYECTO>/vendor/siu-toba/framework/php/3ros/PHP* \
    && rm -R ./<PROYECTO>/vendor/siu-toba/framework/www/firmador_pdf \
    && rm -R ./<PROYECTO>/vendor/siu-toba/framework/www/swagger \
    && find . -type d -name ".git" | xargs rm -rf


########################################################################################################################
# stage DEVELOP (final)                                                                                                    #
########################################################################################################################
FROM siudocker/php:8.1-web-v1.0.2 as dev

COPY --from=src-<PROYECTO> --chown=apache:apache /usr/local/build /usr/local/app

RUN echo "ajustes de apache" \
    && cp /usr/local/app/<PROYECTO>/templates/app/vhost.conf /etc/apache2/conf.d/vhost-<PROYECTO>.conf

RUN rm -Rf composer-cache

########################################################################################################################
# stage PROD (final)
########################################################################################################################
FROM siudocker/php:8.0-web-rootless-v1.0.2 as prod

USER root

COPY --from=src-<PROYECTO> --chown=apache:apache /usr/local/build /usr/local/app

## Ventana para incorporar librerias o extensiones faltantes, solo agregar indispensables
RUN apk --no-cache add -U openssl 

RUN echo "ajustes de apache" \
    && cp /usr/local/app/<PROYECTO>/templates/app/vhost-all.conf /etc/apache2/conf.d/vhost-all.conf

RUN rm -Rf composer-cache

ARG HOME=/usr/local/app
ARG USER=siu
ENV HOME=$HOME
ENV USER=$USER
USER $USER


########################################################################################################################
# stage FINAL                                                                                                          #
########################################################################################################################
FROM ${APP} as final

LABEL org.opencontainers.image.authors="mail@authors.me"

USER $USER

WORKDIR /usr/local/app
 
