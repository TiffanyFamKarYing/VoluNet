# VoluNet

VoluNet is a PHP web app that connects volunteers with paid and unpaid opportunities across Malaysia. Users can browse and filter opportunities, apply to them, track their applications, and access curated learning resources. Admins get a dashboard to manage opportunities, resources, users, and applications.

## Features

- **Public pages** — Home, About, Opportunities (search/filter by keyword, sector, location, paid/unpaid), Resources (courses, tutorials, certificates)
- **Auth** — Register, login, logout, session timeout after 30 minutes of inactivity, CSRF-protected forms
- **User area** — Profile, My Applications, apply to opportunities with a cover letter (duplicate-application check included)
- **Admin dashboard** — Add/edit/delete opportunities and resources, manage users, review and update application status, at-a-glance stats
- **Backend** — [Supabase](https://supabase.com) (PostgreSQL) accessed via its REST API, no local database or ORM required

## Tech Stack

| Layer | Technology |
|---|---|
| Server | PHP (procedural, no framework) |
| Database | Supabase (PostgreSQL) via REST API + Row Level Security |
| Frontend | HTML, CSS, vanilla JavaScript |
| Fonts / Icons | Google Fonts (Plus Jakarta Sans, Lora), Font Awesome 6 (via CDN) |

## Project Structure

```
volunet/
├── index.php                     Home page
├── aboutus.php                   About page
├── opportunity.php               Browse/search opportunities
├── opportunity_details.php       Single opportunity + apply form
├── resources.php                 Learning resources
├── login.php / register.php      Auth
├── logout.php
├── profile.php                   Logged-in user's profile
├── my_applications.php           Logged-in user's applications
├── admin.php                     Admin dashboard
├── config.php                    Session setup, Supabase client, CSRF & auth helpers
├── partials/
│   ├── head.php                       <head>, global CSS, fonts, icons
│   ├── header.php                     Site nav (desktop + mobile)
│   ├── footer.php                     Site footer + shared JS
│   └── opportunity_form_fields.php    Shared add/edit opportunity form (used by admin.php)
├── png_vd/                       Opportunity images (.png) and demo video
├── seed_data.sql                 Table definitions, seed data, and RLS policies
└── video.txt                     Demo video link
```

> **Note:** `head.php`, `header.php`, `footer.php`, and `opportunity_form_fields.php` are all included from other pages via a `partials/` subfolder. Make sure all four files live inside `partials/` (create it if it doesn't already exist) — otherwise the `include`/`require` calls in `index.php`, `admin.php`, etc. won't resolve.
>
> `opportunity.php` and `opportunity_details.php` reference images by path like `png_vd/Web_Developer_for_NGO_Website.png`, so the `png_vd/` folder (containing the opportunity photos and the demo video) needs to sit in the project root alongside these PHP files.

## Requirements

- PHP 8.0 or newer, with the **cURL** extension enabled
- A web server (Apache, Nginx, or PHP's built-in server) with PHP support
- A Supabase project (free tier is enough)
- Internet access (the app pulls fonts/icons from CDNs and images from Unsplash)

## Setup & Installation

### 1. Get the files onto your server

Place all the `.php` files in your web root, and make sure `head.php`, `header.php`, and `footer.php` sit inside a `partials/` folder next to them (see Project Structure above).

### 2. Set up the database

1. Create a project at [supabase.com](https://supabase.com).
2. Open the **SQL Editor** in your Supabase dashboard.
3. Run the contents of `seed_data.sql`. This creates the `users`, `opportunities`, `applications`, and `resources` tables, enables Row Level Security with public-access policies, and seeds sample opportunities and resources.
4. In **Project Settings → API**, copy your **Project URL**, **anon public key**, and **service_role key**.

### 3. Configure the app

Open `config.php` and replace the placeholders with your own Supabase credentials:

```php
define('SUPABASE_URL', 'https://YOUR-PROJECT-REF.supabase.co');
define('SUPABASE_KEY', 'YOUR-ANON-PUBLIC-KEY');
define('SUPABASE_SERVICE_KEY', 'YOUR-SERVICE-ROLE-KEY');
```

⚠️ **Keep `config.php` out of version control / public access** — the service role key bypasses Row Level Security and should never be exposed to the browser or committed to a public repo.

### 4. Create an admin account

1. Register a normal account through the app's Register page.
2. In the Supabase SQL Editor, run:
   ```sql
   UPDATE users SET is_admin = true WHERE email = 'your-email@example.com';
   ```
3. Log back in — you'll now see the **Admin** link in the nav.

### 5. Run it locally

Using PHP's built-in server from the project root:

```bash
php -S localhost:8000
```

Then open **http://localhost:8000** in your browser.

Alternatively, point an Apache/Nginx virtual host's document root at the project folder.

## Usage

- **Volunteers:** Register → browse Opportunities → filter by sector/location/type → open an opportunity → Apply Now with a cover letter → track status under My Applications.
- **Admins:** Log in with an admin account → open the Admin link in the nav → add/edit/delete opportunities and resources, manage users, and review/update application statuses.

## Security Notes

- Passwords are hashed with `password_hash()` (bcrypt) before storage.
- All forms are protected with CSRF tokens (`csrfField()` / `csrfVerify()` in `config.php`).
- Sessions expire after 30 minutes of inactivity and use `httponly` + `samesite=Lax` cookies.
- Supabase Row Level Security policies in `seed_data.sql` are currently set to **public** access for simplicity — tighten these before deploying to production.

## Demo

A walkthrough video is linked in `video.txt`.
