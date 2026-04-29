application/
    controllers/
            Auth.php
            Notes.php
            Bulletin.php
            Etudiants.php
        models/
            NoteModel.php
            BulletinModel.php
            EtudiantModel.php
            MatiereModel.php
    views/
            layouts/ (header, footer communs)
            auth/login.php ← login.html
            dashboard/index.php ← dashboard.html
            notes/form.php ← form.html
            notes/list.php ← list.html
            bulletin/afficher.php
            bulletin/pdf_template.php
    config/
            database.php
            routes.php ← à éditer
            migrations/ (SQL seeds)
    assets/ (style.css, script.js du template)
            vendor/ (TCPDF ou DomPDF)   