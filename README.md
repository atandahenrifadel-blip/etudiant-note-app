# Application Étudiant & Note — démonstration DevOps / DevSecOps

## 1. Objectif du projet

Application web simple de gestion d'étudiants et de leurs notes,
dont le **vrai objectif pédagogique** est de démontrer, à travers un
cas concret, les pratiques **DevOps** et **DevSecOps**.

## 2. Modèle de données (l'association)

```
Etudiant (1) ────< (N) Note
```

Un **Étudiant** possède plusieurs **Notes**. Chaque **Note** appartient
à un seul **Étudiant**. C'est une relation "1 à N" (`hasMany` /
`belongsTo` dans le code Laravel), implémentée par une clé étrangère
`etudiant_id` dans la table `notes`.

## 3. Stack technique

- Laravel 11 (PHP 8.3)
- MySQL 8
- Docker / docker-compose
- GitHub Actions (CI/CD)

## 4. Où voit-on le thème DevOps / DevSecOps ?

| Pratique | Où dans le projet |
|---|---|
| Versionning de la base de données | `database/migrations/` |
| Tests automatisés | `tests/Feature/EtudiantTest.php` |
| Conteneurisation | `Dockerfile`, `docker-compose.yml` |
| Intégration Continue (CI) | `.github/workflows/ci-cd.yml`, job `test` |
| Déploiement Continu (CD) | `.github/workflows/ci-cd.yml`, job `deploy` |
| Audit des dépendances (DevSecOps) | job `security` → `composer audit` |
| Analyse statique du code / SAST (DevSecOps) | job `security` → PHPStan |
| Détection de secrets exposés (DevSecOps) | job `security` → Gitleaks |
| Scan de vulnérabilités de l'image (DevSecOps) | job `build-and-scan` → Trivy |
| Utilisateur non-root dans le conteneur (DevSecOps) | `Dockerfile` |
| Secrets hors du code source | `.env` (ignoré par Git), `.env.example` versionné |

## 5. Lancer le projet en local (avec Docker)

```bash
# 1. Copier le fichier d'environnement
cp .env.example .env

# 2. Construire et démarrer les conteneurs (app + nginx + mysql)
docker compose up -d --build

# 3. Installer les dépendances PHP (si pas déjà fait dans l'image)
docker compose exec app composer install

# 4. Générer la clé d'application Laravel
docker compose exec app php artisan key:generate

# 5. Exécuter les migrations (crée les tables etudiants et notes)
docker compose exec app php artisan migrate

# L'application est accessible sur http://localhost:8080
```

## 6. Lancer les tests

```bash
docker compose exec app php artisan test
```

## 7. Fonctionnement du pipeline CI/CD

À chaque `git push` sur la branche `main`, GitHub Actions exécute automatiquement,
dans cet ordre :

1. **test** : installe les dépendances, migre une base MySQL de test, lance PHPUnit.
2. **security** (en parallèle) : `composer audit`, PHPStan, Gitleaks.
3. **build-and-scan** : construit l'image Docker puis la scanne avec Trivy
   (attend que `test` ET `security` réussissent).
4. **deploy** : simule le déploiement final (attend que `build-and-scan` réussisse).

Si une étape échoue, les suivantes ne se lancent pas : c'est le principe
du pipeline qui **empêche automatiquement** du code non testé ou non
sécurisé d'atteindre la production.

## 8. Structure du projet

```
etudiant-note-app/
├── app/
│   ├── Models/            (Etudiant.php, Note.php)
│   └── Http/Controllers/  (EtudiantController.php, NoteController.php)
├── database/migrations/   (structure des tables versionnée)
├── resources/views/       (interface HTML/Blade)
├── routes/web.php
├── tests/Feature/         (tests automatisés)
├── docker/nginx.conf
├── Dockerfile
├── docker-compose.yml
├── .github/workflows/ci-cd.yml   (pipeline CI/CD)
├── .env.example
└── .gitignore
```
