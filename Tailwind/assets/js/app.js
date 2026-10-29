document.addEventListener('DOMContentLoaded', () => {
    
    // Éléments du DOM
    const tbody = document.getElementById('table-categories-body');
    const btnShowForm = document.getElementById('btn-show-form');
    const btnCancelForm = document.getElementById('btn-cancel-form');
    const sectionForm = document.getElementById('section-form');
    const formCategorie = document.getElementById('form-categorie');
    const btnEnregistrer = document.getElementById('btn-enregistrer-categorie');

    function setLoadingState(isLoading) {
        btnEnregistrer.disabled = isLoading;
        btnEnregistrer.textContent = isLoading ? 'Enregistrement…' : 'Enregistrer';
    }

    // ==========================================
    // 1. CHARGEMENT ASYNCHRONE DES DONNÉES
    // ==========================================
    
    /**
     * Appelle l'API en GET pour récupérer la liste des catégories
     */
    function chargerCategories() {
        fetch('backend/api.php')
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    afficherCategories(result.data);
                } else {
                    console.error("Erreur API :", result.message);
                }
            })
            .catch(error => console.error("Erreur de requête fetch :", error));
    }

    /**
     * Génère le HTML pour insérer les catégories dans le tableau
     */
    function afficherCategories(categories) {
        tbody.innerHTML = ''; // Vider le tableau
        
        categories.forEach(cat => {
            const tr = document.createElement('tr');
            tr.className = "hover:bg-gray-50";
            
            tr.innerHTML = `
                <td class="p-4 text-sm text-gray-500">#${cat.id}</td>
                <td class="p-4 text-sm font-bold text-gray-900">${cat.nom}</td>
                <td class="p-4 text-sm text-gray-600">${cat.couleur}</td>
                <td class="p-4 text-right space-x-2">
                    <button onclick="editerCategorie(${cat.id}, '${cat.nom.replace(/'/g, "\\'")}', '${cat.couleur}', '${cat.icone}')" class="text-primary-600 hover:underline text-sm font-medium">Éditer</button>
                    <button onclick="supprimerCategorie(${cat.id})" class="text-red-600 hover:underline text-sm font-medium">Supprimer</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Fonctions globales pour qu'elles soient accessibles depuis le onclick du HTML généré
    window.editerCategorie = function(id, nom, couleur, icone) {
        // Pré-remplir le formulaire
        document.getElementById('cat-id').value = id;
        document.getElementById('cat-nom').value = nom;
        document.getElementById('cat-couleur').value = couleur;
        document.getElementById('cat-icone').value = icone;
        
        // Afficher le formulaire
        sectionForm.classList.remove('hidden');
        sectionForm.classList.add('block');
        window.scrollTo(0, 0); // Remonter en haut de page
    };

    window.supprimerCategorie = function(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette catégorie ?")) {
            fetch('backend/api.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    chargerCategories();
                } else {
                    alert("Erreur : " + result.message);
                }
            })
            .catch(error => console.error("Erreur de suppression :", error));
        }
    };

    // ==========================================
    // 2. GESTION DE L'AFFICHAGE DU FORMULAIRE
    // ==========================================
    
    btnShowForm.addEventListener('click', () => {
        sectionForm.classList.remove('hidden');
        sectionForm.classList.add('block');
    });

    btnCancelForm.addEventListener('click', () => {
        sectionForm.classList.add('hidden');
        sectionForm.classList.remove('block');
        formCategorie.reset(); // Vider les champs
        document.getElementById('cat-id').value = ''; // Réinitialiser l'ID caché
    });

    // ==========================================
    // 3. SOUMISSION DU FORMULAIRE (SPA)
    // ==========================================
    
    formCategorie.addEventListener('submit', (event) => {
        // Bloquer le rechargement classique de la page HTML
        event.preventDefault();

        // Récupérer les valeurs des champs
        const id = document.getElementById('cat-id').value;
        const nom = document.getElementById('cat-nom').value;
        const couleur = document.getElementById('cat-couleur').value;
        const icone = document.getElementById('cat-icone').value;

        // Déterminer l'action (Création si id est vide, Modification sinon)
        const isUpdate = id !== '';
        
        const data = {
            nom: nom,
            couleur: couleur,
            icone: icone
        };
        
        if (isUpdate) {
            data.id = id;
        }

        const method = isUpdate ? 'PUT' : 'POST';

        // Appel asynchrone vers l'API
        setLoadingState(true);
        fetch('backend/api.php', {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                // Masquer le formulaire et le réinitialiser
                sectionForm.classList.add('hidden');
                formCategorie.reset();
                document.getElementById('cat-id').value = ''; // Réinitialiser l'ID caché
                // show toast
                showToast("Catégorie enregistrée avec succès !", "success");    
                // Recharger la liste pour voir la nouvelle catégorie
                chargerCategories();
            } else {
                alert("Erreur : " + result.message);
            }
        })
        .catch(error => {
            showToast("Erreur réseau : Impossible de contacter le serveur.", "error");
            console.error(error);
        })
        .finally(() => setLoadingState(false));
    });

    // ==========================================
    // DÉMARRAGE : Charger la liste au premier lancement
    // ==========================================
    chargerCategories();

    function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    
    // NB: Vous modifierez ces classes plus tard avec Tailwind !
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    
    container.appendChild(toast);

    // Disparition automatique après 3 secondes
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
});
