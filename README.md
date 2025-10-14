# Utilisation du template CodeIgniter 4 ( CIPECMA )

![image](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
)
![image](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![image](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white
)
![image](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![image](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)
![image](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white) ![image](http://img.shields.io/badge/-PHPStorm-181717?style=for-the-badge&logo=phpstorm&logoColor=white)
![image](https://img.shields.io/badge/Codeigniter-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![image](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=Composer&logoColor=white)

## Informations
Ceci est un projet fait sous [CodeIgniter 4](https://www.codeigniter.com/user_guide/index.html).

## Création de votre projet

1. Créer sur GitHub.com dans vos répertoires privés un repo pour votre projet en utilisant ce template comme base de travail.
2. Cloner votre repo sur votre ordinateur pour pouvoir travailler dessus.
3. Allez dans `docker-compose.yml`et remplacer le nom de la BDD par celui de votre projet.
4. Copier/Coller le `env` et le renommé en `.env` dans le dossier racine de votre projet. Et modifier les informations de BDD et placer vous en mode dévelopment.

### Initialiser le projet

Ouvrez votre projet avec phpstorm.

Ouvrez un terminal (`Alt + F12`).

Puis utiliser la commande suivante :
```
composer install
```
(vous pouvez utiliser composer update aussi)

```
docker-compose up -d
```

Puis

```
php spark migrate
```

Puis
```
php spark db:seed MasterSeeder
```
Ensuite vous pouvez vérifier le bon fonctionnement à l'aide de la commande suivante :
```
php spark serve
```
Qui va ouvrir créer un serveur de développement local à l'adresse http://localhost:8080 (attention ce n'est pas
https ! )

Vous pouvez vous connecter avec le login et le mdp suivant : ```admin@admin.fr / admin```


Vous avez aussi un accés à un phpmyadmin de développement local à l'adresse http://localhost:8081 (attention ce
n'est pas https ! ).

Si le phpmyadmin ne fonctionne pas il faut verifier que docker est bien lancé et vos container
aussi.

Pour vous connecter au phpmyadmin il faut utiliser ```root / root```

Si jamais vous avez besoin d'un serveur de mail vous pouvez décommenter les lignes dans le fichier `docker-compose.yml`.