document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('search-form');
    
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`search.php?${params}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('search-results').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });
});
