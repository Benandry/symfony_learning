self.addEventListener('push', (event) => {
    if (event.data) {
      try {
        const data = event.data.json();
        const title = data.title || 'Notification';
        const body = data.body || 'You have a new message.';
      } catch (error) {
        body = event.data.text();
      }
    
    }

    event.waitUntil(self.registration.showNotification(title, {
      body: body,
      icon: '/icons/icon-192x192.png',
      tag : "Symfony push tag example"
    }));

    self.addEventListener('notificationclick', function(event) {
      event.notification.close();
      event.waitUntil(
        clients.openWindow('/contact')
      );
    })

});
