
Phase 1 — Setup & Base Priorité 1

    T1 Installer CodeIgniter, configurer BDD (config/database.php)
    T2 Créer les migrations SQL (4 tables : parcours, matieres, etudiants, notes)
    T3 Intégrer le template existant (copier HTML/CSS/JS dans views/)
    T4 Mettre en place le système d'authentification (login.html → Controller Auth)
    T5 Seeder les données : parcours + matières du PDF

Phase 2 — Module Ajout de Notes Priorité 2

    T6 Model NoteModel : insert, update, get_by_etudiant
    T7 Controller Notes : méthodes ajouter(), modifier()
    T8 Vue form.html adaptée : select étudiant + matière + champs notes
    T9 Calcul moyenne automatique (devoir×40% + examen×60%) en Model
    T10 Validation CI (form_validation) + retour message succès/erreur
    T11 Liste des notes saisies (list.html) avec filtre par étudiant/matière

Phase 3 — Module Bulletin Priorité 3

    T12 BulletinModel : requête jointure notes + matieres filtrée par parcours + étudiant + semestre
    T13 Controller Bulletin : méthode afficher() + genererPDF()
    T14 Vue bulletin HTML (par parcours : Développement / BdD-Réseaux / Web-Design)
    T15 Calcul crédits validés (moyenne ≥ 10 → crédits acquis)
    T16 Intégration TCPDF/DomPDF → export bulletin PDF
    T17 Formulaire de sélection : parcours + étudiant + année + semestre

