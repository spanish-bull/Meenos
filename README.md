# Meenos

## Objectif
Créer un portail permettant à une / des communauté(s) de faire voter en ligne des conférences par ses membres.

## Planning
Lancement : 11 février 2019\
Rendu : 15 février à 23h59

## Fonctionnalités

## Installation
**Etape 1 :**
docker-compose up -d

**Etape 2 :**
dupliquez le .env-dist en .env\
changez les champs login, pwd, database_name\

`DATABASE_URL=mysql://{login}:{pwd}@database:3306/{database_name}`

**Etape 3 :**
docker-compose run composer composer install

## Accès
**Site :**
http://localhost/

**Adminer :**
http://localhost:8080/

**Mailhog :**
http://localhost:8025/