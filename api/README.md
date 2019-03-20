# API Player et Backend

Sous-répertoire avec le code des 2 API Player et Backend

### Pré-requis

Avoir docker et docker-compose

### Installation

Après avoir récupérer le dépot Git, se placer à la racine, ouvrir un terminal et exécuter la commande: 
```
docker-compose up -d
```
Afficher les machines docker avec:
```
docker ps -a
```
Dans les machines geoquizz_api.player et geoquizz_api.backend, exécuter:
```
composer install
composer dump-autoload -o
```

Dans le fichier /etc/hosts de votre machine hôte ajouter:
```
127.0.0.1 api.player.local
127.0.0.1 api.backend.local
```

## Utilisation

L'API Player peut être utilisé avec l'url api.player.local (port 10080 par défaut)

L'API Backend peut être utilisé avec l'url api.backend.local (port 11080 par défaut)

## Développer avec

* [Slim](https://packagist.org/packages/slim/slim)
* [Eloquent](https://packagist.org/packages/illuminate/database)
* [ramsey/uuid](https://packagist.org/packages/ramsey/uuid)
* [firebase/php-jwt](https://packagist.org/packages/firebase/php-jwt)
