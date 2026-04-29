Routes clés (config/routes.php):

Route	Controller::Method	Rôle
/login	Auth::index	Formulaire connexion
/dashboard	Dashboard::index	Accueil
/notes/ajouter	Notes::ajouter	Formulaire ajout note
/notes/liste	Notes::liste	Liste des notes
/bulletin	Bulletin::index	Choix parcours/étudiant
/bulletin/afficher	Bulletin::afficher	Bulletin HTML
/bulletin/pdf	Bulletin::genererPDF	Export PDF

NoteModel — méthodes

    → sauvegarder($data)
    → getMoyenne($etudiant, $matiere)
    → getByEtudiant($id, $annee)
    → calculerMoyenne($devoir, $exam)

BulletinModel — méthodes

    → getBulletin($etudiant, $parcours, $semestre)
    → getCreditsValides($etudiant)
    → getMatieresByParcours($parcours_id)
    → getRangEtudiant($etudiant)
