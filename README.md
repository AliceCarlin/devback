# Bienvenue sur mon projet symfony!
je sais pas vraiment ce que je fais mais j'essaye très dur.

## Ca fait quoi?
Alors la fonctionnalité principale du projet, c'est l'inclusion d'un crud et de fixtures correspondantes pour un projet en vue. En gros, ce projet sert de backend a un autre projet front.

## Comment je m'en sert?
Le .env est préconfiguré pour fonctionner avec la fonction base de données de MAMP (donc, en local). Pour plus de détails, consultez la webpage de MAMP. Si vous voulez changer de service de base de données: https://symfony.com/doc/current/doctrine.html
Les fixtures sont faites pour prépeupler la base de données fournie avec des données d'acteurs, de films, et de catégories. C'est très simple:
  1 - Lancez le serveur symfony (symfony server:start) dans une invite de commande dans le dossier du projet,
  2 - Lancez votre MAMP (ou autre service de base de donénes,
  3 - Lancez la commande "php bin/console doctrine:fixtures:load" dans le terminal
tadaaaaaaa
