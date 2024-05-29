si vous utiliser docker c'est le fichier docker-compose.yaml sans Mysql
il suffit de copier le dossier du projet à côté de ce fichier docker compose
et de le renommer par projetc après lancer la commande docker compose up -d
Attention n'oublier pas de connecter ce container avec votre container Mysql
par la commande docker network connect <network-name-1> <network-name-2>


docker-compose.yaml

services:
    php:
        container_name: IHM
        build: php
        ports:
            - "9000:8000"
        volumes:
            - ./project:/var/www/
        networks:
            - backend
networks:
    backend:
