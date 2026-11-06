# PAP – PHP Online Store

Final project (PAP – *Prova de Aptidão Profissional*) for my Professional Course in IT Systems Management and Programming, 2025.

An online store built from scratch in plain PHP using a small MVC structure, without a framework.

## Features

- Customer registration with email confirmation link (PHPMailer over SMTP)
- Customer login / logout with hashed passwords
- Separate admin area with its own login
- Front controller with a simple routing table (`core/classes/rotas.php`, `core/rotas_admin.php`)
- SMTP password stored encrypted (AES-128-GCM), with keys kept in local config
- Store (`loja`) and cart (`carrinho`) pages scaffolded; catalogue and checkout were not finished

## Tech stack

PHP · MySQL · Composer · PHPMailer · Bootstrap 5 · Font Awesome

## Project structure

```
core/
  classes/      Database, routing, email, helpers
  controllers/  Main (store) and Admin controllers
  models/       Clientes, AdminModel
  views/        Store and admin views + layouts
public/         Web root (index.php, admin/, assets/)
#Material/      Database schema (database.sql) and notes
```

## Running locally

1. Install PHP, MySQL (e.g. XAMPP) and Composer.
2. `composer install`
3. Import `#Material/database.sql` into MySQL.
4. Copy `config.example.php` to `config.php` and fill in your database and SMTP settings.
5. Point your web server at `public/` (or open `http://localhost/` with XAMPP).

---

*This was my first full-stack project. You can find my current work, built with Next.js, TypeScript and AI, at [github.com/metarima](https://github.com/metarima).*
