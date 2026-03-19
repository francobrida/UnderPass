## UnderPass | Barcelona Community Event Agenda
UnderPass is a specialized platform designed for the management and community-driven curation of electronic music events within the Barcelona local scene. The application allows users to publish events, verify them through a collective trust system, and participate in a gamification loop based on physical attendance and qualitative feedback.

## 🛠 Technologies
Backend: Laravel 12 (PHP 8.2)

Frontend: Livewire (Reactive Components), Blade & Tailwind CSS

Architecture: Service Layer Pattern to decouple business logic from controllers.

Database: MySQL

Validation: Form Request Classes for clean data handling and centralized authorization.

## 🚀 Installation
Clone the repository: git clone [https://github.com/francobrida/UnderPass]

Install PHP dependencies: composer install

Install Frontend dependencies: npm install && npm run build

Environment Setup: Copy .env.example to .env and run php artisan key:generate.

Migrations & Seeders: php artisan migrate --seed

Run Server: php artisan serve

## 🧠 Business Logic & Main Features

1.Verification System (Vouches)
To ensure agenda quality, new events are not immediately public.

The Waiting Room: Newly created events enter a "pending" state.

Vouches: Trusted users can grant a "Vouch" (vote of confidence). Once an event reaches 3 Vouches, it is automatically verified (is_verified = true) and published on the main feed.

2.Gamification: QR Codes & Stamps
Once an event is verified, the organizer gains access to a unique QR Code on the event's detail page.

Stamp Collection: Attendees scan this QR code at the physical location.

Logic: Scanning the QR awards the user a Stamp (collectible digital badge) in their passport. This Stamp serves as technical proof of attendance and is a prerequisite for providing feedback.

3.Post-Event Feedback (Vibechecks)
The system collects qualitative data to maintain high community standards.
A Vibecheck (review) becomes available 6 hours after the event ends, exclusively for users who hold the event's Stamp.

Reward: Completing a Vibecheck (rating sound, safe space, and comments) awards the user 5 points.

4.Admin Management Panel
The platform includes a restricted Administrative Dashboard for global oversight.

Full CRUD: Administrators have the authority to create, read, update, and delete any Event or User record.

Moderation: Direct control over event verification status and user role management to ensure community safety.

## 📊 Entity-Relationship Model 

![UnderPass Database Schema](screenshots/diagrama-MER.png)

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