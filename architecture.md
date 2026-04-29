# Gestion des notes 
    Techno : Codeigneter

    L'objectif principale a implementer le plus rapidement :
        Fonctionnaliter : 
            - Ajout de note d'un etudiant
            - Affichage bulletin(il y a des option et on va generer differente bulletin ou relever de note en fonction de l'option)

        ce sont les deux fonctionnaliter qu'on va se focuser , on a deja recue un template 


## Architecture :

    **Module 1 Ajout de notes**
        1 Sélectionner étudiant, matière, semestre
        2 Saisir notes (devoir, examen, TD…)
        3 Calcul automatique moyenne
        4 Validation & enregistrement BDD

    **Module 2 Bulletin / Relevé**
        1 Choix : parcours + étudiant + semestre
        2 Génération bulletin selon option
        3 Calcul crédits (ECTS) validés
        4 Export PDF ou affichage HTML
    
    **Parcours (options bulletin)**
        Développement Bases de Données & Réseaux Web et Design Commun S3 (tronc commun)
        Chaque parcours a ses propres UE au S4. Le bulletin filtre les matières selon le parcours sélectionné.

## Stack technique

    →
    Backend :
    CodeIgniter 3/4 — MVC strict
    →
    Front :
    Template existant (dashboard.html, form.html, list.html)
    →
    PDF :
    Library TCPDF ou DomPDF intégré en CI
    →
    Auth :
    Session CI + login.html existant

## Base de donnees

    Table : etudiants

    Colonne	Type	Note
    id	INT PK AI	
    matricule	VARCHAR(20)	UNIQUE
    nom	VARCHAR(80)	
    prenom	VARCHAR(80)	
    parcours_id	INT FK	→ parcours
    annee_academique	VARCHAR(10)	ex: 2024-2025

    Table : parcours

    Colonne	Type
    id	INT PK AI
    code	VARCHAR(10)
    libelle	VARCHAR(100)
    responsable	VARCHAR(100)

    Table : parcours

    Colonne	Type
    id	INT PK AI
    code	VARCHAR(10)
    libelle	VARCHAR(100)
    responsable	VARCHAR(100)

    Table : matieres

    Colonne	Type
    id	INT PK AI
    code	VARCHAR(10)
    intitule	VARCHAR(150)
    credits	INT
    semestre	TINYINT
    parcours_id	INT FK (NULL=commun)


    Table : notes Centrale
    
    Colonne	Type	Note
    id	INT PK AI	
    etudiant_id	INT FK	→ etudiants
    matiere_id	INT FK	→ matieres
    note_devoir	DECIMAL(5,2)	coef variable
    note_examen	DECIMAL(5,2)	
    moyenne	DECIMAL(5,2)	calculée
    annee_academique	VARCHAR(10)	
    created_at	TIMESTAMP

