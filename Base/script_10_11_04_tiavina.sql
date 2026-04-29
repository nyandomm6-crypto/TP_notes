-- ============= Tiavina (10:25) ============]

-- ============================================================
-- AJUSTEMENTS POUR MODULE ETUDIANT
-- ============================================================

-- 1. Ajouter une table users pour l'authentification
CREATE TABLE IF NOT EXISTS users (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        ENUM('admin', 'enseignant', 'etudiant') DEFAULT 'enseignant',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Ajouter un compte admin par défaut (password = 'password' en hash)
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@gesnotes.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- 3. Ajouter un index sur le nom pour les recherches rapides
CREATE INDEX idx_etudiants_nom ON etudiants(nom(20));
CREATE INDEX idx_etudiants_prenom ON etudiants(prenom(20));

-- 4. Ajouter un index composite pour la recherche multicritère
CREATE INDEX idx_etudiants_recherche ON etudiants(nom, prenom, matricule);

-- 5. Ajouter une contrainte de validation sur le matricule (format unique)
ALTER TABLE etudiants 
ADD CONSTRAINT chk_matricule_format 
CHECK (matricule REGEXP '^[A-Z0-9]{6,20}$');