# Backoffice

Sous répertoire avec le code du backoffice

### Pré-requis

Avoir docker, docker-compose, installer les 2 API Player et Backend

### Installation

Après avoir récupérer le dépot Git, se placer à la racine, ouvrir un terminal et exécuter la commande: 
```
docker-composer up -d
```
Afficher les machines docker avec:
```
docker ps -a
```
Dans la machine geoquizz_back_office, exécuter:
```
composer install
composer dump-autoload -o
```
Dans le fichier /etc/hosts de votre machine hôte ajouter:
```
127.0.0.1 backoffice.local
```
Le backoffice est accessible avec l'url backoffice.local (port 12080 par défaut)

La base de données est accessible avec l'url localhost (port 8080 par défaut)

## Développer avec

* [Slim](https://packagist.org/packages/slim/slim)
* [slim/twig-view](https://packagist.org/packages/slim/twig-view)
* [curl/curl](https://packagist.org/packages/curl/curl)
* [respect/validation](https://packagist.org/packages/respect/validation)
* [slim/csrf](https://packagist.org/packages/slim/csrf)
* [slim/flash](https://packagist.org/packages/slim/flash)
* [cloudinary/cloudinary_php](https://packagist.org/packages/cloudinary/cloudinary_php)
