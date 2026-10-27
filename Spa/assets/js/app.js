// 1. Dynamic Toast Creation Function
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    
    // Note: You will update these classes later using Tailwind!
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    
    container.appendChild(toast);

    // Automatic removal after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// DOM Elements
const formCategory = document.getElementById('form-category');
const btnSubmit = document.getElementById('btn-submit-form');

// Loading State Handler
function setLoadingState(isLoading) {
    btnSubmit.disabled = isLoading;
    if (isLoading) {
        btnSubmit.textContent = 'Saving...';
    } else {
        btnSubmit.textContent = 'Save';
    }
}

// 2. Integration into the Form Submit Event
formCategory.addEventListener('submit', (e) => {
    e.preventDefault();

    // 1. Lock the interface
    setLoadingState(true);

    // 2. API call to your backend
    fetch('api/controllers/CategoryController.php', {
        method: 'POST',
        body: new FormData(formCategory)
    })
    .then(response => response.json())
    .then(data => {
        // Replaced console.log() with visual UX feedback!
        showToast("Category successfully saved!", "success");
        formCategory.reset();
    })
    .catch(error => {
        showToast("Network error: Unable to reach the server.", "error");
        console.error("Network error:", error);
    })
    .finally(() => {
        // 3. Unlock the interface regardless
        setLoadingState(false);
    });
});