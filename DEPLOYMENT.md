# Guide de déploiement — Macard

## Informations du projet

- **Repository GitHub** : https://github.com/hugocadenedev/macard (branche : `main`)
- **Site de production** : https://macard.groupemacard.fr
- **Site de test** : https://lightblue-starling-686117.hostingersite.com

---

## Hébergements Hostinger

### Hosting principal (groupemacard.fr)
- **Domaine** : groupemacard.fr
- **Utilisateur SSH** : `u362859991`
- **Serveur SSH** : `fr-int-web1179` (IP variable, utiliser le hostname Hostinger)
- **Port SSH** : 65002
- **Répertoire app** : `~/domains/groupemacard.fr/app/`
- **public_html** : symlink → `~/domains/groupemacard.fr/app/public`
- **DB** : `u362859991_macard` / user `u362859991_macard_user`
- **Admin** : admin@admin.com / admin

### Hosting secondaire (lightblue)
- **Domaine** : lightblue-starling-686117.hostingersite.com
- **SSH** : `ssh -p 65002 u362859991@178.16.128.170`
- **Répertoire app** : `~/domains/lightblue-starling-686117.hostingersite.com/app/`
- **DB** : `u362859991_peugeot` / user `u362859991_urioz`
- **Admin** : admin@admin.com / admin

---

## Variables d'environnement (.env production)

```env
APP_NAME=Macard
APP_ENV=production
APP_DEBUG=false
APP_URL=https://macard.groupemacard.fr

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u362859991_macard
DB_USERNAME=u362859991_macard_user
DB_PASSWORD=<mot_de_passe_db>

MAIL_MAILER=smtp
MAIL_HOST=smtp.resend.com
MAIL_PORT=465
MAIL_USERNAME=resend
MAIL_PASSWORD=re_<cle_resend>
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@groupemacard.fr
MAIL_FROM_NAME="Groupe Macard"

TELESCOPE_ENABLED=false
```

---

## Premier déploiement (depuis zéro)

```bash
# 1. Cloner le repo
git clone https://github.com/hugocadenedev/macard.git app
cd app

# 2. Installer les dépendances PHP
composer install --no-dev --optimize-autoloader

# 3. Configurer l'environnement
cp .env.example .env
nano .env   # remplir toutes les variables ci-dessus

# 4. Générer la clé
php artisan key:generate

# 5. Supprimer le cache bootstrap si existant
rm -f bootstrap/cache/*.php

# 6. Migrations et seeds
php artisan migrate --force
php artisan db:seed --force

# Si le seeder a échoué à mi-chemin, créer manuellement :
php artisan tinker --execute="\App\User::create(['name'=>'admin','email'=>'admin@admin.com','password'=>bcrypt('admin')]);"
php artisan tinker --execute="\App\Page::create(['banner_url'=>null,'title'=>'','description'=>'','background_color'=>'#ffffff','text_color'=>'#3c4047','font'=>'OPEL']);"

# 7. Optimiser
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Symlink public_html (si pas encore fait)
# Dans hPanel → File Manager : supprimer public_html et créer un symlink vers ~/domains/groupemacard.fr/app/public
```

---

## Mise à jour (déploiement d'une nouvelle version)

```bash
cd ~/domains/groupemacard.fr/app

# 1. Récupérer les changements
git pull origin main

# 2. Mettre à jour les dépendances si composer.json a changé
composer install --no-dev --optimize-autoloader

# 3. Migrations si nouvelles migrations
php artisan migrate --force

# 4. Vider et reconstruire le cache
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Configuration du subdomain macard.groupemacard.fr

Dans **hPanel → groupemacard.fr → Subdomains** :
- Créer le subdomain `macard` pointant vers `public_html` (qui est le symlink vers `app/public`)

---

## Mail — Resend

- **Service** : [resend.com](https://resend.com)
- **Domaine ajouté** : `groupemacard.fr` (DNS records à vérifier dans hPanel → DNS)
- **SMTP** : `smtp.resend.com:465` (SSL)
- **Username** : `resend` (littéral, pas l'email)
- **From** : `noreply@groupemacard.fr`
- **Emails envoyés** :
  - Confirmation client → `ConfirmationMail.php`
  - Alerte commercial → `AlertMail.php` (vers `m.rodolphe@groupemso.fr`)

---

## Problèmes connus et solutions

### MissingAppKeyException
- **Cause** : Cache bootstrap obsolète ou `.env` mal configuré
- **Fix** : `php artisan key:generate` puis `rm bootstrap/cache/*.php`

### Access denied for user 'root'@'127.0.0.1'
- **Cause** : `.env` non configuré avec les credentials DB réels
- **Fix** : Remplir `DB_*` dans `.env` puis `php artisan config:cache`

### Attempt to read property "font" on null
- **Cause** : Table `pages` vide (seeder n'a pas tourné complètement)
- **Fix** : `php artisan tinker --execute="\App\Page::create([...]);"`

### npm build avec Node v24
- **Cause** : OpenSSL legacy provider requis
- **Fix** : `NODE_OPTIONS=--openssl-legacy-provider npm run production`

### Telescope erreur root@127.0.0.1 en production
- **Cause** : Telescope essaie de se connecter avec les credentials par défaut
- **Fix** : `TelescopeServiceProvider.php` retourne si `!app->environment('local')`

### env() retourne null après config:cache
- **Cause** : `env()` ne fonctionne pas après `config:cache`, utiliser `config()` à la place
- **Fix** : `DatabaseConnexion.php` utilise `config('database.connections.mysql.*')`
