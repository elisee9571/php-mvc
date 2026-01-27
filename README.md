# Projet PHP POO MVC (Composer + Autoloader)

Ce projet est un mini framework **PHP POO en MVC** (Model / View / Controller) avec **Composer** et un **autoload PSR-4**.

---

## Prérequis

- PHP (8.1+ recommandé)
- Composer
- MySQL (serveur local)

---

# Lancer le projet (serveur PHP)

Dans le dossier du projet, lance :

```bash
cd public
php -S localhost:8081 -d display_errors=1
```

Puis ouvre ton navigateur : http://localhost:8081

### Installer et configurer MySQL (Ubuntu)
1) Installer MySQL Server

```bash
sudo apt update
sudo apt install mysql-server
```

2) Démarrer MySQL et l’activer au démarrage

```bash
sudo systemctl start mysql
sudo systemctl enable mysql
sudo systemctl status mysql --no-pager
```

Le service doit être en active (running).

3) Vérifier que MySQL écoute sur le port 3306

```bash
sudo ss -lntp | grep 3306
```

Tu dois voir mysqld en écoute sur *:3306.

4) Entrer dans MySQL
```bash
sudo mysql
```

### Créer la base de données + utilisateur

Dans le terminal MySQL, exécute :

```bash
CREATE DATABASE site_php;

CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON site_php.* TO 'user'@'localhost';
FLUSH PRIVILEGES;
exit;
```

### Configuration de la connexion PDO

Dans ton projet, adapte la classe Database avec ces paramètres :

```PHP
$host : 127.0.0.1
$port : 3306
$dbName : site_php
$user : user
$password : password
```

Exemple DSN :

```PHP
$dsn = "mysql:host=127.0.0.1;port=3306;dbname=site_php";
```