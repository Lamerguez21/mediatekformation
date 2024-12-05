# Mediatekformation
## Présentation
Ce site, développé avec Symfony 6.4, permet d'accéder aux vidéos d'auto-formation proposées par une chaîne de médiathèques et qui sont aussi accessibles sur YouTube.<br>
La présentation de l'application d'origine se situe dans le readme du dépôt d'origine qui se trouve à l'adresse suivante :<br>
https://github.com/CNED-SLAM/mediatekformation<br>
La partie back-office a été développée. Elle contient les nouvelles fonctionnalités globales suivantes :<br>

## Front-office
Un lien pour accéder à la partie admin a été ajouté dans la barre de navigation.<br>
Aucune autre modification n'a été réalisée sur la page d'accueil, et des formations, toutes les autres fonctionnalitées sont décrites dans le readme du dépôt d'origine.

### Page des playlists
Une nouvelle colonne a été ajoutée pour afficher le nombre de formations présent dans chaque playlist. Le tri croissant est décroissant sur ce nombre peut être appliqué sur la liste des playlists.<br><br>
![Capture d'écran 2024-12-05 090507](https://github.com/user-attachments/assets/72c84719-86ce-4821-a115-f11e87695251)

### Détail d'une playlist
Dans le détail de chaque playlist le nombre de formations présentes s'affiche.<br><br>
![Capture d'écran 2024-12-05 090715](https://github.com/user-attachments/assets/66bb9970-a96d-438f-b562-bd1edfaac7a9)

## Back-office
### Login
Une authentification avec un login et un mot de passe est requis pour pouvoir accéder à la partie back-office.


## Test de l'application en local
- Vérifier que Composer, Git et Wamserver (ou équivalent) sont installés sur l'ordinateur.
- Télécharger le code et le dézipper dans www de Wampserver (ou dossier équivalent) puis renommer le dossier en "mediatekformation".<br>
- Ouvrir une fenêtre de commandes en mode admin, se positionner dans le dossier du projet et taper "composer install" pour reconstituer le dossier vendor.<br>
- Dans phpMyAdmin, se connecter à MySQL en root sans mot de passe et créer la BDD 'mediatekformation'.<br>
- Récupérer le fichier mediatekformation.sql en racine du projet et l'utiliser pour remplir la BDD (si vous voulez mettre un login/pwd d'accès, il faut créer un utilisateur, lui donner les droits sur la BDD et il faut le préciser dans le fichier ".env" en racine du projet).<br>
- De préférence, ouvrir l'application dans un IDE professionnel. L'adresse pour la lancer est : http://localhost/mediatekformation/public/index.php<br>
