# SoutenancePro

Application web de gestion des soutenances de fin d'études, développée avec Symfony 7.2.

## Présentation

SoutenancePro permet à une université de gérer :
- les étudiants et leurs mémoires
- les enseignants
- les salles
- les soutenances et la constitution des jurys
- les statistiques du système
- l'accès sécurisé selon deux rôles : Administrateur et Enseignant

## Prérequis

- PHP 8.3 ou supérieur
- Composer
- MySQL 8.x (ou MariaDB)
- Symfony CLI (recommandé)

## Installation

### 1. Cloner le dépôt

```bash
git clone <url-du-depot>
cd soutenancepro
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer la base de données

Créer un fichier `.env.local` à la racine du projet avec votre configuration :

```
DATABASE_URL="mysql://VOTRE_UTILISATEUR:VOTRE_MOT_DE_PASSE@127.0.0.1:3306/soutenancepro_db?serverVersion=8.0&charset=utf8mb4"
```

### 4. Créer la base de données et exécuter les migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Lancer le serveur

```bash
php -S localhost:8000 -t public/
```

ou avec Symfony CLI :

```bash
symfony serve
```

L'application est accessible sur : `http://localhost:8000`

## Comptes de test

### Espace Administrateur
- URL : `http://localhost:8000/administrateur/login`
- Email : `admin@soutenancepro.com`
- Mot de passe : `admin123`

### Espace Enseignant
- URL : `http://localhost:8000/enseignant/login`
- Email : (à créer via l'espace Administrateur)
- Mot de passe par défaut : `enseignant123`

## Structure du projet

- `src/Entity/` : Etudiant, Enseignant, Salle, Soutenance, Admin
- `src/Controller/` : contrôleurs Administrateur et Enseignant
- `src/Security/` : authentificateurs personnalisés (Admin et Enseignant)
- `templates/` : vues Twig (sidebar, formulaires, pages)
- `public/css/app.css` : feuille de style globale

## Fonctionnalités principales

- Authentification séparée pour deux espaces (Administrateur / Enseignant)
- Gestion CRUD complète : étudiants, enseignants, salles, soutenances
- Recherche d'étudiants par nom et de soutenances par date
- Règles de gestion : unicité des emails et codes de salle, capacité positive
- Règles métier : interdiction de double réservation de salle ou d'enseignant sur un même créneau
- Tableaux de bord avec statistiques (Administrateur) et suivi personnel (Enseignant)

## Technologies utilisées

- Symfony 7.2
- Doctrine ORM
- Twig
- MySQL
- Symfony Security (authentification à deux espaces distincts)
