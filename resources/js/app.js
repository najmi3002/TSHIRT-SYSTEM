import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Notification Logic
if (typeof window.userId !== 'undefined') {

    const notificationSound = new Audio('/sounds/notification.mp3'); 
    let originalTitle = document.title;
    let notificationCount = 0;

    // Listen for new message notifications on the user's private channel
    window.Echo.private(`App.Models.User.${window.userId}`)
        .listen('NewMessageNotification', (e) => {
            console.log('Notification received:', e);
            
            // Show the notification dot
            if(window.userRole === 'admin') {
                document.getElementById('orders-notification-dot')?.classList.remove('hidden');
            } else {
                document.getElementById('designs-notification-dot')?.classList.remove('hidden');
            }

            // Play sound only if the tab is not active
            if (document.hidden) {
                notificationSound.play().catch(error => console.error("Error playing sound:", error));
                
                // Update page title
                notificationCount++;
                document.title = `(${notificationCount}) ${originalTitle}`;
            }
        });

    // Reset title when tab is focused
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) {
            notificationCount = 0;
            document.title = originalTitle;
        }
    });

    // Hide notification dot when the relevant link is clicked
    const hideNotificationDot = () => {
        if(window.userRole === 'admin') {
            document.getElementById('orders-notification-dot')?.classList.add('hidden');
        } else {
            document.getElementById('designs-notification-dot')?.classList.add('hidden');
        }
    };
    
    document.querySelector('a[href*="admin/orders"]')?.addEventListener('click', hideNotificationDot);
    document.querySelector('a[href*="/designs"]')?.addEventListener('click', hideNotificationDot);
}