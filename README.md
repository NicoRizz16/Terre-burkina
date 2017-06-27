# Terre-burkina
Site de l'association Terre Burkina



Installation
------------

1) Clôner le repository Terre-burkina

2) A la racine du projet, mettre à jour le composer : php composer.phar update

3) Compléter le fichier parameters.yml sur l'exemple de parameters.yml.dist
  - Connexion à une boîte mail d'envois
  - Connexion à la base de donnée
  - Clé Api Stripe
  
4) Créer la base de donnée sur le serveur local : php bin/console doctrine:database:create

5) Charger les tables doctrines dans la base de donnée : php bin/console doctrine:schema:update --force

6) Charger les fixtures : php bin/console doctrine:fixtures:load

