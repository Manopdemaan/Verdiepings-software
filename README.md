# Payment - Laravel Project

## Beschrijving
Payment Tracker is een kleine webapplicatie gemaakt in Laravel.  
Het doel van dit project is om te leren hoe **Google login**, **Stripe webhooks** en **queue jobs** werken in Laravel.

Op het dashboard kunnen betalingen en facturen bekeken en gedownload worden. Dit project is bedoeld voor **testen en leren**, niet voor echte betalingen.

---

## Vereisten
Voordat je het project kan draaien, heb je nodig:
- PHP >= 8.1
- Composer
- SQLite
- Laravel
- Stripe CLI (voor testen van webhooks)

---

## Installatie stap voor stap

Volg deze stappen om het project lokaal op te zetten.

1. **Clone de repository**
```bash
git clone
Installeer PHP dependencies

composer install
Laravel gebruikt Composer om packages en libraries te installeren die nodig zijn voor de app.

Maak een .env bestand aan

cp .env.example .env
Het .env bestand bevat alle instellingen zoals database en API keys.

Vul de environment variabelen in
Kopieer dit in je .env bestand (dit zijn test keys, veilig om mee te testen):

ini
Copy code
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:icMb9Cd12Y7IBlTfUkW0TsgDJJ+cRLzOhZINewuXgM4=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite

GOOGLE_CLIENT_ID=291589408245-ls8vcbhkvgo9v48sjgj033p5slp14m6e.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback

STRIPE_KEY=pk_test_51SMn4xGq56j8BU8nI3HPnsPwnES6NpLjbfsZ0jlmxVB9Li0yfeCoBLCRodVctmw70QyT4CNoDxwWqXv2qHBfYejI00j6hgy4CN
STRIPE_SECRET=sk_test_51SMn4xGq56j8BU8nT3UjuwJZogagfp4QXvUCpArrirzNqcndtRhojTK6EQZi1THK6SkFz5dtXJ6lmUkRpG3rebly00NtoQkpVU
STRIPE_WEBHOOK_SECRET=whsec_719244f4c6e1c918c679b080555d4143c6250665901e2dc5b25e4c8b2d0c1a4d
Let op: dit zijn test keys, alleen voor de Stripe testomgeving. Geen echte betalingen.

Genereer de Laravel app key

php artisan key:generate
Dit maakt de app veilig en zorgt dat encryptie werkt.

Start de database migraties

php artisan migrate
Dit maakt alle tabellen aan in je database, bijvoorbeeld voor users en payments.

Start de queue worker

php artisan queue:work
Queue jobs zorgen ervoor dat webhooks en andere taken op de achtergrond verwerkt worden.
Belangrijk: dit moet draaien, anders worden betalingen niet verwerkt.

Start de Laravel server

php artisan serve
Nu draait de app lokaal op http://127.0.0.1:8000

Start Stripe CLI om webhooks te forwarden

Login bij Stripe CLI
stripe login

Dit opent een browser. Log in met je Stripe testaccount.
Zonder deze stap werkt het forwarden van webhooks niet.

stripe listen --forward-to http://127.0.0.1:8000/webhook
Dit zorgt dat Stripe test-events naar je lokale app gestuurd worden.

Testen van de applicatie
Open je browser en ga naar:

http://127.0.0.1:8000/dashboard
Betaalgegevens en facturen verschijnen automatisch als er testdata aanwezig is in de database.

Gebruik de Download knop om PDF-facturen te bekijken.

De app gebruikt SQLite dus er is geen externe database nodig.

De Google login werkt met de test credentials in .env.
