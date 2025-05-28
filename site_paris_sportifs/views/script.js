document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const msgElement = document.getElementById('msg');
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur réseau');
        return response.json();
    })
    .then(data => {
        msgElement.textContent = data.message;
        msgElement.style.color = data.success ? 'green' : 'red';
        if (data.success) {
            form.reset(); // Seulement si l'envoi a réussi
        }
    })
    .catch(error => {
        msgElement.textContent = 'Erreur: ' + error.message;
        msgElement.style.color = 'red';
    });
});