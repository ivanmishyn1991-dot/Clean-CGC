let city = '';
let message = '';
message += 'City: ' + ($('#city')?.value?.trim() || '') + "<br>";
message += 'Postal: ' + ($('#postal')?.value?.trim() || '') + "<br>";
message += 'Address: ' + ($('#address')?.value?.trim() || '') + "<br>";
message += 'Contact Method: ' + contact + "<br>";
message += 'Promo: ' + ($('#promo')?.value?.trim() || '') + "<br>";
message += 'Services: ' + ($('#promo')?.value?.trim().join(', ') || '') + "<br>";
message += 'Promo: ' + ($('#notes')?.value?.trim() || '') + "<br>";

const payload = {
    name: $('#name')?.value?.trim() || '',
    phone: $('#phone')?.value?.trim() || '',
    email: $('#email')?.value?.trim() || '',
    message: message,
    consent_terms: $('#consentTerms')?.checked || false,
    consent_contact_all: $('#consentContactAll')?.checked || false
};

fetch('/applications', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(payload)
})
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Успешно отправлено:', data);
    })
    .catch(error => {
        console.error('Ошибка при отправке:', error);
    });