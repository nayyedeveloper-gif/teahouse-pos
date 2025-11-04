import './bootstrap';

// Note: Alpine.js is already included in Livewire
// No need to import it separately to avoid duplicate instances

// Service Worker Registration for PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then(registration => {
                console.log('ServiceWorker registered:', registration);
            })
            .catch(error => {
                console.log('ServiceWorker registration failed:', error);
            });
    });
}

// Network Printer Helper
window.printToNetwork = async (printerIp, printerPort, content) => {
    try {
        const response = await fetch('/api/print', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                printer_ip: printerIp,
                printer_port: printerPort,
                content: content
            })
        });
        
        return await response.json();
    } catch (error) {
        console.error('Print error:', error);
        throw error;
    }
};

// Format currency helper
window.formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount) + ' Ks';
};

// Format date helper
window.formatDate = (date) => {
    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(new Date(date));
};

// Toast notification helper
window.showToast = (message, type = 'success') => {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${
        type === 'success' ? 'bg-green-600' : 
        type === 'error' ? 'bg-red-600' : 
        type === 'warning' ? 'bg-yellow-600' : 
        'bg-blue-600'
    }`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};

// Confirm dialog helper
window.confirmDialog = (message) => {
    return new Promise((resolve) => {
        if (confirm(message)) {
            resolve(true);
        } else {
            resolve(false);
        }
    });
};

// Play notification sound
window.playNotificationSound = () => {
    const audio = new Audio('/sounds/notification.mp3');
    audio.play().catch(e => console.log('Audio play failed:', e));
};

// Vibrate device (for mobile)
window.vibrateDevice = (pattern = [200]) => {
    if ('vibrate' in navigator) {
        navigator.vibrate(pattern);
    }
};

// Check online status
window.isOnline = () => {
    return navigator.onLine;
};

// Online/Offline event listeners
window.addEventListener('online', () => {
    showToast('ချိတ်ဆက်မှု ပြန်လည်ရရှိပါပြီ / Connection restored', 'success');
});

window.addEventListener('offline', () => {
    showToast('အင်တာနက်ချိတ်ဆက်မှု ပြတ်တောက်နေပါသည် / No internet connection', 'warning');
});

// Prevent accidental page refresh
window.addEventListener('beforeunload', (e) => {
    // Only show warning if there's unsaved data
    const hasUnsavedData = document.querySelector('[data-unsaved="true"]');
    if (hasUnsavedData) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Auto-logout on inactivity (30 minutes)
let inactivityTimer;
const resetInactivityTimer = () => {
    clearTimeout(inactivityTimer);
    inactivityTimer = setTimeout(() => {
        if (confirm('သင်၏ session သက်တမ်းကုန်ဆုံးပါပြီ။ ထပ်မံ login ဝင်ရန် လိုအပ်ပါသည်။\n\nYour session has expired. Please login again.')) {
            window.location.href = '/logout';
        }
    }, 30 * 60 * 1000); // 30 minutes
};

// Reset timer on user activity
['mousedown', 'keydown', 'scroll', 'touchstart'].forEach(event => {
    document.addEventListener(event, resetInactivityTimer, true);
});

// Initialize timer
resetInactivityTimer();
