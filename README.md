# Twitte-mais-eTwitSport

## Groupe
Le groupe est composé de Hugo Lantillon, Romain Loire et Cédric Lesueur.

## Objectifs
Le but du projet est de créé un site ressemblant à twitter mais pour les structures eSportives. <br><br>
La fonctionnalité principale en tant qu'utilisateur (structure/équipe eSportive) sera celle de pouvoir contacter différentes structure dans l'optique de programmer des entrainements (scrims) ou des tournois. <br><br>
Les résultats des tournois pourront ensuite être partagés sur **eTwitSport**.

## Installation...
#### Du projet
Faire `composer install` après avoir cloner le projet. <br>
Puis installer nodejs :
```
      sudo apt-get install curl
      curl -sL https://deb.nodesource.com/setup_10.x | sudo bash -
      sudo apt-get install nodejs
```
Enfin, faire `npm i` pour installer les packages.

#### De la base de données

*<sub>Il faut d'abord modifier le fichier .env qui se trouve dans la racine du projet pour pouvoir accéder à la BDD.</sub>* <br>
*<sub>Les commandes suivantes sont à faire si le projet tourne sous Linux et si mysql est déjà installé/configuré.</sub>*

Il faut commencer par démarrer le service mysql `sudo service mysql start`. <br>
Puis il faut créer la base de données `php bin/console doctrine:database:create`. <br>
Et enfin générer une migration et migrer :
```
   bin/console make:migration
   bin/console doctrine:migration:migrate
```
 

## Spécificitées
* Le code est écrit en **anglais**
* Nomeclature
    * branche : **br**
