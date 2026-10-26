const formCategory = document.getElementById('form-category');
const btnSubmit = document.getElementById('btn-submit-form');

function setLoadingState(isLoading) {
    btnSubmit.disabled = isLoading;
    if (isLoading) {
        btnSubmit.textContent = 'Saving...';
    } else {
        btnSubmit.textContent = 'Save';
    }
}

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
        console.log("Success:", data);
        formCategory.reset();
    })
    .catch(error => {
        console.error("Network error:", error);
    })
    .finally(() => {
        // 3. Unlock the interface regardless
        setLoadingState(false);
    });
});