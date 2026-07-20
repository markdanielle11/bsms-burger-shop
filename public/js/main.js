// BSMS - Main JavaScript

// Toggle sidebar on mobile
document.getElementById('menuToggle')?.addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    sidebar?.classList.toggle('active');
});

// Close sidebar when clicking outside
document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (!sidebar?.contains(event.target) && !menuToggle?.contains(event.target)) {
        sidebar?.classList.remove('active');
    }
});

// API Helper
const API = {
    async call(endpoint, method = 'GET', data = null) {
        const options = {
            method,
            headers: {
                'Content-Type': 'application/json'
            }
        };

        if (data && (method === 'POST' || method === 'PUT')) {
            options.body = JSON.stringify(data);
        }

        try {
            const response = await fetch(endpoint, options);
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            return { error: 'Network error' };
        }
    }
};

// Utility Functions
const Utils = {
    formatCurrency(amount) {
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(amount);
    },

    formatDate(date) {
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    },

    showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.textContent = message;
        document.body.prepend(alertDiv);
        
        setTimeout(() => alertDiv.remove(), 5000);
    }
};

console.log('BSMS System loaded successfully');