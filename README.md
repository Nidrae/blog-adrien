Bonjour,

J'ai créé un blog photo, les scripts pour créer la base de données sont fourni dans le dossier script.
Vous pouvez modifier les liens de connexion à la base de donnée MARIADB dans le bdd.php pour que vous puissiez les utiliser. 
J'ai utilisé le modèle MVC vu en formation et sa structure avec controller, view et modèle. Dans le controller il y a la logique, le modèle, il y a les appels à la base de données et les view sont là pour l'affichage.
J'ai mis des doubles sécurités pour le contenu du site, il n'est pas possible de faire des injection sql avec les requêtes préparé. 
Pour toutes les actions administrateur il y a des vérifications de droit à chaque fois sinon cela crée une erreur 405 et au cas où, rien n'est jamais supprimer en base de données. 
Les articles sont soit désactiver, soit cela crée une archive dans une table lorsque elles sont modifiées, pareilles pour le bannissement des utilisateurs ou ils sont simplement désactivés. 
Cela permet que si un utilisateur arrive à voler les identifiant d'un administrateur, toutes les données puissent être restaurées par moi et rien n'est perdu. 
L'administrateur peut bannir des utilisateurs, crée des article, les modifié, les supprimer et les consulter. Un utilisateur peut seulement les consulter.
L'interface est responssive et s'adapter selon la taille de l'écran.

Contrairement à mon dernier site, je ne suis pas reparti de la base de notre blog fait en cours, et fait les modifications/rajouts que je souhaitais pour correspondre aux attentes.
Mais le projet est bien nouveau (les images ont été réutilisées cependant.).

Je me suis tout de même inspiré des systèmes que l'on a vu en cours (comme le mother controller par exemple) car cela me semble cohérent et utile pour la structure de mon site. 

J'ai pris en compte les retours et les attentes pour le projet, et j'espère que ça vous convaincra que j'ai compris les cours php/html/css/js et le fonctionnement du système mvc. 

Cazala Adrien
