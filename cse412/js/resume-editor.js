// Auto-save functionality
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.section-form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                autoSave(form);
            });
            
            // For text inputs, save after typing stops
            if (input.tagName === 'TEXTAREA' || input.tagName === 'INPUT' && input.type === 'text') {
                let timeout = null;
                input.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        autoSave(form);
                    }, 1000);
                });
            }
        });
    });
    
    function autoSave(form) {
        const formData = new FormData(form);
        formData.append('ajax', '1');
        
        const saveStatus = document.createElement('div');
        saveStatus.className = 'save-status';
        saveStatus.textContent = 'Saving...';
        form.appendChild(saveStatus);
        
        fetch(form.action || window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                saveStatus.textContent = 'Saved!';
                saveStatus.classList.add('success');
                
                setTimeout(() => {
                    saveStatus.remove();
                }, 2000);
            }
        })
        .catch(error => {
            saveStatus.textContent = 'Error saving. Please try again.';
            saveStatus.classList.add('error');
            
            setTimeout(() => {
                saveStatus.remove();
            }, 3000);
        });
    }
});

// Handle current job checkbox
document.addEventListener('DOMContentLoaded', function() {
    const currentCheckboxes = document.querySelectorAll('input[name$="[current]"]');
    
    currentCheckboxes.forEach(checkbox => {
        const index = checkbox.id.match(/\d+/)[0];
        const endDateInput = document.getElementById(`end_date_${index}`);
        
        // Initial state
        if (checkbox.checked) {
            endDateInput.disabled = true;
            endDateInput.value = '';
        }
        
        // Handle change
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                endDateInput.disabled = true;
                endDateInput.value = '';
            } else {
                endDateInput.disabled = false;
            }
        });
    });
});