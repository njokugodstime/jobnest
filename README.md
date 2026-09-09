# JobNest

A job board web application built with Laravel, where employers post job listings and candidates apply — featuring role-based access, application tracking, and full authentication.

## Features
- Role-based accounts: Employer and Candidate (Job Seeker)
- Employers: post, edit, delete job listings; view and manage applicants; update application status
- Candidates: browse and search jobs by title/type; apply with a cover letter and resume upload; track application status
- Authentication via Laravel Breeze (register, login, logout, profile management)
- Search and filter job listings by title and job type
- Pagination on job listings

## Tech Stack
- Laravel 12 (PHP 8.2)
- MySQL with Eloquent ORM
- Blade templating with Tailwind CSS
- Laravel Breeze for authentication
- Git/GitHub for version control

## Setup
1. Clone the repo
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database credentials
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `npm install && npm run build`
7. Run `php artisan serve`

## Live Demo
*(add link once deployed)*

## Author
Godstime Njoku — [GitHub](https://github.com/njokugodstime) | [Portfolio](https://njokugodstime.com)