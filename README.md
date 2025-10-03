# 🏫 Application de Gestion de Crèche

Application web développée en **Symfony**, **Twig**, **JavaScript** et **SCSS**, avec une base de données **MySQL**, permettant de gérer le fonctionnement d’une crèche : inscriptions, suivi des enfants, gestion du personnel et des plannings.

---

## 🚀 Fonctionnalités principales
- 👶 **Gestion des enfants** : ajout, modification, suppression, suivi des informations personnelles.
- 👩‍🏫 **Gestion du personnel** : création et suivi des éducateurs et employés.
- 📅 **Plannings & activités** : gestion des présences, affectations et programmes d’activités.
- 📝 **Tableau de bord** : vue d’ensemble des enfants présents, des tâches et des rendez-vous.
- 🔐 **Authentification & rôles** :
  - Admin : accès complet à toutes les fonctionnalités.
  - Personnel : accès limité aux enfants et plannings.
  - Parents : accès aux informations de leurs enfants.
- 📊 **Statistiques** : suivi de fréquentation et répartition par âge.

---

## 🛠️ Technologies utilisées
- **Framework backend** : [Symfony](https://symfony.com/)
- **Moteur de templates** : [Twig](https://twig.symfony.com/)
- **Frontend** : JavaScript, SCSS (compilé en CSS)
- **Base de données** : MySQL
- **ORM** : Doctrine

---

## 📥 Installation & Lancement

### 1. Cloner le projet
```bash
git clone https://github.com/thomasr10/Infantia.git
```
### 2. Installer les dépendances
```bash
composer install
```

### 3. Configurer l'environnement local
- Créer un fichier .env.local
- Gérer la connexion avec la BDD

### 4. Créer la base de données
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Lancer le serveur de développement
```bash
symfony server:start -d
```
