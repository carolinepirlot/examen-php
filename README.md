examen-php | Société : La communauté du jeu de _____
==========

Examen de PHP pour le cours d'Alexandre Plennevaux pour l'année 2013-2014

Défi choisi : mon TFE est entièrement fonctionnel (max 20/20)

Société : La communauté du jeu de _____ est un projet réalisé dans le cadre du tfe en DWM à l'ESIAJ de Namur.

Mon but premier était de rendre ce projet entièrement fonctionnel. J'ai donc pris en main le php pour la toute première fois (je n'en n'avais fait que très peu en stage).

J'ai travaillé principalement avec la méthode PDO afin de sécuriser un petit peu plus mon projet. 

Etant donné l'importance du projet et le nombre plutot important de fonctionnalités à réaliser, je ne suis pas parvenue à trier mes fichiers comme vu lors du cours. J'ai préféré simplement séparé et ranger dans un dossier "php" tous les fichiers qui ne contenaient que du php. Ensuite, j'ai ajouté le php destiné à une fonctionnalité dans la page html de cette fonctionnalité. Par exemple, pour l'ajout d'un jeu, j'ai mis mes requetes sql et l'ajout à ma base de donnée dans ce meme fichier. Il était ainsi plus facile pour moi de tout trier ainsi. Si je voulais changer quelque chose à la fonctionnalité de l'édition d'un jeu, il me suffisait d'aller dans la page d'édition de jeu.

Les fonctionnalités réalisées sont :

- Inscription d'un utilisateur / Connexion d'un utilisateur / Déconnexion de l'utilisateur / Edition du profil
- Suppression du compte utilisateur
- Générer une fiche par utilisateur
- Recherche rapide par nom (dans le header) / Recherche avancée multicritères
- Ajout / Edition / Suppression d'un jeu
- Modération pour valider le jeu après son ajout
- Afficher la dernière version (fiche jeu) validée avant vérification de l'édition par un administrateur
- Générer une fiche par jeu après l'ajout
- Création / Edition / Suppression d'un événement
- Générer une fiche par événement après l'ajout
- Inscription / Désinscription à un événement
- Relier les événements à la fiche du jeu concerné
- Relier les événements que l'utilisateur a créé / décidé de participer dans son profil
- Ne plus afficher les événements complets
- Affichage de la liste des jeux et des événements
- Affichage du dernier jeu validé sur l'accueil
- Affichage des 3 derniers événements créés et auxquels l'user participe sur l'accueil
- Commentaires des jeux
- Commentaires des événements
