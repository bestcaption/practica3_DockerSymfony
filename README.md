# practica3_DockerSymfony
Lo primero que hay que hacer es montar una estructura de archivos con carpetas.
Creamos el docker-compose donde crearemos nuestros "Servicios", ahora vamos con el servidor en este caso Nginx.
Adicionalmente colocamos una red llamada symfony para poder conectar los diferentes contenedores entre si, a continuacion debemos añadir el servicio php.
Nos hara falta una base de datos, en mi caso uso MYSQL.
Ahora creamos el Dockerfile-php.

Lo que hacemos es usar una imagen de docker hub e instalamos un par de herramientas como composer que es un manejador de dependencias para php :
Dockerfile-ngnix

Tenemos que añadir la configuracion del server :
default.conf

Levantamos los servicios desde la terminal :
docker-compose up -d --build

Esto construirá y creará los contenedores que puedes ver usando docker-compose ps

Llegados a este paso tendremos que instalar Symfony:
    debemos entrar al contenedor de php que creamos usando:
        docker-compose exec php bash

utilizamos : 
composer create-project symfony/website-skeleton .
y vamos al buscador y ponemos la ip con el puerto 8001 y nos aparecera la pagina de symfony

