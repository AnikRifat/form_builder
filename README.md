# Form Builder

A dynamic form builder application built with Laravel, Inertia.js, and Vue.js. Create, manage, and deploy custom forms with an intuitive drag-and-drop interface.

## Quick Links

- [Live Demo](#) <!-- Add your live demo link if available -->
- [Documentation](#features)
- [Installation Guide](#installation-steps)
- [Bug Report](https://github.com/AnikRifat/form_builder/issues)

## Requirements

- PHP >= 8.2
- Node.js >= 16
- Composer
- NPM or Yarn
- MySQL 5.7+ or MariaDB 10.3+

## Installation Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/AnikRifat/form_builder.git
   cd form_builder
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node Dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   # Copy the environment file
   cp .env.example .env
   ```

5. **Configure Environment File**
   - Open `.env` file and update the following:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```

6. **Default Admin Credentials**
   ```
   Email: admin@gmail.com
   Password: password
   ```

7. **Setup Database**


8. **Application Setup**
   ```bash
   # Generate application key
   php artisan key:generate
   
   # Run database migrations & seeders
   php artisan migrate:fresh --seed
   ```

9. **Start Development Servers**
   In separate terminal windows:
   ```bash
   # Start Laravel development server
   php artisan serve
   
   # Start Vite development server
   npm run dev
   ```

   Or use the combined command:
   ```bash
   composer run dev
   ```

10. **Access the Application**
   - Open your browser and visit: `http://localhost:8000`
   - Default login credentials:
     - Email: `admin@example.com`
     - Password: `password`

## Field Types

- Text Input
- Email Input
- Textarea
- Checkbox
- Radio Buttons
- Select/Dropdown

### Features
- Laravel + Vue.js + Inertia.js stack
- TypeScript support
- Component-based architecture
- RESTful API endpoints
- Form validation helpers
- Extensible field type system
- Create and edit forms
- Save form configurations
- Form Display

## Troubleshooting

1. If you encounter any permission issues:
   ```bash
   chmod -R 777 storage bootstrap/cache
   ```

2. If composer packages are not autoloading:
   ```bash
   composer dump-autoload
   ```

3. If npm packages are not working properly:
   ```bash
   rm -rf node_modules
   rm package-lock.json
   npm install
   ```
