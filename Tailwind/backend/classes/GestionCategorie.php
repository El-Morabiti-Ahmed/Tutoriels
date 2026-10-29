<?php
require_once __DIR__ . '/../Categorie.php';

class GestionCategorie
{
    private static string $dataFile = __DIR__ . '/../data/categories.json';

    /**
     * @return Categorie[]
     */
    public function getAll(): array
    {
        if (!file_exists(self::$dataFile)) {
            return [];
        }

        $json = @file_get_contents(self::$dataFile);
        if ($json === false) {
            throw new RuntimeException('Impossible de lire le fichier des catégories.');
        }

        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            throw new UnexpectedValueException('Le fichier des catégories doit contenir une liste JSON.');
        }

        $categories = [];
        foreach ($data as $item) {
            if (!is_array($item)) {
                throw new UnexpectedValueException('Une catégorie du fichier JSON est invalide.');
            }

            $categories[] = new Categorie(
                $item['nom'] ?? '',
                $item['couleur'] ?? '',
                $item['icone'] ?? '',
                $item['id'] ?? null
            );
        }

        return $categories;
    }

    public function create(Categorie $categorie): bool
    {
        $categories = $this->getAll();
        $maxId = 0;

        foreach ($categories as $existingCategorie) {
            $maxId = max($maxId, (int) $existingCategorie->getId());
        }

        $categorie->setId($maxId + 1);
        $categories[] = $categorie;

        return $this->saveAll($categories);
    }

    public function update(Categorie $categorie): bool
    {
        if ($categorie->getId() === null) {
            return false;
        }

        $categories = $this->getAll();
        foreach ($categories as $index => $existingCategorie) {
            if ($existingCategorie->getId() == $categorie->getId()) {
                $categories[$index] = $categorie;
                return $this->saveAll($categories);
            }
        }

        return false;
    }

    public function delete(int|string $id): bool
    {
        if ($id === '') {
            return false;
        }

        $categories = $this->getAll();
        $remainingCategories = array_filter(
            $categories,
            static fn (Categorie $categorie): bool => $categorie->getId() != $id
        );

        if (count($remainingCategories) === count($categories)) {
            return false;
        }

        return $this->saveAll(array_values($remainingCategories));
    }

    /**
     * @param Categorie[] $categories
     */
    private function saveAll(array $categories): bool
    {
        $data = [];
        foreach ($categories as $categorie) {
            $data[] = [
                'id' => $categorie->getId(),
                'nom' => $categorie->getNom(),
                'couleur' => $categorie->getCouleur(),
                'icone' => $categorie->getIcone(),
            ];
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        return file_put_contents(self::$dataFile, $json, LOCK_EX) !== false;
    }
}
