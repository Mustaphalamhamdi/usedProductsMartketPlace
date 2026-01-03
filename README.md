# SouqCycle - Used Products Marketplace
### Marché de Produits d'Occasion

---

## 🇬🇧 English Version

### 📋 Table of Contents
- [About](#about)
- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation Guide](#installation-guide)
- [Configuration](#configuration)
- [Running the Project](#running-the-project)
- [Troubleshooting](#troubleshooting)
- [Project Structure](#project-structure)

---

### 📖 About
SouqCycle is a web-based marketplace platform for buying and selling used products. Built with PHP and MySQL, it provides a simple and efficient way for users to manage their product listings.

### ✨ Features
- User registration and authentication
- Product listing with image upload
- Category management
- Admin dashboard
- User profile management
- Product search and filtering

### 🔧 Prerequisites

Before installing this project, make sure you have the following installed on your computer:

1. **PHP** (version 7.4 or higher)
   - Download from: https://www.php.net/downloads
   - Or install via package manager

2. **MySQL** (version 5.7 or higher) or **MariaDB**
   - Download from: https://dev.mysql.com/downloads/
   - Or use XAMPP/WAMP which includes MySQL

3. **Apache Web Server** or **Nginx**
   - Recommended: Use XAMPP, WAMP, or MAMP which includes Apache, PHP, and MySQL
   - XAMPP download: https://www.apachefriends.org/

4. **Git** (optional, for cloning the repository)
   - Download from: https://git-scm.com/downloads

### 📥 Installation Guide

#### Option 1: Using XAMPP (Recommended for Beginners)

1. **Install XAMPP**
   - Download XAMPP from https://www.apachefriends.org/
   - Install it on your computer (default location: `C:\xampp` on Windows)
   - Start XAMPP Control Panel

2. **Clone or Download the Project**

   Using Git:
   ```bash
   cd C:\xampp\htdocs
   git clone <repository-url> souqcycle
   ```

   Or download ZIP:
   - Download the project as ZIP
   - Extract it to `C:\xampp\htdocs\souqcycle`

3. **Start Required Services**
   - Open XAMPP Control Panel
   - Click "Start" for **Apache**
   - Click "Start" for **MySQL**

4. **Create the Database**

   The database will be created automatically when you first run the application, but you can also create it manually:

   - Open your browser and go to: http://localhost/phpmyadmin
   - Click on "New" in the left sidebar
   - Enter database name: `souqcycle`
   - Click "Create"

5. **Configure Database Connection**

   Open `config/database.php` and verify the settings:
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "root";
   private $password = "";  // Default is empty for XAMPP
   ```

6. **Set Folder Permissions**

   Make sure the `uploads` folder is writable:
   - Right-click on the `uploads` folder
   - Properties → Security → Edit
   - Allow "Full control" for Users

7. **Access the Application**

   Open your browser and navigate to:
   ```
   http://localhost/souqcycle
   ```

#### Option 2: Using Command Line (Advanced Users)

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd souqcycle
   ```

2. **Install PHP and MySQL**

   On Ubuntu/Debian:
   ```bash
   sudo apt update
   sudo apt install php php-mysql php-gd php-mbstring php-xml
   sudo apt install mysql-server
   ```

   On macOS:
   ```bash
   brew install php
   brew install mysql
   ```

3. **Start MySQL Service**

   Ubuntu/Debian:
   ```bash
   sudo service mysql start
   ```

   macOS:
   ```bash
   brew services start mysql
   ```

4. **Create Database**
   ```bash
   mysql -u root -p
   ```
   ```sql
   CREATE DATABASE souqcycle;
   EXIT;
   ```

5. **Configure Database**

   Edit `config/database.php` with your MySQL credentials:
   ```php
   private $username = "your_mysql_username";
   private $password = "your_mysql_password";
   ```

6. **Set Permissions**
   ```bash
   chmod -R 755 .
   chmod -R 777 uploads
   ```

7. **Run PHP Development Server**
   ```bash
   php -S localhost:8000
   ```

8. **Access the Application**
   ```
   http://localhost:8000
   ```

### ⚙️ Configuration

#### Database Configuration
Edit `config/database.php`:
```php
private $host = "localhost";        // Database host
private $db_name = "souqcycle";     // Database name
private $username = "root";          // MySQL username
private $password = "";              // MySQL password
```

#### File Upload Settings
The application stores uploaded images in:
- `uploads/products/` - Product images

Make sure these directories exist and have write permissions.

### 🚀 Running the Project

1. **Start Web Server and Database**
   - XAMPP users: Start Apache and MySQL from XAMPP Control Panel
   - Command line users: Ensure MySQL service is running

2. **Open in Browser**
   - XAMPP: `http://localhost/souqcycle`
   - PHP dev server: `http://localhost:8000`

3. **First Time Setup**
   - The application will automatically create necessary database tables
   - Register a new user account
   - Start listing products!

### 🔍 Troubleshooting

#### Problem: "Connection Error" or "Database connection failed"
**Solution:**
- Verify MySQL is running
- Check database credentials in `config/database.php`
- Make sure database `souqcycle` exists

#### Problem: "Permission denied" when uploading images
**Solution:**
- Make sure `uploads` folder has write permissions
- Windows: Right-click → Properties → Security → Allow "Full control"
- Linux/Mac: `chmod -R 777 uploads`

#### Problem: "Page not found" or "404 Error"
**Solution:**
- Check that you're accessing the correct URL
- XAMPP: Make sure files are in `htdocs` folder
- Verify Apache/Web server is running

#### Problem: "Headers already sent" error
**Solution:**
- Make sure there are no spaces or characters before `<?php` tags
- Check for UTF-8 BOM in files (use an editor like VS Code)

#### Problem: Images not displaying after upload
**Solution:**
- Check folder permissions on `uploads/products/`
- Verify the path in your browser's developer tools
- Ensure PHP `upload_max_filesize` and `post_max_size` are adequate

### 📁 Project Structure

```
souqcycle/
├── assets/              # CSS, JS, and static files
├── config/              # Configuration files
│   └── database.php     # Database connection
├── controllers/         # Application controllers
│   ├── AdminController.php
│   ├── CategoryController.php
│   ├── ProductController.php
│   └── UserController.php
├── models/              # Data models
│   ├── Admin.php
│   ├── Category.php
│   ├── Database.php
│   ├── Product.php
│   ├── ProductImage.php
│   └── User.php
├── uploads/             # User uploaded files
│   └── products/        # Product images
├── views/               # View templates
│   ├── admin/           # Admin panel views
│   ├── includes/        # Reusable components
│   ├── product/         # Product views
│   └── user/            # User views
└── index.php            # Main entry point
```

---

## 🇫🇷 Version Française

### 📋 Table des Matières
- [À Propos](#à-propos)
- [Fonctionnalités](#fonctionnalités)
- [Prérequis](#prérequis)
- [Guide d'Installation](#guide-dinstallation)
- [Configuration](#configuration-fr)
- [Lancer le Projet](#lancer-le-projet)
- [Dépannage](#dépannage)
- [Structure du Projet](#structure-du-projet)

---

### 📖 À Propos
SouqCycle est une plateforme de marketplace en ligne pour acheter et vendre des produits d'occasion. Développée avec PHP et MySQL, elle offre un moyen simple et efficace pour les utilisateurs de gérer leurs annonces de produits.

### ✨ Fonctionnalités
- Inscription et authentification des utilisateurs
- Liste de produits avec téléchargement d'images
- Gestion des catégories
- Tableau de bord administrateur
- Gestion du profil utilisateur
- Recherche et filtrage de produits

### 🔧 Prérequis

Avant d'installer ce projet, assurez-vous d'avoir les éléments suivants installés sur votre ordinateur :

1. **PHP** (version 7.4 ou supérieure)
   - Télécharger depuis : https://www.php.net/downloads
   - Ou installer via gestionnaire de paquets

2. **MySQL** (version 5.7 ou supérieure) ou **MariaDB**
   - Télécharger depuis : https://dev.mysql.com/downloads/
   - Ou utiliser XAMPP/WAMP qui inclut MySQL

3. **Serveur Web Apache** ou **Nginx**
   - Recommandé : Utiliser XAMPP, WAMP ou MAMP qui incluent Apache, PHP et MySQL
   - Téléchargement XAMPP : https://www.apachefriends.org/

4. **Git** (optionnel, pour cloner le dépôt)
   - Télécharger depuis : https://git-scm.com/downloads

### 📥 Guide d'Installation

#### Option 1 : Utilisation de XAMPP (Recommandé pour Débutants)

1. **Installer XAMPP**
   - Téléchargez XAMPP depuis https://www.apachefriends.org/
   - Installez-le sur votre ordinateur (emplacement par défaut : `C:\xampp` sur Windows)
   - Démarrez le Panneau de Contrôle XAMPP

2. **Cloner ou Télécharger le Projet**

   Avec Git :
   ```bash
   cd C:\xampp\htdocs
   git clone <url-du-dépôt> souqcycle
   ```

   Ou téléchargement ZIP :
   - Téléchargez le projet en ZIP
   - Extrayez-le dans `C:\xampp\htdocs\souqcycle`

3. **Démarrer les Services Requis**
   - Ouvrez le Panneau de Contrôle XAMPP
   - Cliquez sur "Start" pour **Apache**
   - Cliquez sur "Start" pour **MySQL**

4. **Créer la Base de Données**

   La base de données sera créée automatiquement lors de la première exécution de l'application, mais vous pouvez aussi la créer manuellement :

   - Ouvrez votre navigateur et allez sur : http://localhost/phpmyadmin
   - Cliquez sur "Nouvelle base de données" dans la barre latérale gauche
   - Entrez le nom de la base de données : `souqcycle`
   - Cliquez sur "Créer"

5. **Configurer la Connexion à la Base de Données**

   Ouvrez `config/database.php` et vérifiez les paramètres :
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "root";
   private $password = "";  // Par défaut vide pour XAMPP
   ```

6. **Définir les Permissions des Dossiers**

   Assurez-vous que le dossier `uploads` est accessible en écriture :
   - Clic droit sur le dossier `uploads`
   - Propriétés → Sécurité → Modifier
   - Autoriser "Contrôle total" pour les Utilisateurs

7. **Accéder à l'Application**

   Ouvrez votre navigateur et naviguez vers :
   ```
   http://localhost/souqcycle
   ```

#### Option 2 : Utilisation de la Ligne de Commande (Utilisateurs Avancés)

1. **Cloner le Dépôt**
   ```bash
   git clone <url-du-dépôt>
   cd souqcycle
   ```

2. **Installer PHP et MySQL**

   Sur Ubuntu/Debian :
   ```bash
   sudo apt update
   sudo apt install php php-mysql php-gd php-mbstring php-xml
   sudo apt install mysql-server
   ```

   Sur macOS :
   ```bash
   brew install php
   brew install mysql
   ```

3. **Démarrer le Service MySQL**

   Ubuntu/Debian :
   ```bash
   sudo service mysql start
   ```

   macOS :
   ```bash
   brew services start mysql
   ```

4. **Créer la Base de Données**
   ```bash
   mysql -u root -p
   ```
   ```sql
   CREATE DATABASE souqcycle;
   EXIT;
   ```

5. **Configurer la Base de Données**

   Modifiez `config/database.php` avec vos identifiants MySQL :
   ```php
   private $username = "votre_nom_utilisateur_mysql";
   private $password = "votre_mot_de_passe";
   ```

6. **Définir les Permissions**
   ```bash
   chmod -R 755 .
   chmod -R 777 uploads
   ```

7. **Lancer le Serveur de Développement PHP**
   ```bash
   php -S localhost:8000
   ```

8. **Accéder à l'Application**
   ```
   http://localhost:8000
   ```

### ⚙️ Configuration {#configuration-fr}

#### Configuration de la Base de Données
Modifiez `config/database.php` :
```php
private $host = "localhost";        // Hôte de la base de données
private $db_name = "souqcycle";     // Nom de la base de données
private $username = "root";          // Nom d'utilisateur MySQL
private $password = "";              // Mot de passe MySQL
```

#### Paramètres de Téléchargement de Fichiers
L'application stocke les images téléchargées dans :
- `uploads/products/` - Images des produits

Assurez-vous que ces répertoires existent et ont les permissions d'écriture.

### 🚀 Lancer le Projet

1. **Démarrer le Serveur Web et la Base de Données**
   - Utilisateurs XAMPP : Démarrez Apache et MySQL depuis le Panneau de Contrôle XAMPP
   - Utilisateurs ligne de commande : Assurez-vous que le service MySQL est en cours d'exécution

2. **Ouvrir dans le Navigateur**
   - XAMPP : `http://localhost/souqcycle`
   - Serveur dev PHP : `http://localhost:8000`

3. **Configuration Initiale**
   - L'application créera automatiquement les tables de base de données nécessaires
   - Inscrivez un nouveau compte utilisateur
   - Commencez à lister des produits !

### 🔍 Dépannage

#### Problème : "Connection Error" ou "Échec de connexion à la base de données"
**Solution :**
- Vérifiez que MySQL est en cours d'exécution
- Vérifiez les identifiants de la base de données dans `config/database.php`
- Assurez-vous que la base de données `souqcycle` existe

#### Problème : "Permission refusée" lors du téléchargement d'images
**Solution :**
- Assurez-vous que le dossier `uploads` a les permissions d'écriture
- Windows : Clic droit → Propriétés → Sécurité → Autoriser "Contrôle total"
- Linux/Mac : `chmod -R 777 uploads`

#### Problème : "Page introuvable" ou "Erreur 404"
**Solution :**
- Vérifiez que vous accédez à la bonne URL
- XAMPP : Assurez-vous que les fichiers sont dans le dossier `htdocs`
- Vérifiez qu'Apache/le serveur web est en cours d'exécution

#### Problème : Erreur "Headers already sent"
**Solution :**
- Assurez-vous qu'il n'y a pas d'espaces ou de caractères avant les balises `<?php`
- Vérifiez la présence de BOM UTF-8 dans les fichiers (utilisez un éditeur comme VS Code)

#### Problème : Les images ne s'affichent pas après le téléchargement
**Solution :**
- Vérifiez les permissions du dossier `uploads/products/`
- Vérifiez le chemin dans les outils de développement de votre navigateur
- Assurez-vous que `upload_max_filesize` et `post_max_size` de PHP sont adéquats

### 📁 Structure du Projet

```
souqcycle/
├── assets/              # CSS, JS et fichiers statiques
├── config/              # Fichiers de configuration
│   └── database.php     # Connexion à la base de données
├── controllers/         # Contrôleurs de l'application
│   ├── AdminController.php
│   ├── CategoryController.php
│   ├── ProductController.php
│   └── UserController.php
├── models/              # Modèles de données
│   ├── Admin.php
│   ├── Category.php
│   ├── Database.php
│   ├── Product.php
│   ├── ProductImage.php
│   └── User.php
├── uploads/             # Fichiers téléchargés par les utilisateurs
│   └── products/        # Images des produits
├── views/               # Templates de vue
│   ├── admin/           # Vues du panneau admin
│   ├── includes/        # Composants réutilisables
│   ├── product/         # Vues des produits
│   └── user/            # Vues utilisateur
└── index.php            # Point d'entrée principal
```

---

## 👨‍💻 Author / Auteur

**Mustapha Lamhamdi**

## 📝 License / Licence

This project is open source and available for educational purposes.

Ce projet est open source et disponible à des fins éducatives.

---

## 🆘 Support

If you encounter any issues or have questions:
- Check the troubleshooting section above
- Review the configuration settings
- Ensure all prerequisites are properly installed

Si vous rencontrez des problèmes ou avez des questions :
- Consultez la section dépannage ci-dessus
- Vérifiez les paramètres de configuration
- Assurez-vous que tous les prérequis sont correctement installés
