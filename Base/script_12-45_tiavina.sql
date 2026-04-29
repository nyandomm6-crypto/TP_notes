-- ============================================================
-- DONNÉES DE TEST - Gestion des notes
-- ============================================================

USE gestion_notes;

-- ============================================================
-- 1. Insérer des étudiants de test
-- ============================================================
INSERT INTO etudiants (matricule, nom, prenom, parcours_id, annee_academique) VALUES
-- Parcours Développement (id=2)
('ETU2024001', 'RAKOTO', 'Jean', 2, '2024-2025'),
('ETU2024002', 'RABE', 'Marie', 2, '2024-2025'),
('ETU2024003', 'ANDRIAMANGA', 'Tiana', 2, '2024-2025'),

-- Parcours Bases de Données & Réseaux (id=3)
('ETU2024004', 'RANDRIANARIVO', 'Fetra', 3, '2024-2025'),
('ETU2024005', 'RAKOTOMALALA', 'Hery', 3, '2024-2025'),
('ETU2024006', 'RASOAMANANA', 'Mamy', 3, '2024-2025'),

-- Parcours Web & Design (id=4)
('ETU2024007', 'RAZAFIMBELO', 'Lova', 4, '2024-2025'),
('ETU2024008', 'RANDRIAMIARISOA', 'Nantenaina', 4, '2024-2025'),
('ETU2024009', 'RAKOTONDRABE', 'Faniry', 4, '2024-2025'),

-- Étudiants année antérieure (pour tester le filtre année)
('ETU2023001', 'RASOLOFO', 'Mampionona', 2, '2023-2024'),
('ETU2023002', 'RAKOTOMAVO', 'Zo', 3, '2023-2024');

-- ============================================================
-- 2. Insérer des notes pour S3 (tronc commun - matieres parcours_id=1)
-- ============================================================

-- Notes pour Jean RAKOTO (id=1) - Parcours DEV
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(1, 1, 12.5, 10.0, 11.00, '2024-2025'),   -- INF201 POO
(1, 2, 14.0, 15.0, 14.60, '2024-2025'),   -- INF202 BDO
(1, 3, 10.0, 11.5, 10.90, '2024-2025'),   -- INF203 Prog système
(1, 4, 11.0, 9.5, 10.10, '2024-2025'),    -- INF208 Réseaux
(1, 5, 8.0, 6.0, 6.80, '2024-2025'),      -- MTH201 Méthodes numériques
(1, 6, 13.0, 12.0, 12.40, '2024-2025');   -- ORG201 Bases gestion

-- Notes pour Marie RABE (id=2) - Parcours DEV (bonne élève)
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(2, 1, 16.0, 15.5, 15.70, '2024-2025'),
(2, 2, 17.0, 16.0, 16.40, '2024-2025'),
(2, 3, 14.0, 13.5, 13.70, '2024-2025'),
(2, 4, 15.0, 14.0, 14.40, '2024-2025'),
(2, 5, 13.0, 12.0, 12.40, '2024-2025'),
(2, 6, 16.0, 15.0, 15.40, '2024-2025');

-- Notes pour Tiana ANDRIAMANGA (id=3) - Parcours DEV (élève moyen)
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(3, 1, 11.0, 9.5, 10.10, '2024-2025'),
(3, 2, 10.0, 11.0, 10.60, '2024-2025'),
(3, 3, 8.5, 9.0, 8.80, '2024-2025'),
(3, 4, 12.0, 10.5, 11.10, '2024-2025'),
(3, 5, 7.0, 6.5, 6.70, '2024-2025'),
(3, 6, 14.0, 13.0, 13.40, '2024-2025');

-- Notes pour Fetra RANDRIANARIVO (id=4) - Parcours BDR
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(4, 1, 13.0, 12.0, 12.40, '2024-2025'),
(4, 2, 15.0, 14.0, 14.40, '2024-2025'),
(4, 3, 11.0, 10.0, 10.40, '2024-2025'),
(4, 4, 14.0, 13.5, 13.70, '2024-2025'),
(4, 5, 9.0, 8.0, 8.40, '2024-2025'),
(4, 6, 12.0, 11.0, 11.40, '2024-2025');

-- ============================================================
-- 3. Insérer des notes pour S4 (UE par parcours)
-- ============================================================

-- Notes S4 pour Jean RAKOTO (id=1) - Parcours DEV
-- INF207 Éléments algorithmique (id=10) - obligatoire
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(1, 10, 13.0, 12.5, 12.70, '2024-2025');

-- INF210 Mini-projet développement (id=11) - obligatoire
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(1, 11, 14.0, 15.0, 14.60, '2024-2025');

-- MTH203 MAO (id=14) - obligatoire
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(1, 14, 12.0, 11.0, 11.40, '2024-2025');

-- UE optionnelle DEV - on prend la meilleure (INF204 SIG = 14.60)
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(1, 7, 15.0, 14.5, 14.70, '2024-2025');   -- INF204 SIG (meilleure note)

-- Notes S4 pour Marie RABE (id=2) - excellente élève
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(2, 10, 17.0, 16.5, 16.70, '2024-2025'),
(2, 11, 18.0, 17.5, 17.70, '2024-2025'),
(2, 14, 16.0, 15.5, 15.70, '2024-2025'),
(2, 9, 16.0, 15.0, 15.40, '2024-2025');   -- INF206 IHM

-- Notes S4 pour Tiana ANDRIAMANGA (id=3) - élève en difficulté
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(3, 10, 8.0, 7.5, 7.70, '2024-2025'),
(3, 11, 10.0, 9.0, 9.40, '2024-2025'),
(3, 14, 6.0, 5.0, 5.40, '2024-2025'),
(3, 7, 9.0, 8.5, 8.70, '2024-2025');     -- INF204 SIG (moyen)

-- Notes S4 pour Fetra RANDRIANARIVO (id=4) - Parcours BDR
INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, annee_academique) VALUES
(4, 10, 14.0, 13.0, 13.40, '2024-2025'),   -- INF207 (commun)
(4, 15, 15.0, 14.5, 14.70, '2024-2025'),   -- INF211 Mini-projet BDR
(4, 16, 13.0, 12.0, 12.40, '2024-2025'),   -- MTH202 Analyse données
(4, 17, 14.0, 13.5, 13.70, '2024-2025');   -- INF205 SI (obligatoire BDR)

-- ============================================================
-- 4. Vérification des données insérées
-- ============================================================
SELECT '=== ÉTUDIANTS ===' AS '';
SELECT id, matricule, nom, prenom, 
       (SELECT libelle FROM parcours WHERE id = etudiants.parcours_id) AS parcours,
       annee_academique
FROM etudiants;

SELECT '=== NOTES ===' AS '';
SELECT e.nom, e.prenom, m.intitule, n.note_devoir, n.note_examen, n.moyenne
FROM notes n
JOIN etudiants e ON e.id = n.etudiant_id
JOIN matieres m ON m.id = n.matiere_id
ORDER BY e.id, m.semestre, m.intitule;