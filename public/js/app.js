// CRM Frontend - Sadece UI fonksiyonları (Backend PHP ile yapılacak)

// Sidebar toggle (mobil için)
document.addEventListener('DOMContentLoaded', () => {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const body = document.body;

    // Overlay oluştur
    let overlay = document.querySelector('.sidebar-overlay');
    if (!overlay && sidebar) {
        overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
    }

    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
            body.classList.toggle('sidebar-open');
        });

        // Overlay'e tıklayınca kapat
        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
            });
        }

        // Dışarı tıklayınca kapat
        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('active')) {
                if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                    if (overlay) overlay.classList.remove('active');
                    body.classList.remove('sidebar-open');
                }
            }
        });

        // ESC tuşu ile kapat
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                if (overlay) overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
            }
        });
    }

    // Dropdown menüler
    document.querySelectorAll('.dropdown > button').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const parent = btn.parentElement;
            // Diğer açık dropdownları kapat
            document.querySelectorAll('.dropdown.active').forEach(d => {
                if (d !== parent) d.classList.remove('active');
            });
            parent.classList.toggle('active');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown.active').forEach(d => d.classList.remove('active'));
    });

    // Mobilde nav linklerine tıklayınca sidebar'ı kapat
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) {
                if (sidebar) sidebar.classList.remove('active');
                if (overlay) overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
            }
        });
    });
});

// Bildirim gösterme fonksiyonu
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i><span>${message}</span>`;

    if (!document.querySelector('#notification-styles')) {
        const styles = document.createElement('style');
        styles.id = 'notification-styles';
        styles.textContent = `.notification{position:fixed;top:20px;right:20px;padding:1rem 1.5rem;border-radius:12px;display:flex;align-items:center;gap:0.75rem;color:white;font-weight:500;box-shadow:0 10px 25px rgba(0,0,0,0.3);z-index:10000;animation:slideInNotification 0.3s ease forwards}.notification-success{background:linear-gradient(135deg,#22c55e,#10b981)}.notification-error{background:linear-gradient(135deg,#ef4444,#dc2626)}@keyframes slideInNotification{from{opacity:0;transform:translateX(100px)}to{opacity:1;transform:translateX(0)}}`;
        document.head.appendChild(styles);
    }

    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

// Para formatı
function formatCurrency(amount) {
    return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(amount);
}
