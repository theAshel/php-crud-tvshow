# SAÉ 2.01 - Développement d'une application

# Auteurs : Harish KOMAGAN (koma0006) - Hoang Long PHAM (pham0019)

## Fonctionnalités de l'application web

Cette application web nous permet la visualisation de séries télévisées stockées dans une base de données.
Il est possible de n'afficher les séries que d'un certain genre.  

Nous pouvons ajouter des séries, les modifier ou les supprimer.  

Pour chaque série, chaque saison qui la compose est listée.  
Pour chaque saison, chaque épisode qui la compose est listée.

## Cloner le dépôt

Lorsque le dépôt est cloné, il faut installer les dépendances du projet avec `composer install`.

Également en cas de clonage du dépôt ou en cas de modification des règles "**autoload**" ou "**autoload-dev**"
dans le fichier **composer.json**, il faut mettre à jour l'auto-chargement de **Composer** en lançant la commande
`composer dump-autoload`.

Si vous souhaitez exécuter des tests dans un cadre de développement, exécutez cette commande afin de
générer les fichiers nécessaires au fonctionnement du "**Cest**" :
`php vendor/bin/codecept build`

L'accès à la base de données **MySQL** est configurée dans un fichier **.mypdo.ini**, non fournie dans ce dépôt Git. Il est donc
nécessaire de le configurer manuellement. Voici comment le configurer :
```
[mypdo]
dsn = "mysql:host=your_host_name;dbname=your_database_name;charset=utf8"
username = 'your_username'
password = "your_password"
```

## PHP CS Fixer

**PHP CS Fixer** est un outil permettant de contrôler que le code écrit respecte la recommandation "PSR-12".
On l'installe avec la commande `composer require friendsofphp/php-cs-fixer --dev`.

- Pour vérifier quels fichiers peuvent être corrigés, mais sans en effectuer :

`php vendor/bin/php-cs-fixer fix --dry-run`

- Pour afficher les différences entre l'original et ce qui est ou serait corrigé :

̀`php vendor/bin/php-cs-fixer fix --dry-run --diff`

- Pour corriger les fichiers :

`php vendor/bin/php-cs-fixer fix`

## Scripts 

**Composer** permet de créer des raccourcis pour des scripts. Pour les exécuter, il suffit d'écrire la commande
`composer *nom_du_script*`

### scripts _**start**_ :

- `start:windows` : démarre un serveur local php sur Windows en appelant le script **run_server.bat**
- `start:linux` : démarre un serveur local php sur Linux en appelant le script **run_server.sh**. 
- `start` : fait référence au script **start:linux**

### scripts _**test**_ :

- `test:crud` : lance les tests de la suite **Crud**
- `test:codecept` : lance tous les **Cest**.

## Tests

On utilise la bibliothèque de gestion de tests **Codeception** pour pouvoir écrire tous nos tests.

### Installation de **Codeception** par **Composer**

On demande toutes les dépendances de développement nécessaires via cette commande :
`composer require --dev --with-all-dependencies codeception/codeception:^4.1 codeception/module-phpbrowser:^1 
codeception/module-asserts:^1 codeception/module-db:^1`

### Configuration générale de **Codeception**

On crée le fichier de configuration avec cette commande :
`php vendor/bin/codecept bootstrap --namespace=Tests --empty`

Cela va générer le fichier **codeception.yml** à la racine du projet, ainsi que le répertoire **tests**

### Configuration de l'auto-chargement

On doit modifier le fichier **composer.json** en ajoutant ceci :
```json
"autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    }
```

En faisant ça, on associe l'espace de noms **Tests\** au répertoire **tests** tout en respectant les normes **PSR-4**.

On a également dû mettre à jour l'auto-chargement de **Composer** avec :
`composer dump-autoload`

### Configuration de la base de données de test

On place le "dump" de la base de données **tvshow-lite.sql** dans le répertoire **tests/_data**.

On ajoute la configuration du module **DB** dans le fichier **codeception.yml** :
```yml
modules:
    config:
        Db: # configuration injected into MyPdo in _support/Helper/*.php, if necessary
          dsn: "sqlite:tests/tvshow-lite.sqlite"
          user: ""
          password: ""
          dump: "tests/_data/tvshow-lite.sql"
          populate: true
          cleanup: true
```

Et on ajoute la méthode suivante à la classe d'assistant **Tests\Helper\Crud** pour configurer **MyPdo** lors de
l'initialisation de la suite de tests:
```php
public function _initialize($settings = [])
{
    try {
        MyPdo::setConfiguration($this->getModule('Db')->_getConfig('dsn'));
    } catch (ModuleException $moduleException) {
        $this->fail('Codeception DB module not found');
    }
}
```

### Suites de tests

On créera plusieurs suites de tests afin de grouper les tests par thème, nature ou portée.
Voici comment créer une suite de tests (on va prendre comme exemple la suite **Crud**)

#### Suite de tests **Crud**

On lance la commande de création d'une nouvelle suite de tests "**Crud**" :
`php vendor/bin/codecept generate:suite Crud`

Cela a pour conséquences l'apparition du fichier **Crud.suite.yml** dans le répertoire "**tests**"
et du fichier **Crud.php** dans le répertoire "**tests/_support/Helper**"

On édite le fichier **Crud.suite.yml** pour activer les modules **Asserts** et **Db**:
```yml
modules:
    enabled:
        - \Tests\Helper\Crud
        - Asserts
        - Db: # configuration from codeception.yml injected into MyPdo in _support/Helper/Crud.php
```

Pour la génération des autres suites, le fonctionnement est sensiblement le même.

##### Lots de tests pour **TVShowCollection**

Les tests dans une suite de tests sont groupés au sein de classes de test "**Cest**". Par exemple, pour créer
le **Cest** de la classe **TVShowCollection**, on lance cette commande :

`php vendor/bin/codecept generate:cest Crud Collection\\TVShowCollection`

On ajoute ensuite dans la classe crée les méthodes correspondant à nos tests.

Tests de **TVShowCollectionCest** :
- `findAll()` : vérifie si tous les TVShows sont bien récupérés.

Il faut lancer la commande suivante pour générer les fichiers nécessaires au fonctionnement du "**Cest**" :
`php vendor/bin/codecept build`

##### Lots de tests pour **TVShow**

Tests de **TVShowCest** :
- `delete()` : vérifie si le TVShow est bien supprimé.
- `update()` : vérifie si le TVShow est bien modifié.