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
docker-compose run composer composer install

**Etape 3 :**
modifier le .env
DATABASE_URL=mysql://root:root@database:3306/meenos

## Accès
**Site :**
http://localhost/

**Adminer :**
http://localhost:8080/

**Mailhog :**
http://localhost:8025/