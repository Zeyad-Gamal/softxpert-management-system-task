# Task Management System API

## Setup
1. Clone repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and set DB credentials
4. Run `php artisan migrate --seed`
5. Start server: `php artisan serve`

## Authentication
- Use `/api/login` with seeded users:
  - User: `manager@gmail.com / 123`
  - User: `user@gmail.com / 123`
- Copy the token and set it as **Bearer Token** in Postman

## Endpoints
- POST `/api/login` → Get token
- POST `/api/tasks` → Create task (Manager only)
- GET `/api/tasks` → List tasks (filters)
- GET `/api/tasks/{id}` → Task details with dependencies
- PUT `/api/tasks/{id}` → Update task (Manager)
- PATCH `/api/tasks/{id}/status` → Update status (User only)
- POST `/api/tasks/{id}/dependencies` → Add dependencies (Manager)

## ERD
See :
     `softxpert_task.drawio.png`
     `softxpert_task.drawio`
     `softxpert_task relational model.drawio.png`
     `softxpert_task relational model.drawio`
