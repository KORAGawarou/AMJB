# AMJB - Plateforme Web

Plateforme web professionnelle pour l'Association de la Mairie des Jeunes du Bénin.

## 🚀 Fonctionnalités

- ✅ Authentification sécurisée (inscription, connexion)
- ✅ Gestion des utilisateurs et profils
- ✅ Gestion des événements
- ✅ Blog et actualités
- ✅ Galerie photos
- ✅ Système de messagerie/contact
- ✅ Tableau de bord administrateur
- ✅ Design responsive (mobile, tablette, desktop)
- ✅ Base de données MySQL

## 📋 Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Apache avec mod_rewrite
- Serveur local (XAMPP, WAMP, LAMP) ou d'hébergement

## 📥 Installation

### 1. Créer la base de données

```bash
mysql -u root -p < database/amjb.sql
```

### 2. Configurer la connexion BD

Modifiez `php/config.php` avec vos paramètres:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'amjb');
```

### 3. Créer les dossiers d'upload

```bash
mkdir -p uploads/{events,gallery,blog,profiles}
chmod 755 uploads/*
```

### 4. Accéder à la plateforme

```
http://localhost/AMJB/
```

## 👤 Comptes de Test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@amjb.bj | admin123 |
| Modérateur | modo@amjb.bj | modo123 |
| Membre | membre@amjb.bj | membre123 |

## 📁 Structure du Projet

```
AMJB/
├── index.php                    # Page d'accueil
├── php/
│   ├── config.php              # Configuration
│   ├── database.php            # Classe BD
│   ├── auth.php                # Authentification
│   └── functions.php           # Fonctions utiles
├── pages/
│   ├── login.php               # Connexion
│   ├── register.php            # Inscription
│   ├── profile.php             # Profil utilisateur
│   ├── members.php             # Liste des membres
│   ├── events.php              # Événements
│   ├── blog.php                # Blog
│   ├── gallery.php             # Galerie
│   └── contact.php             # Contact
├── admin/
│   ├── index.php               # Tableau de bord
│   ├── members.php             # Gestion membres
│   ├── events.php              # Gestion événements
│   ├── blog.php                # Gestion blog
│   ├── gallery.php             # Gestion galerie
│   └── messages.php            # Gestion messages
├── assets/
│   ├── css/
│   │   ├── style.css           # Styles principaux
│   │   └── responsive.css      # Styles responsive
│   └── js/
│       └── main.js             # JavaScript principal
├── database/
│   └── amjb.sql                # Script SQL
└── uploads/                    # Dossier d'upload
```

## 🔐 Sécurité

- Mots de passe hachés avec bcrypt
- Protection CSRF sur tous les formulaires
- Validation et nettoyage des entrées
- Utilisation de prepared statements (PDO)
- Sessions sécurisées

## 🛠️ Technologies

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP 7.4+
- **Base de données**: MySQL
- **Architecture**: MVC

## 📝 Pages Publiques

- `index.php` - Accueil avec statistiques
- `pages/login.php` - Connexion
- `pages/register.php` - Inscription
- `pages/members.php` - Annuaire des membres
- `pages/events.php` - Liste des événements
- `pages/blog.php` - Blog et actualités
- `pages/gallery.php` - Galerie photos
- `pages/contact.php` - Formulaire de contact
- `pages/profile.php` - Profil utilisateur (connecté)

## 🔧 Pages Admin

- `admin/index.php` - Tableau de bord
- `admin/members.php` - Gestion des utilisateurs
- `admin/events.php` - Gestion des événements
- `admin/blog.php` - Gestion du blog
- `admin/gallery.php` - Gestion de la galerie
- `admin/messages.php` - Gestion des messages

## 🎨 Personnalisation

### Changer les couleurs

Modifiez les variables CSS dans `assets/css/style.css`:

```css
:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    /* ... */
}
```

### Ajouter un logo

Remplacez le texte dans la navigation par une balise `<img>`:

```html
<img src="path/to/logo.png" alt="Logo AMJB" style="height: 40px;">
```

## 📞 Support

Pour toute question ou problème, contactez: `contact@amjb.bj`

## 📄 Licence

Ce projet est fourni à titre d'exemple éducatif.

---

**Développé pour l'Association de la Mairie des Jeunes du Bénin** ❤️
