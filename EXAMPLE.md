#Exemple d'utilisation d'un compiler pass

Service NotificationSystem
    - router de l'application (pour générer les liens)
    - transport
    - moteur templating 


Transport
=> Interface NotificationTransportInterface
    sendMessage()

SmsNotificationTransport implemente NotificationTransportInterface
DiscordNotificationTransport implémente NotificationTransportInterface

app.services.notificationsystem.sms
app.services.notificationsystem.discord