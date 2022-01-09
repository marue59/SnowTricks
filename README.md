Développez de A à Z le site communautaire SnowTricks

Clonage du projet

- git clone https://github.com/marue59/snowTricks.git
  Le projet sera automatiquement copié dans le répertoire ciblé.

Configuration de la base de données :
Dans le fichier .env et le mettre dans le .gitignore

- DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

Création de la base de données :

Créez la base de données de l'application en tapant la commande ci-dessous :

- php bin/console doctrine:database:create

Puis lancer la migration pour créer les tables dans la base de données :

- php bin/console doctrine:migrations:migrate

Implementez les fixtures :

- php bin/console doctrine:fixtures:load

Lancement du serveur
Vous pouvez lancer le serveur via la commande suivante :

- symfony serve

Codacy Badge :
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/5481d17708714048b474ed64f7cd21ad)](https://www.codacy.com/gh/marue59/snowTricks/dashboard?utm_source=github.com&utm_medium=referral&utm_content=marue59/snowTricks&utm_campaign=Badge_Grade)

Description du projet :
Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaitre ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.

Description du besoin :
Implémenter les fonctionnalités suivantes :

- un annuaire des figures de snowboard
- la gestion des figures (création, modification, consultation) ;
- un espace de discussion commun à toutes les figures.

Pour implémenter ces fonctionnalités, les pages suivantes seront créer:

- la page d’accueil où figurera la liste des figures ;
- la page de création d'une nouvelle figure ;
- la page de modification d'une figure ;
- la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).
