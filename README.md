# Jokedex

Ceci est une application CRUD simple pour gérer un site de blagues

/!\ Le port utilisé par défaut par le serveur apache est le port 80, veillez a bien le laisser libre ou le changer dans le fichier docker-compose.yml

# Prérequis

## Build des images docker

```
cd docker && ./build.sh
```


## Lancement des containers docker

```
cd docker && docker-compose up -d
```

## Installation des vendors via composer et initialisation de la bdd


```
cd docker && ./exec.sh
su user
cd /var/www/sympho && composer install
php bin/console doctrine:schema:update --force
```

# To Do

* Ajouter un login admin pour l'édit/delete (SecurityComponent)

* Limiter le nombre de like/dislike par joke (check ip ?)

* Utiliser l'attribut genre pour trier les jokes

* Utiliser DoctrineFixturesBundle avoir des valeurs de base dans la bdd
