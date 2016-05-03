Ajax
=============
# Introduction
Quand vous visitez un site, en général, la page se charge et quand vous avez besoin d'avoir
d'autres informations, vous cliquez sur un lien et ça vous charge une autre page.

Le problème c'est qu'en chargeant une nouvelle page, d'une part, vous ne voyez plus le contenu
que vous étiez en train de lire et d'autre part vous devez recharger une autre page en subissant le temps de
chargement.

Prenons un exemple concret pour que vous voyez bien de quoi je parle.

Vous êtes sur la page d'accueil d'un site d'information lambda. Il y a une partie principale avec les articles et
une partie à côté avec les "dernières news". Si le site n'utilise pas d'AJAX, alors il va falloir que vous actualisiez la page
pour avoir les dernières news. Dans le cas contraire, la partie "dernières news" se met à jour sans que vous ne fassiez quoique ce soit !

# Comment ça marche ?
AJAX signifie *Asynchronous JavaScript and XML*. Comme son nom l'indique il y a du javascript, notamment avec l'utilisation de l'objet **XmlHttpRequest**.

Je ne vous cache pas que travailler directement avec cet objet c'est casse-bonbon, notamment pour faire fonctionner sur tous les navigateurs.
Heureusement, jQuery est là pour nous simplifier la vie (encore).

Je vous invite à suivre ce petit [cours](https://openclassrooms.com/courses/un-site-web-dynamique-avec-jquery/ajax-les-requetes-http-par-l-objet-xmlhttprequest) et d'aller jusqu'à *2. Le fonctionnement de $.ajax()*.

# Activité
Dans cette activité on va intéragir avec du contenu sans recharger la page.

Pour cela je vous ai mis à disposition une mini app qui va gérer la partie serveur. Votre page AJAX va intéragir avec la mini app.

Cette mini app a été écrite pour loueur de véhicules afin mettre à jour sa base de données de véhicules. Chaque voiture possède les propriétés suivantes :

* *model* le nom du modèle
* *make* la marque
* *color* la couleur
* *price* le prix de location à la journée
* *available* si la voiture est disponible
* *id* l'identifiant de la voiture. Une chaîne de caractère unique afin de pouvoir identifier une voiture dans la base de donnée sans ambigüité.

## Installation

Afin d'utiliser la mini app il faut l'installer.

Tout d'abord, vous devez cloner ce repo.

```
git clone <lien du repo> voitures-api
```

Cette application étant écrite en PHP, il faut installer les librairies à l'aide de gestionnaire de dépendances **composer**. Il faut donc installer composer avant d'([installer composer](http://symfony.com/doc/current/cookbook/composer.html) les librairies.

Une fois composer installé, dans le terminal, rendez-vous dans le répertoire de la mini app puis tapez :

```
composer update
```

Cela va copier les librairies PHP nécessaires sur votre ordinateur dans le répertoire *vendor*.

Une fois l'installation terminée, nous allons lancer un petit serveur intégré. Toujours dans le répertoire de l'app vous allez rentrer la commande suivante :

```
php bin/console server:start
```

Cela va lancer le serveur. Afin de vérifier si ça fonctionne, ouvrez votre navigateur et allez à l'adresse : [http://127.0.0.1:8000/](http://127.0.0.1:8000/). Vous devez voir le texte suivant : *Cars api v 0.1*.


**N'oubliez pas d'arrêter le serveur quand vous avez fini**

```
php bin/console server:stop
```

## AJAX

L'installation de la mini app est terminée, elle fonctionne, nous allons maintenant rentrer dans le vif du sujet.

### Espace de travail

Sur votre ordinateur, créez un dossier que vous appellerez *ajax-location* (créez où vous voulez, sauf dans le répertoire de la mini app). Ce sera dans ce dossier où vous allez mettre votre travail.

Dans ce dossier *ajax-location* vous devez créer un fichier HTML. Tout votre travail se trouvera dans ce fichier.

### Récupérer la liste de voitures

Vous allez créer un bouton *Liste voitures*. Quand l'utilisateur clique sur ce bouton vous devez afficher la liste des voitures sous la forme  d'une liste. Example :
```
- Peugeot 206, blanche, 25€ par jour, disponible
- Renault Clio, bleu, 25€ par jour, disponible
```
Comme on fait de l'AJAX la page ne doit pas se rafraîchir !

Afin de récupérer la liste des voitures il faut aller à l'adresse [http://127.0.0.1:8000/cars](http://127.0.0.1:8000/cars). Si vous ouvrez ce lien dans le navigateur vous verrez quelque chose de ce style :
```json
[{"id":"ac976052-eadf-488a-bfad-ba5add042981","model":"206","make":"Peugeot","price":25,"available":true,"color":"white"},{"id":"0c5bffe4-104e-4848-b475-83f66fa89f05","model":"Clio","make":"Renault","price":25,"available":true,"color":"blue"},{"id":"3b3e3334-e665-45b2-bb99-09ee47f22c9e","model":"F430","make":"Ferrari","price":400,"available":true,"color":"red"}]
```

C'est la liste de voitures sous forme JSON avec les propriétés pour chaque voiture et leur valeur. À vous de reprendre les données de ce JSON afin de les mettre en forme.

### Supprimer une voiture
Imaginons qu'une voiture n'existe plus, il va falloir la supprimer de la liste.

Vous aller créer un bouton, se nommant *supprimer*, sur chaque ligne de la liste de voiture. En cliquant sur ce bouton, l'utilisateur supprimera la voiture qui n'existe plus.

Pour supprimer une voiture via notre mini app c'est simple. Il suffit aller sur cette URL avec le bon **id** http://127.0.0.1:8000/cars/delete/**id**. **Attention, vous devez remplacer le mot *id* par la bonne valeur correspondante !**.

Plus haut, je vous ai expliqué que l'id permet de sélectionner une voiture sans ambigüité. Et bien c'est utile en suppression.

### Ajouter une voiture
Le loueur a des nouvelles voitures qui rentrent et aimerait les ajouter.

Créer un formulaire votre page HTML. ce formulaire contiendra les champs suivants (**vous devez respecter le nom des champs, sinon ça marchera pas**):
* Un champ texte qui se nomme *model*, le nom du modèle
* Un champ texte qui se nomme *make*, la marque
* Un champ texte qui se nomme *color*, la couleur
* Un champ texte qui se nomme *price*, le prix de location à la journée
* Une checkbox qui se nomme *available*, pour si la voiture est disponible

Ce formulaire enverra le résultat en AJAX à l'url http://localhost/voitures-api/web/cars en utilisant la méthode *POST*.
