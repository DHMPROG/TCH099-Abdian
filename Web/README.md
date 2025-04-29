# Projet Abdian - Guide d'installation et d'utilisation

## Description du Projet

Abdian est une application web de réservation de vols développée dans le cadre d'un projet académique. L'application permet aux utilisateurs de :

- Rechercher des vols selon différents critères (ville de départ, ville d'arrivée, dates, etc.)
- Consulter les détails des vols disponibles
- Réserver des vols en sélectionnant des sièges
- Gérer leur compte utilisateur
- Effectuer des paiements en ligne

### Fonctionnalités principales

1. **Recherche de vols**
   - Interface intuitive pour la recherche de vols
   - Filtres avancés (compagnies aériennes, escales, prix, etc.)
   - Affichage des résultats en temps réel

2. **Réservation**
   - Sélection des sièges avec visualisation de la cabine
   - Gestion des passagers (informations personnelles)
   - Calcul automatique des prix

3. **Gestion des utilisateurs**
   - Inscription et connexion
   - Historique des réservations
   - Gestion du profil

4. **Paiement**
   - Intégration sécurisée des paiements
   - Confirmation de réservation
   - Génération de billets électroniques

## Prérequis
- Docker Desktop installé sur votre machine
- Git (optionnel, pour cloner le projet)

## Installation avec Docker

1. **Cloner le projet** (si vous utilisez Git) :
```bash
git clone [URL_DU_PROJET]
cd TCH099-Abdian/Web
```

2. **Démarrer les conteneurs Docker** :
```bash
docker-compose up -d
```

3. **Vérifier que les conteneurs sont en cours d'exécution** :
```bash
docker ps
```
Vous devriez voir deux conteneurs en cours d'exécution :
- Un pour la base de données MySQL
- Un pour l'application web

## Configuration de la base de données

1. **Se connecter à la base de données** :
```bash
docker exec -it abdian_db mysql -u root -p
```
Mot de passe : `root`

2. **Créer la base de données** :
```sql
CREATE DATABASE abdian_db;
USE abdian_db;
```

3. **Importer les tables** :
```bash
docker exec -i abdian_db mysql -u root -p abdian_db < sql/abdian_tables.sql
```

## Accéder à l'application

1. **Ouvrir votre navigateur** et accéder à :
```
http://localhost:80
```

## Arrêter l'application

Pour arrêter les conteneurs Docker :
```bash
docker-compose down
```

## Dépannage

Si vous rencontrez des problèmes :

1. **Vérifier les logs Docker** :
```bash
docker-compose logs
```

2. **Redémarrer les conteneurs** :
```bash
docker-compose down
docker-compose up -d
```

3. **Vérifier la connexion à la base de données** :
```bash
docker exec -it abdian_db mysql -u root -p
```

## Structure du projet

- `/Web` : Contient les fichiers de l'application web
- `/sql` : Contient les scripts SQL pour la base de données
- `/assets` : Contient les ressources statiques (images, CSS, etc.)
- `/CSS` : Contient les fichiers de style
- `/Scripts` : Contient les scripts JavaScript
- `/controlleurs` : Contient les contrôleurs PHP
- `/modele` : Contient les modèles de données
- `/vues` : Contient les vues de l'application 