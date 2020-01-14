

# My Wish List

Projet de programmation web en Php

@IUT Nancy Charlemagne

2019-2020


 - Georgelin Tom
 - Achterfeld Matéo
 - Keller Guillaume
 
## URL vers webetu :

[Lien vers myWishList](https://webetu.iutnc.univ-lorraine.fr/www/keller73u/myWishList)


## Comptes de test

| Username |  email | Password |
|--|--|--|
| Professeur | p@gmail.com | prof|
| Mateo | m@gmail.com| matéo |
| Tom | t@gmail.com| tom|
| Guillaume | g@gmail.com| guillaume|


## Liste des fonctionnalités

Site utilisable sur mobile également (travail avec le pattern flex / responsive)

Cf liste disponible en ligne ( `doc/sujetDetaillé.pdf` )

 - Tom
	 - Routes dans la page index
	 - 3 - Réservation d'item
	 - 11 - Rajouter une image à un item
	 - 12 - Modifier une image d'un item
	 - 13 - Supprimer une image d'un item
	 - 17 - Création du compte
	 - 18 - Gestion de la connexion
	 - 24 - Uploader une image
	 - 99 - Ajout photo de profil pour utilisateur possible
	 - 99 - Rédaction de la documentation : tuto dans le readme ainsi que la phpdoc
 - Matéo
	 - Routes dans la page index
	 - 17 - Création du compte
	 - 18 - Gestion de la connexion
	 - 19 - Modification du compte
	 - 22 - Créer une cagnotte sur un item
	 - 23 - Participer à une cagnotte
	 - 26 - Afficher la liste des créateurs
	 - 27 - Suppression de son compte

 - Guillaume
	 - Routes dans la page index
	 - 1 - Affichage d'une liste de souhaits
	 - 2 - Affichage d'un item
	 - 4 - Ajout de message sur la réservation d'item
	 - 5 - Ajout de message sur une liste
	 - 6 - Création de liste
	 - 7 - Modification de liste
	 - 8 - Ajout d'items
	 - 9 - Modifier un item
	 - 10 - Supprimer un item
	 - 12 - Modifier une image d'un item
	 - 14 - Partage d'une liste
	 - 15 - Consultation des réservations (avant date)
	 - 16 - Consultation des réservations (après date)
	 - 20 - Rendre la liste publique
	 - 21 - Affichage des listes de souhaits publiques 
	 - 19 - Modification du compte
	 - 25 - Vue des participations
	 - 27 - Suppression de son compte
	 - 28 - Ajout de liste à son compte
	 
- Les fonctionnalités numérotées 99 sont des extensions additionnelles
- Fonctionnalités non traités pour le moment : terminé


# Tuto accès fonctionnalités
 - Créer une liste :
 	 - Cas 1 : la personne n'a pas de compte : 
 	 	 - Cliquer sur "Mode invité" puis créer la liste
 	 	 - Compléter de formulaire et valider 
 	 - Cas 2 : la personne a un compte : 
 	 	 - Se connecter 
 	 	 - Cliquer sur le bouton "Créer une liste" sur la page personnelle 
 	 	 - Compléter de formulaire et valider 
 - Ajouter un item à une liste 
 	 - Cas 1 : la personne a un compte et est connecté 
 	 	 - Aller sur sa page personnelle 
 	 	 - Dans la liste des listes, cliquer sur "Modification"
 	 	 - Puis dans la modification de la liste cliquer sur "Ajouter un item dans la liste"
 	 	 - Compléter le formulaire et valider
 	 - Cas 2 : la personne est en mode invité 
 	 	 - Après avoir créé sa liste, utiliser le lien de modification 
 	 	 - Cliquer sur "Ajouter un item dans la liste"
 	 	 - Compléter le formulaire et valider
 - Réserver un cadeau 
 	 - Cliquer sur la liste 
 	 - Cliquer sur l'item désiré 
 	 - Cocher la case "Réserver", laisser un message puis valider avec le bouton "Réserver"
 - Modifier une liste 
 	 - Cas 1 : la personne possède un compte 
	 	 - Aller sur sa page personnelle
	 	 - Cliquer sur modification
	 - Cas 2 : la personne est en mode invité 
	 	 - Utiliser son lien de modification 
- Supprimer une liste 
 	 - Cas 1 : la personne possède un compte 
	 	 - Aller sur sa page personnelle
	 	 - Cliquer sur modification
	 	 - Cliquer sur le bouton "Supprimer la liste"
	 - Cas 2 : la personne est en mode invité 
	 	 - Utiliser son lien de modification
	 	 - Cliquer sur le bouton "Supprimer la liste" 
 - Ajouter un message 
 	 - Accéder à la liste 
 	 - Compléter le formulaire en bas de page puis valider
 - Rendre une liste publique 
 	 - Accéder à la page de modification de la liste 
 	 - Cocher la case publique 
 	 - Valider la modification de la liste 
 - Créer un compte 
 	 - Une fois sur la page principale du site remplir le formulaire puis valider 
 - S'authentifier
 	 - Cliquer sur le bouton "Se connecter"
 	 - Remplir le formulaire puis valider 
 - Modifier son compte
 	 - Sur sa page principale cliquer sur le crayon de modification 
 	 - Changer ses paramètre puis valider 
 - Afficher les listes de souhaits publiques
 	 - Sur la page personnelle cliquer sur le bouton "Afficher les listes publiques"
 - Créer une cagnotte sur un item
 	 - Aller sur la page de l'item sur lequel on souhaite créer une cagnotte 
 	 - Accéder à sa page de modification (via le crayon de modification)
 	 - Créer sur le bouton "Créer une cagnotte pour cet item"
 - Participer à une cagnotte 
 	 - Aller sur la page de l'item 
 	 - Cliquer sur la bouton "Participer à la cagnotte" (sur l'item)
 	 - Remplir le montant souhaité, puis valider 
 - Ajouter une image à un item (upload)
 	 - Cas 1 : création d'un item 
 	 	 - Lors de la création d'un item, ajouter une image
 	 	 - Remplir le formulaire 
 	 	 - Valider
 	 - Cas 2 : modification d'un item 
 	 	 - Accéder à la page de modification d'un item
 	 	 - Ajouter une image 
 	 	 - Valider, bouton "Modifier l'item"
 - Afficher la liste des créateurs
 	 - Cas 1 : la personne n'a pas de compte 
 	 	 - Sur la page d’accueil cliquer sur le bouton "Les créateurs de listes publiques"
 	 - Cas 2 : la personne a un compte 
 	 	 - Sur la page personnelle cliquer sur le bouton "Les créateurs de listes publiques"
 - Supprimer son compte
 	 - Aller sur sa page personnelle 
 	 - Cliquer sur le bouton "Supprimer le compte"
 - Joindre des listes à son compte
 	 - Aller sur sa page personnelle 
 	 - Cliquer sur le bouton "Ajouter une liste par token"
 - Accéder à sa page personnelle 
 	 - Cliquez sur votre nom d'utilisateur présent sur toutes les pages (en haut)
