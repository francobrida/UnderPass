# UnderPass | Barcelona Underground Electronic Scene Agenda
UnderPass is a specialized platform designed for the management and community-driven curation of electronic music events within the Barcelona local scene. The application allows users to publish events, verify them through a collective trust system, and participate in a gamification loop based on physical attendance and qualitative feedback.

## 🛠 Technologies
**Backend**: Laravel 12 (PHP 8.2)

**Frontend**: Livewire (Reactive Components), Blade & Tailwind CSS

**Architecture**: Service Layer Pattern to decouple business logic from controllers.

**Database**: MySQL

## 🚀 Installation

1. **Clone the repository**: `git clone https://github.com/francobrida/UnderPass.git`
2. **Install PHP dependencies**: `composer install`
3. **Install Frontend dependencies**: `npm install && npm run build`
4. **Environment Setup**: Copy `.env.example` to `.env` 
    Important: Edit `.env` and set your database credentials `(DB_DATABASE, DB_USERNAME, DB_PASSWORD)`.
    and run `php artisan key:generate`.
5. **Database Setup**: `php artisan migrate --seed`
6. **Storage Link**: `php artisan storage:link` 
7. **Run Server**: `php artisan serve`

## ⚠️ Troubleshooting Storage
If you don't see the flyers after running the command, ensure there isn't an existing (broken) public/storage directory. If it exists, delete it and run the command again:

`rm -rf public/storage`

`php artisan storage:link`

## 🧠 Business Logic & Main Features

1. **Verification System (Vouches)**
To ensure agenda quality, new events are not immediately public.

The Waiting Room: Newly created events enter a "pending" state.

Vouches: Trusted users can grant a "Vouch" (vote of confidence). Once an event reaches 3 Vouches, it is automatically verified (is_verified = true) and published on the main feed.

2. **Gamification: QR Codes & Stamps**
Once an event is verified, the organizer gains access to a unique QR Code on the event's detail page.

Stamp Collection: Attendees scan this QR code at the physical location.

Logic: Scanning the QR awards the user a Stamp (collectible digital badge) in their passport. This Stamp serves as technical proof of attendance and is a prerequisite for providing feedback.

3. **Post-Event Feedback (Vibechecks)**
The system collects qualitative data to maintain high community standards.
A Vibecheck (review) becomes available 6 hours after the event ends, exclusively for users who hold the event's Stamp.

Reward: Completing a Vibecheck (rating sound, safe space, and comments) awards the user 5 points.

4. **Admin Management Panel**
The platform includes a restricted Administrative Dashboard for global oversight.

Full CRUD: Administrators have the authority to create, read, update, and delete any Event or User record.

Moderation: Direct control over event verification status and user role management to ensure community safety.

## 📊 Entity-Relationship Model 

![UnderPass Database Schema](screenshots/diagrama-MER.png)


## 🔐 Test Credentials
To evaluate the platform, use the following pre-seeded accounts (run php artisan migrate --seed first):

1. **Admin**

Email: admin@underpass.com

Password: password

Access: Full Dashboard, User Management, and Event CRUD.

2. **Event Organizer**

Email: organizer@test.com

Password: password

Access: Create Events, View QR Codes, and check Event Feedback.

3. **Clubber (User)**

Email: clubber@test.com

Password: password

Access: Vouch for events, Claim Stamps (Gamification), and submit Vibechecks.

## 🕹️ Quick Testing Guide
Follow this flow to test the UnderPass core logic, from basic CRUD to the Gamification loop:

**Step 1**: Event Creation (Basic CRUD)
Login as: clubber@test.com (password: password).

Action: Go to "MIs Eventos", then "Crear Evento". Fill in the details for a new underground party.

Logic: The event is created with is_verified = false. It will not appear in the main feed yet; instead, it goes directly to the Waiting Room.

**Step 2**: Vouching (Community Power)
Login as: clubber@test.com.

Action: Go to the Waiting Room. Find the event you just created (or the one named "Test Event no verificado" from the Seeder).

Logic: Events need 3 "vouches" to be published. Since you cannot vouch for your own event, the Seeder provides other pending events. Once a "Clubber" event reaches the 3-vouch limit, it is published, and the User Role is automatically promoted to "Organizer".

**Step 3**: The QR & Stamping (Scan Simulation)
Login as: organizer@test.com.

Action: Go to "Mis Eventos" and enter the verified event "Main Stage Techno".

Logic: As the owner of a verified event, the QR Code (Stamp Token) will be displayed.

Simulate Scan: Click the "Descargar QR" button or copy the link. Accessing that URL while logged in as a Clubber will automatically generate a Stamp in the user's account.

**Step 4**: Sellos y Puntos (The Passport)
Login as: clubber@test.com.

Action: Enter the "Sellos y Puntos" section.

Logic: Check your stamp collection (including "Flashback Night" from the Seeder) and your updated point counter. This is the visual proof of your clubbing history.

**Step 5**: VibeCheck (Post-Event Feedback)
Login as: clubber@test.com.

Action: Within "Sellos y Puntos", find the event "Noche de Vinilo & Techno".

Logic: Because the event has ended and you have the Stamp, the "DEJAR VIBECHECK" button is active. Submit the rating to earn +5 extra points.

**Step 6**: Admin Panel (Moderation)
Login as: admin@underpass.com.

Action: Access the Admin Panel.

Logic: Perform CRUD operations on users and events. Admins can manually verify events or delete inappropriate content to keep the platform safe.

## 📸 Demo & Screenshots

Main Agenda: 
![Main Events Agenda](screenshots/agenda.png)

Waiting Room: 
![Waiting Room](screenshots/waiting-room.png)

Organizer Event View (with QR) : 
![Event view](screenshots/event-view.png)

Admin Panel (User and Event CRUD):
![Admin view](screenshots/admin.png)

User Passport (Stamps and Points): 
![Passport view](screenshots/stamps.png)

## 📈 Scalability & Future Improvements

Frontend Consistency: Some views are inconsistent with the overall design language.

Organizer Rating System: Implementation of a reputation score for organizers based on the average ratings of their past Vibechecks.

Point Benefist:A dedicated module to exchange accumulated points for exclusive community benefits or partner discounts.

Local Expansion? : The neighborhood-based filtering architecture is designed to scale to other underground hubs by simply updating the location datasets.
