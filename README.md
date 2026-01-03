# SouqCycle - Used Products Marketplace
### Marché de Produits d'Occasion

---

## 🇬🇧 English Version

### 📋 Table of Contents
- [About](#about)
- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation Guide](#installation-guide)
  - [Windows Installation](#windows-installation)
  - [Mac Installation](#mac-installation)
  - [Linux Installation](#linux-installation)
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

This project requires:
- **PHP** (version 7.4 or higher)
- **MySQL** (version 5.7 or higher) or MariaDB
- **Apache Web Server**
- **Git** (optional)

Don't worry! The installation guides below will show you how to install all of these easily.

---

### 📥 Installation Guide

## Windows Installation

### Step 1: Download and Install XAMPP

1. **Download XAMPP**
   - Go to https://www.apachefriends.org/
   - Click "Download" for Windows
   - Choose the version with PHP 7.4 or higher
   - Download the installer (approximately 150MB)

2. **Install XAMPP**
   - Run the downloaded installer (e.g., `xampp-windows-x64-installer.exe`)
   - If Windows asks "Do you want to allow this app?", click **Yes**
   - Click **Next** through the setup wizard
   - Choose installation directory (default: `C:\xampp`) - **Remember this location!**
   - Uncheck "Learn more about Bitnami" (optional)
   - Click **Next** and then **Finish**

3. **Start XAMPP Control Panel**
   - Open XAMPP Control Panel from Start Menu or Desktop
   - You should see a list of services (Apache, MySQL, FileZilla, etc.)

### Step 2: Download the Project

**Option A: Using Git (Recommended)**
1. Install Git from https://git-scm.com/download/win if you haven't already
2. Open Command Prompt (Press `Win + R`, type `cmd`, press Enter)
3. Navigate to XAMPP's htdocs folder:
   ```bash
   cd C:\xampp\htdocs
   ```
4. Clone the repository:
   ```bash
   git clone https://github.com/Mustaphalamhamdi/usedProductsMartketPlace.git souqcycle
   ```

**Option B: Download ZIP**
1. Download the project as ZIP from GitHub
2. Extract the ZIP file
3. Copy the extracted folder to `C:\xampp\htdocs\`
4. Rename the folder to `souqcycle`

### Step 3: Start the Servers

1. Open XAMPP Control Panel
2. Click **Start** button next to **Apache** (it will turn green)
3. Click **Start** button next to **MySQL** (it will turn green)
4. If Windows Firewall asks for permission, click **Allow access**

### Step 4: Create the Database

1. Open your web browser (Chrome, Firefox, Edge, etc.)
2. Go to: `http://localhost/phpmyadmin`
3. Click **New** in the left sidebar
4. Enter database name: `souqcycle`
5. Click **Create**

**Note:** The database tables will be created automatically when you first run the application.

### Step 5: Configure Database Connection

1. Open the project folder: `C:\xampp\htdocs\souqcycle`
2. Open `config\database.php` with any text editor (Notepad, VS Code, etc.)
3. Verify these settings (they should already be correct):
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "root";
   private $password = "";  // Leave empty for XAMPP
   ```

### Step 6: Set Folder Permissions

1. Navigate to `C:\xampp\htdocs\souqcycle`
2. Right-click on the `uploads` folder
3. Click **Properties** → **Security** tab → **Edit**
4. Select **Users** and check **Allow** for **Full control**
5. Click **OK** and **Apply**

### Step 7: Access Your Application

1. Open your web browser
2. Go to: `http://localhost/souqcycle`
3. You should see the SouqCycle homepage!

---

## Mac Installation

### Step 1: Download and Install XAMPP (or MAMP)

**Option A: XAMPP (Recommended)**

1. **Download XAMPP**
   - Go to https://www.apachefriends.org/
   - Click "Download" for macOS
   - Choose the version with PHP 7.4 or higher
   - Download the DMG file (approximately 150MB)

2. **Install XAMPP**
   - Open the downloaded DMG file
   - Drag the XAMPP folder to your Applications folder
   - Open **Applications** → **XAMPP**
   - Double-click **manager-osx** to start XAMPP
   - If macOS says "can't be opened", go to System Preferences → Security & Privacy → Click "Open Anyway"

**Option B: MAMP (Alternative)**
1. Download MAMP from https://www.mamp.info/
2. Install by dragging to Applications folder
3. Open MAMP from Applications

### Step 2: Download the Project

**Option A: Using Git (Recommended)**
1. Open **Terminal** (Applications → Utilities → Terminal)
2. Navigate to XAMPP's htdocs folder:
   ```bash
   cd /Applications/XAMPP/htdocs
   ```
   Or for MAMP:
   ```bash
   cd /Applications/MAMP/htdocs
   ```
3. Clone the repository:
   ```bash
   git clone https://github.com/Mustaphalamhamdi/usedProductsMartketPlace.git souqcycle
   ```

**Option B: Download ZIP**
1. Download the project as ZIP from GitHub
2. Extract the ZIP file
3. Open **Finder** → **Applications** → **XAMPP** → **htdocs** (or **MAMP** → **htdocs**)
4. Copy the extracted folder here
5. Rename it to `souqcycle`

### Step 3: Start the Servers

**For XAMPP:**
1. Open XAMPP manager (Applications → XAMPP → manager-osx)
2. Click **Start** for Apache Server
3. Click **Start** for MySQL Database
4. Both should show "Running" status

**For MAMP:**
1. Open MAMP application
2. Click **Start Servers**
3. Wait until both Apache and MySQL show green lights

### Step 4: Create the Database

1. Open your web browser (Safari, Chrome, Firefox, etc.)
2. For XAMPP, go to: `http://localhost/phpmyadmin`
   For MAMP, go to: `http://localhost:8888/phpMyAdmin` (or click "WebStart" in MAMP)
3. Click **New** in the left sidebar
4. Enter database name: `souqcycle`
5. Click **Create**

### Step 5: Configure Database Connection

1. Open **Finder** and navigate to the project:
   - XAMPP: `/Applications/XAMPP/htdocs/souqcycle`
   - MAMP: `/Applications/MAMP/htdocs/souqcycle`
2. Open `config/database.php` with TextEdit or any code editor
3. Verify/Update these settings:

   **For XAMPP:**
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "root";
   private $password = "";  // Leave empty
   ```

   **For MAMP:**
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "root";
   private $password = "root";  // MAMP default password is "root"
   ```

### Step 6: Set Folder Permissions

1. Open **Terminal**
2. Navigate to your project:
   ```bash
   cd /Applications/XAMPP/htdocs/souqcycle
   # or for MAMP:
   # cd /Applications/MAMP/htdocs/souqcycle
   ```
3. Set permissions:
   ```bash
   chmod -R 755 .
   chmod -R 777 uploads
   ```

### Step 7: Access Your Application

1. Open your web browser
2. For XAMPP, go to: `http://localhost/souqcycle`
   For MAMP, go to: `http://localhost:8888/souqcycle`
3. You should see the SouqCycle homepage!

---

## Linux Installation

### Step 1: Install Required Software

**For Ubuntu/Debian:**
```bash
# Update package list
sudo apt update

# Install Apache
sudo apt install apache2

# Install MySQL
sudo apt install mysql-server

# Install PHP and required extensions
sudo apt install php php-mysql php-gd php-mbstring php-xml libapache2-mod-php

# Start services
sudo systemctl start apache2
sudo systemctl start mysql
sudo systemctl enable apache2
sudo systemctl enable mysql
```

**For Fedora/RHEL/CentOS:**
```bash
# Install Apache
sudo dnf install httpd

# Install MySQL
sudo dnf install mysql-server

# Install PHP and extensions
sudo dnf install php php-mysqlnd php-gd php-mbstring php-xml

# Start services
sudo systemctl start httpd
sudo systemctl start mysqld
sudo systemctl enable httpd
sudo systemctl enable mysqld
```

### Step 2: Download the Project

1. Navigate to web directory:
   ```bash
   cd /var/www/html
   ```

2. Clone the repository:
   ```bash
   sudo git clone https://github.com/Mustaphalamhamdi/usedProductsMartketPlace.git souqcycle
   ```

### Step 3: Create Database

1. Access MySQL:
   ```bash
   sudo mysql -u root -p
   ```

2. Create database:
   ```sql
   CREATE DATABASE souqcycle;
   CREATE USER 'souqcycle_user'@'localhost' IDENTIFIED BY 'your_password';
   GRANT ALL PRIVILEGES ON souqcycle.* TO 'souqcycle_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

### Step 4: Configure Database Connection

1. Edit the database configuration:
   ```bash
   sudo nano /var/www/html/souqcycle/config/database.php
   ```

2. Update with your credentials:
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "souqcycle_user";
   private $password = "your_password";
   ```

### Step 5: Set Permissions

```bash
sudo chown -R www-data:www-data /var/www/html/souqcycle
sudo chmod -R 755 /var/www/html/souqcycle
sudo chmod -R 777 /var/www/html/souqcycle/uploads
```

### Step 6: Access Your Application

Open browser and go to: `http://localhost/souqcycle`

---

### ⚙️ Configuration

#### Database Configuration
Edit `config/database.php`:
```php
private $host = "localhost";        // Database host
private $db_name = "souqcycle";     // Database name
private $username = "root";          // MySQL username
private $password = "";              // MySQL password (empty for XAMPP, "root" for MAMP)
```

#### File Upload Settings
The application stores uploaded images in:
- `uploads/products/` - Product images

Make sure this directory exists and has write permissions.

---

### 🚀 Running the Project

1. **Start Web Server and Database**
   - **Windows XAMPP**: Open XAMPP Control Panel → Start Apache & MySQL
   - **Mac XAMPP**: Open XAMPP Manager → Start Apache & MySQL
   - **Mac MAMP**: Open MAMP → Start Servers
   - **Linux**: Services should auto-start, or use `sudo systemctl start apache2 mysql`

2. **Open in Browser**
   - **XAMPP (Win/Mac)**: `http://localhost/souqcycle`
   - **MAMP**: `http://localhost:8888/souqcycle`
   - **Linux**: `http://localhost/souqcycle`

3. **First Time Setup**
   - The application will automatically create necessary database tables
   - Register a new user account
   - Start listing products!

---

### 🔍 Troubleshooting

#### Problem: "Connection Error" or "Database connection failed"
**Solution:**
- **Windows/Mac**: Check if MySQL is running in XAMPP/MAMP Control Panel
- **Linux**: Run `sudo systemctl status mysql`
- Verify database credentials in `config/database.php`
- Make sure database `souqcycle` exists in phpMyAdmin

#### Problem: "Permission denied" when uploading images
**Solution:**
- **Windows**: Right-click `uploads` folder → Properties → Security → Edit → Allow "Full control" for Users
- **Mac**: Open Terminal and run `chmod -R 777 /Applications/XAMPP/htdocs/souqcycle/uploads`
- **Linux**: Run `sudo chmod -R 777 /var/www/html/souqcycle/uploads`

#### Problem: "Page not found" or "404 Error"
**Solution:**
- **Windows**: Make sure project is in `C:\xampp\htdocs\souqcycle`
- **Mac XAMPP**: Project should be in `/Applications/XAMPP/htdocs/souqcycle`
- **Mac MAMP**: Project should be in `/Applications/MAMP/htdocs/souqcycle`
- **Linux**: Project should be in `/var/www/html/souqcycle`
- Verify Apache is running
- Check URL matches your server setup

#### Problem: Apache won't start (Port 80 already in use)
**Solution:**
- **Windows**: Stop IIS or Skype which might be using port 80
- **Mac**: Stop built-in Apache: `sudo apachectl stop`
- **All platforms**: Change XAMPP/MAMP Apache port to 8080 in settings

#### Problem: "Headers already sent" error
**Solution:**
- Make sure there are no spaces or characters before `<?php` tags
- Check for UTF-8 BOM in files (use VS Code or Notepad++)
- Save files with UTF-8 encoding (no BOM)

#### Problem: Images not displaying after upload
**Solution:**
- Check folder permissions on `uploads/products/`
- Verify the path in your browser's developer tools (F12)
- Check PHP settings: `upload_max_filesize` and `post_max_size` in `php.ini`

#### Problem: MySQL password error on Mac MAMP
**Solution:**
- MAMP default password is "root" (not empty)
- Update `config/database.php` with `private $password = "root";`

---

### 📁 Project Structure

```
souqcycle/
├── assets/              # CSS, JS, and static files
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   └── images/         # Static images
├── config/              # Configuration files
│   └── database.php     # Database connection settings
├── controllers/         # Application controllers (MVC pattern)
│   ├── AdminController.php      # Admin functionality
│   ├── CategoryController.php   # Category management
│   ├── ProductController.php    # Product operations
│   └── UserController.php       # User authentication
├── models/              # Data models (MVC pattern)
│   ├── Admin.php
│   ├── Category.php
│   ├── Database.php
│   ├── Product.php
│   ├── ProductImage.php
│   └── User.php
├── uploads/             # User uploaded files
│   └── products/        # Product images storage
├── views/               # View templates (MVC pattern)
│   ├── admin/           # Admin panel views
│   │   ├── categories/
│   │   ├── products/
│   │   └── users/
│   ├── includes/        # Reusable components
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── auth_check.php
│   ├── product/         # Product views
│   │   ├── create.php
│   │   ├── list.php
│   │   └── view.php
│   └── user/            # User views
│       ├── login.php
│       ├── register.php
│       └── profile.php
├── index.php            # Main entry point
└── README.md            # This file
```

---

## 🇫🇷 Version Française

### 📋 Table des Matières
- [À Propos](#à-propos)
- [Fonctionnalités](#fonctionnalités)
- [Prérequis](#prérequis-fr)
- [Guide d'Installation](#guide-dinstallation)
  - [Installation Windows](#installation-windows)
  - [Installation Mac](#installation-mac)
  - [Installation Linux](#installation-linux)
- [Configuration](#configuration-fr)
- [Lancer le Projet](#lancer-le-projet)
- [Dépannage](#dépannage)
- [Structure du Projet](#structure-du-projet-fr)

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

### 🔧 Prérequis {#prérequis-fr}

Ce projet nécessite :
- **PHP** (version 7.4 ou supérieure)
- **MySQL** (version 5.7 ou supérieure) ou MariaDB
- **Serveur Web Apache**
- **Git** (optionnel)

Ne vous inquiétez pas ! Les guides d'installation ci-dessous vous montreront comment installer tout cela facilement.

---

### 📥 Guide d'Installation

## Installation Windows

### Étape 1 : Télécharger et Installer XAMPP

1. **Télécharger XAMPP**
   - Allez sur https://www.apachefriends.org/
   - Cliquez sur "Download" pour Windows
   - Choisissez la version avec PHP 7.4 ou supérieur
   - Téléchargez l'installateur (environ 150 Mo)

2. **Installer XAMPP**
   - Exécutez l'installateur téléchargé (ex: `xampp-windows-x64-installer.exe`)
   - Si Windows demande "Voulez-vous autoriser cette application ?", cliquez sur **Oui**
   - Cliquez sur **Suivant** dans l'assistant d'installation
   - Choisissez le répertoire d'installation (par défaut: `C:\xampp`) - **Mémorisez cet emplacement !**
   - Décochez "En savoir plus sur Bitnami" (optionnel)
   - Cliquez sur **Suivant** puis sur **Terminer**

3. **Démarrer le Panneau de Contrôle XAMPP**
   - Ouvrez le Panneau de Contrôle XAMPP depuis le Menu Démarrer ou le Bureau
   - Vous devriez voir une liste de services (Apache, MySQL, FileZilla, etc.)

### Étape 2 : Télécharger le Projet

**Option A : Utiliser Git (Recommandé)**
1. Installez Git depuis https://git-scm.com/download/win si ce n'est pas déjà fait
2. Ouvrez l'Invite de commandes (Appuyez sur `Win + R`, tapez `cmd`, appuyez sur Entrée)
3. Naviguez vers le dossier htdocs de XAMPP :
   ```bash
   cd C:\xampp\htdocs
   ```
4. Clonez le dépôt :
   ```bash
   git clone https://github.com/Mustaphalamhamdi/usedProductsMartketPlace.git souqcycle
   ```

**Option B : Télécharger en ZIP**
1. Téléchargez le projet en ZIP depuis GitHub
2. Extrayez le fichier ZIP
3. Copiez le dossier extrait dans `C:\xampp\htdocs\`
4. Renommez le dossier en `souqcycle`

### Étape 3 : Démarrer les Serveurs

1. Ouvrez le Panneau de Contrôle XAMPP
2. Cliquez sur **Start** à côté d'**Apache** (il deviendra vert)
3. Cliquez sur **Start** à côté de **MySQL** (il deviendra vert)
4. Si le Pare-feu Windows demande l'autorisation, cliquez sur **Autoriser l'accès**

### Étape 4 : Créer la Base de Données

1. Ouvrez votre navigateur web (Chrome, Firefox, Edge, etc.)
2. Allez sur : `http://localhost/phpmyadmin`
3. Cliquez sur **Nouvelle base de données** dans la barre latérale gauche
4. Entrez le nom de la base de données : `souqcycle`
5. Cliquez sur **Créer**

**Note :** Les tables de la base de données seront créées automatiquement lors de la première exécution de l'application.

### Étape 5 : Configurer la Connexion à la Base de Données

1. Ouvrez le dossier du projet : `C:\xampp\htdocs\souqcycle`
2. Ouvrez `config\database.php` avec un éditeur de texte (Bloc-notes, VS Code, etc.)
3. Vérifiez ces paramètres (ils devraient déjà être corrects) :
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "root";
   private $password = "";  // Laisser vide pour XAMPP
   ```

### Étape 6 : Définir les Permissions des Dossiers

1. Naviguez vers `C:\xampp\htdocs\souqcycle`
2. Clic droit sur le dossier `uploads`
3. Cliquez sur **Propriétés** → onglet **Sécurité** → **Modifier**
4. Sélectionnez **Utilisateurs** et cochez **Autoriser** pour **Contrôle total**
5. Cliquez sur **OK** et **Appliquer**

### Étape 7 : Accéder à Votre Application

1. Ouvrez votre navigateur web
2. Allez sur : `http://localhost/souqcycle`
3. Vous devriez voir la page d'accueil de SouqCycle !

---

## Installation Mac

### Étape 1 : Télécharger et Installer XAMPP (ou MAMP)

**Option A : XAMPP (Recommandé)**

1. **Télécharger XAMPP**
   - Allez sur https://www.apachefriends.org/
   - Cliquez sur "Download" pour macOS
   - Choisissez la version avec PHP 7.4 ou supérieur
   - Téléchargez le fichier DMG (environ 150 Mo)

2. **Installer XAMPP**
   - Ouvrez le fichier DMG téléchargé
   - Faites glisser le dossier XAMPP vers votre dossier Applications
   - Ouvrez **Applications** → **XAMPP**
   - Double-cliquez sur **manager-osx** pour démarrer XAMPP
   - Si macOS dit "ne peut pas être ouvert", allez dans Préférences Système → Sécurité et confidentialité → Cliquez sur "Ouvrir quand même"

**Option B : MAMP (Alternative)**
1. Téléchargez MAMP depuis https://www.mamp.info/
2. Installez en faisant glisser vers le dossier Applications
3. Ouvrez MAMP depuis Applications

### Étape 2 : Télécharger le Projet

**Option A : Utiliser Git (Recommandé)**
1. Ouvrez **Terminal** (Applications → Utilitaires → Terminal)
2. Naviguez vers le dossier htdocs de XAMPP :
   ```bash
   cd /Applications/XAMPP/htdocs
   ```
   Ou pour MAMP :
   ```bash
   cd /Applications/MAMP/htdocs
   ```
3. Clonez le dépôt :
   ```bash
   git clone https://github.com/Mustaphalamhamdi/usedProductsMartketPlace.git souqcycle
   ```

**Option B : Télécharger en ZIP**
1. Téléchargez le projet en ZIP depuis GitHub
2. Extrayez le fichier ZIP
3. Ouvrez **Finder** → **Applications** → **XAMPP** → **htdocs** (ou **MAMP** → **htdocs**)
4. Copiez le dossier extrait ici
5. Renommez-le en `souqcycle`

### Étape 3 : Démarrer les Serveurs

**Pour XAMPP :**
1. Ouvrez le gestionnaire XAMPP (Applications → XAMPP → manager-osx)
2. Cliquez sur **Start** pour Apache Server
3. Cliquez sur **Start** pour MySQL Database
4. Les deux devraient afficher le statut "Running"

**Pour MAMP :**
1. Ouvrez l'application MAMP
2. Cliquez sur **Démarrer les serveurs**
3. Attendez que Apache et MySQL affichent des lumières vertes

### Étape 4 : Créer la Base de Données

1. Ouvrez votre navigateur web (Safari, Chrome, Firefox, etc.)
2. Pour XAMPP, allez sur : `http://localhost/phpmyadmin`
   Pour MAMP, allez sur : `http://localhost:8888/phpMyAdmin` (ou cliquez sur "WebStart" dans MAMP)
3. Cliquez sur **Nouvelle base de données** dans la barre latérale gauche
4. Entrez le nom de la base de données : `souqcycle`
5. Cliquez sur **Créer**

### Étape 5 : Configurer la Connexion à la Base de Données

1. Ouvrez **Finder** et naviguez vers le projet :
   - XAMPP : `/Applications/XAMPP/htdocs/souqcycle`
   - MAMP : `/Applications/MAMP/htdocs/souqcycle`
2. Ouvrez `config/database.php` avec TextEdit ou un éditeur de code
3. Vérifiez/Mettez à jour ces paramètres :

   **Pour XAMPP :**
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "root";
   private $password = "";  // Laisser vide
   ```

   **Pour MAMP :**
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "root";
   private $password = "root";  // Le mot de passe par défaut de MAMP est "root"
   ```

### Étape 6 : Définir les Permissions des Dossiers

1. Ouvrez **Terminal**
2. Naviguez vers votre projet :
   ```bash
   cd /Applications/XAMPP/htdocs/souqcycle
   # ou pour MAMP :
   # cd /Applications/MAMP/htdocs/souqcycle
   ```
3. Définissez les permissions :
   ```bash
   chmod -R 755 .
   chmod -R 777 uploads
   ```

### Étape 7 : Accéder à Votre Application

1. Ouvrez votre navigateur web
2. Pour XAMPP, allez sur : `http://localhost/souqcycle`
   Pour MAMP, allez sur : `http://localhost:8888/souqcycle`
3. Vous devriez voir la page d'accueil de SouqCycle !

---

## Installation Linux

### Étape 1 : Installer les Logiciels Requis

**Pour Ubuntu/Debian :**
```bash
# Mettre à jour la liste des paquets
sudo apt update

# Installer Apache
sudo apt install apache2

# Installer MySQL
sudo apt install mysql-server

# Installer PHP et les extensions requises
sudo apt install php php-mysql php-gd php-mbstring php-xml libapache2-mod-php

# Démarrer les services
sudo systemctl start apache2
sudo systemctl start mysql
sudo systemctl enable apache2
sudo systemctl enable mysql
```

**Pour Fedora/RHEL/CentOS :**
```bash
# Installer Apache
sudo dnf install httpd

# Installer MySQL
sudo dnf install mysql-server

# Installer PHP et les extensions
sudo dnf install php php-mysqlnd php-gd php-mbstring php-xml

# Démarrer les services
sudo systemctl start httpd
sudo systemctl start mysqld
sudo systemctl enable httpd
sudo systemctl enable mysqld
```

### Étape 2 : Télécharger le Projet

1. Naviguez vers le répertoire web :
   ```bash
   cd /var/www/html
   ```

2. Clonez le dépôt :
   ```bash
   sudo git clone https://github.com/Mustaphalamhamdi/usedProductsMartketPlace.git souqcycle
   ```

### Étape 3 : Créer la Base de Données

1. Accédez à MySQL :
   ```bash
   sudo mysql -u root -p
   ```

2. Créez la base de données :
   ```sql
   CREATE DATABASE souqcycle;
   CREATE USER 'souqcycle_user'@'localhost' IDENTIFIED BY 'votre_mot_de_passe';
   GRANT ALL PRIVILEGES ON souqcycle.* TO 'souqcycle_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

### Étape 4 : Configurer la Connexion à la Base de Données

1. Modifiez la configuration de la base de données :
   ```bash
   sudo nano /var/www/html/souqcycle/config/database.php
   ```

2. Mettez à jour avec vos identifiants :
   ```php
   private $host = "localhost";
   private $db_name = "souqcycle";
   private $username = "souqcycle_user";
   private $password = "votre_mot_de_passe";
   ```

### Étape 5 : Définir les Permissions

```bash
sudo chown -R www-data:www-data /var/www/html/souqcycle
sudo chmod -R 755 /var/www/html/souqcycle
sudo chmod -R 777 /var/www/html/souqcycle/uploads
```

### Étape 6 : Accéder à Votre Application

Ouvrez le navigateur et allez sur : `http://localhost/souqcycle`

---

### ⚙️ Configuration {#configuration-fr}

#### Configuration de la Base de Données
Modifiez `config/database.php` :
```php
private $host = "localhost";        // Hôte de la base de données
private $db_name = "souqcycle";     // Nom de la base de données
private $username = "root";          // Nom d'utilisateur MySQL
private $password = "";              // Mot de passe MySQL (vide pour XAMPP, "root" pour MAMP)
```

#### Paramètres de Téléchargement de Fichiers
L'application stocke les images téléchargées dans :
- `uploads/products/` - Images des produits

Assurez-vous que ce répertoire existe et a les permissions d'écriture.

---

### 🚀 Lancer le Projet

1. **Démarrer le Serveur Web et la Base de Données**
   - **Windows XAMPP** : Ouvrez le Panneau de Contrôle XAMPP → Démarrez Apache & MySQL
   - **Mac XAMPP** : Ouvrez le Gestionnaire XAMPP → Démarrez Apache & MySQL
   - **Mac MAMP** : Ouvrez MAMP → Démarrez les Serveurs
   - **Linux** : Les services devraient démarrer automatiquement, ou utilisez `sudo systemctl start apache2 mysql`

2. **Ouvrir dans le Navigateur**
   - **XAMPP (Win/Mac)** : `http://localhost/souqcycle`
   - **MAMP** : `http://localhost:8888/souqcycle`
   - **Linux** : `http://localhost/souqcycle`

3. **Configuration Initiale**
   - L'application créera automatiquement les tables de base de données nécessaires
   - Inscrivez un nouveau compte utilisateur
   - Commencez à lister des produits !

---

### 🔍 Dépannage

#### Problème : "Connection Error" ou "Échec de connexion à la base de données"
**Solution :**
- **Windows/Mac** : Vérifiez si MySQL est en cours d'exécution dans le Panneau de Contrôle XAMPP/MAMP
- **Linux** : Exécutez `sudo systemctl status mysql`
- Vérifiez les identifiants de la base de données dans `config/database.php`
- Assurez-vous que la base de données `souqcycle` existe dans phpMyAdmin

#### Problème : "Permission refusée" lors du téléchargement d'images
**Solution :**
- **Windows** : Clic droit sur le dossier `uploads` → Propriétés → Sécurité → Modifier → Autoriser "Contrôle total" pour les Utilisateurs
- **Mac** : Ouvrez Terminal et exécutez `chmod -R 777 /Applications/XAMPP/htdocs/souqcycle/uploads`
- **Linux** : Exécutez `sudo chmod -R 777 /var/www/html/souqcycle/uploads`

#### Problème : "Page introuvable" ou "Erreur 404"
**Solution :**
- **Windows** : Assurez-vous que le projet est dans `C:\xampp\htdocs\souqcycle`
- **Mac XAMPP** : Le projet doit être dans `/Applications/XAMPP/htdocs/souqcycle`
- **Mac MAMP** : Le projet doit être dans `/Applications/MAMP/htdocs/souqcycle`
- **Linux** : Le projet doit être dans `/var/www/html/souqcycle`
- Vérifiez qu'Apache est en cours d'exécution
- Vérifiez que l'URL correspond à votre configuration de serveur

#### Problème : Apache ne démarre pas (Port 80 déjà utilisé)
**Solution :**
- **Windows** : Arrêtez IIS ou Skype qui pourrait utiliser le port 80
- **Mac** : Arrêtez Apache intégré : `sudo apachectl stop`
- **Toutes les plateformes** : Changez le port Apache de XAMPP/MAMP à 8080 dans les paramètres

#### Problème : Erreur "Headers already sent"
**Solution :**
- Assurez-vous qu'il n'y a pas d'espaces ou de caractères avant les balises `<?php`
- Vérifiez la présence de BOM UTF-8 dans les fichiers (utilisez VS Code ou Notepad++)
- Enregistrez les fichiers avec l'encodage UTF-8 (sans BOM)

#### Problème : Les images ne s'affichent pas après le téléchargement
**Solution :**
- Vérifiez les permissions du dossier `uploads/products/`
- Vérifiez le chemin dans les outils de développement de votre navigateur (F12)
- Vérifiez les paramètres PHP : `upload_max_filesize` et `post_max_size` dans `php.ini`

#### Problème : Erreur de mot de passe MySQL sur Mac MAMP
**Solution :**
- Le mot de passe par défaut de MAMP est "root" (pas vide)
- Mettez à jour `config/database.php` avec `private $password = "root";`

---

### 📁 Structure du Projet {#structure-du-projet-fr}

```
souqcycle/
├── assets/              # CSS, JS et fichiers statiques
│   ├── css/            # Feuilles de style
│   ├── js/             # Fichiers JavaScript
│   └── images/         # Images statiques
├── config/              # Fichiers de configuration
│   └── database.php     # Paramètres de connexion à la base de données
├── controllers/         # Contrôleurs de l'application (modèle MVC)
│   ├── AdminController.php      # Fonctionnalités d'administration
│   ├── CategoryController.php   # Gestion des catégories
│   ├── ProductController.php    # Opérations sur les produits
│   └── UserController.php       # Authentification des utilisateurs
├── models/              # Modèles de données (modèle MVC)
│   ├── Admin.php
│   ├── Category.php
│   ├── Database.php
│   ├── Product.php
│   ├── ProductImage.php
│   └── User.php
├── uploads/             # Fichiers téléchargés par les utilisateurs
│   └── products/        # Stockage des images de produits
├── views/               # Templates de vue (modèle MVC)
│   ├── admin/           # Vues du panneau d'administration
│   │   ├── categories/
│   │   ├── products/
│   │   └── users/
│   ├── includes/        # Composants réutilisables
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── auth_check.php
│   ├── product/         # Vues des produits
│   │   ├── create.php
│   │   ├── list.php
│   │   └── view.php
│   └── user/            # Vues utilisateur
│       ├── login.php
│       ├── register.php
│       └── profile.php
├── index.php            # Point d'entrée principal
└── README.md            # Ce fichier
```

---

## 👨‍💻 Author / Auteur

**Mustapha Lamhamdi**

## 📝 License / Licence

This project is open source and available for educational purposes.

Ce projet est open source et disponible à des fins éducatives.

---

## 🆘 Support

**English:**
If you encounter any issues or have questions:
- Check the troubleshooting section above for your operating system
- Review the configuration settings
- Ensure all prerequisites are properly installed
- Make sure Apache and MySQL services are running

**Français :**
Si vous rencontrez des problèmes ou avez des questions :
- Consultez la section dépannage ci-dessus pour votre système d'exploitation
- Vérifiez les paramètres de configuration
- Assurez-vous que tous les prérequis sont correctement installés
- Vérifiez que les services Apache et MySQL sont en cours d'exécution
