<?php
require_once __DIR__ . '/classes/GestionCategorie.php';

header('Content-Type: application/json');

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $gestionCategorie = new GestionCategorie();

    if ($method === 'GET') {
        // --- LECTURE (GET) ---
        $categories = $gestionCategorie->getAll();
        
        // Initialiser avec 2 données par défaut si c'est vide pour l'apprentissage
        if (empty($categories)) {
            $cat1 = new Categorie("Développement Web", "Bleu", "Code");
            $gestionCategorie->create($cat1);
            $cat2 = new Categorie("Design UI/UX", "Rose", "Pinceau");
            $gestionCategorie->create($cat2);
            $categories = $gestionCategorie->getAll(); // re-lire après création
        }

        $response = [];
        foreach ($categories as $cat) {
            $response[] = [
                'id' => $cat->getId(),
                'nom' => $cat->getNom(),
                'couleur' => $cat->getCouleur(),
                'icone' => $cat->getIcone()
            ];
        }

        echo json_encode([
            'status' => 'success',
            'data' => $response
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    } elseif ($method === 'POST') {
        // --- CRÉATION (POST) ---
        // Le JS enverra des données JSON
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);
        
        if (isset($input['nom']) && isset($input['couleur']) && isset($input['icone'])) {
            $newCat = new Categorie($input['nom'], $input['couleur'], $input['icone']);
            if ($gestionCategorie->create($newCat)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Catégorie ajoutée avec succès !'
                ]);
            } else {
                throw new Exception("Erreur lors de l'enregistrement dans le JSON.");
            }
        } else {
            throw new Exception("Données incomplètes pour la création.");
        }

    } elseif ($method === 'PUT') {
        // --- MODIFICATION (PUT) ---
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);
        
        if (isset($input['id']) && isset($input['nom']) && isset($input['couleur']) && isset($input['icone'])) {
            $cat = new Categorie($input['nom'], $input['couleur'], $input['icone'], $input['id']);
            if ($gestionCategorie->update($cat)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Catégorie modifiée avec succès !'
                ]);
            } else {
                throw new Exception("Catégorie introuvable ou erreur de modification.");
            }
        } else {
            throw new Exception("Données incomplètes pour la modification.");
        }

    } elseif ($method === 'DELETE') {
        // --- SUPPRESSION (DELETE) ---
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);
        
        if (isset($input['id'])) {
            if ($gestionCategorie->delete($input['id'])) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Catégorie supprimée avec succès !'
                ]);
            } else {
                throw new Exception("Catégorie introuvable ou erreur de suppression.");
            }
        } else {
            throw new Exception("ID manquant pour la suppression.");
        }
    } else {
        throw new Exception("Méthode HTTP non supportée.");
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
