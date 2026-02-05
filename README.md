# Symfony Blog Application

A beautifully designed blog application built with Symfony to showcase basic Symfony features.

## Features Showcased

- **Entity**: Doctrine entities for Post and Comment with relationships
- **Migration**: Database migrations to create tables
- **Controller**: Controllers handling web and API requests
- **DTOs**: Data Transfer Objects for API responses
- **Requests**: Validation classes for form requests
- **Dependency Injection**: Services injected into controllers
- **Routing**: Route annotations for web and API endpoints
- **Basic Standards**: Following Symfony conventions and best practices

## Design Features

- **Modern UI**: Clean, responsive design with gradient backgrounds
- **Interactive Elements**: Hover effects, smooth transitions, and shadows
- **Typography**: Google Fonts (Inter) for better readability
- **Color Scheme**: Beautiful gradient themes with purple/blue accents
- **Responsive**: Mobile-friendly layout
- **User Feedback**: Flash messages for success/error states

## Installation

1. Clone the repository
2. Run `composer install`
3. Configure database in `.env` (SQLite is used by default)
4. Run `php bin/console doctrine:migrations:migrate`
5. Load fixtures: `php bin/console doctrine:fixtures:load`
6. Start the server: `symfony server:start`

## Routes

### Web Routes

- `GET /` - List all posts
- `GET /posts/{id}` - Show a single post with comments
- `GET|POST /posts/create` - Create a new post
- `POST /posts/{id}/comments` - Add a comment to a post

### API Routes

- `GET /api/posts` - Get all posts (JSON)
- `GET /api/posts/{id}` - Get a single post (JSON)
- `GET|POST /api/posts/{id}/comments` - Get/add comments for a post (JSON)

## Usage

1. Visit `http://127.0.0.1:8000` to see the blog
2. Create posts using the "Create New Post" link
3. View posts and add comments
4. Use API endpoints for JSON responses

## Technologies Used

- Symfony 8.0
- Doctrine ORM
- Twig templating
- SQLite database
- Symfony Forms and Validation
- Custom CSS with modern design principles
