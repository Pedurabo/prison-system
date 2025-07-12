# Prison Management System

A comprehensive Laravel-based Prison Management System with role-based access control, modern UI, and complete CRUD operations for all prison management modules.

## 🚀 Features

### Core Modules
- **User Management**: Role-based authentication (Admin, Guard, Medical, Rehabilitation, Maintenance)
- **Inmate Management**: Complete CRUD operations, release tracking, medical records
- **Staff Management**: Employee records, shift monitoring, security clearance levels
- **Security Incidents**: Incident reporting, resolution tracking, status management
- **Medical Records**: Health tracking, follow-ups, inmate medical history
- **Rehabilitation Programs**: Program enrollment, progress tracking, completion status
- **Visit Management**: Visitor registration, approval workflow, scheduling
- **Food Services**: Meal planning, dietary requirements, service tracking
- **Maintenance Requests**: Facility maintenance, request tracking, priority management
- **Department Management**: Organizational structure, role assignments

### Technical Features
- **Modern UI**: Bootstrap 5 with responsive design
- **Role-based Access Control**: Secure middleware implementation
- **Database Seeding**: Comprehensive test data for all modules
- **Migration System**: Complete database schema with relationships
- **RESTful Controllers**: Standardized API endpoints
- **Form Validation**: Client and server-side validation
- **Search & Filter**: Advanced data filtering capabilities

## 🛠️ Technology Stack

- **Backend**: Laravel 11 (PHP 8.1+)
- **Frontend**: Bootstrap 5, Blade Templates
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Authentication**: Laravel's built-in auth system
- **Styling**: CSS3, Bootstrap 5 components

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- Node.js & NPM (for asset compilation)
- SQLite (for development)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Pedurabo/prison-system.git
   cd prison-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   - Open your browser and navigate to `http://127.0.0.1:8000`

## 👥 User Roles & Access

### Admin
- Full system access
- User management
- System configuration
- Reports and analytics

### Guard
- Inmate monitoring
- Security incident reporting
- Visit management
- Shift monitoring

### Medical Staff
- Medical records management
- Health assessments
- Treatment tracking
- Medical history access

### Rehabilitation Staff
- Program management
- Progress tracking
- Enrollment management
- Completion certificates

### Maintenance Staff
- Facility maintenance requests
- Equipment tracking
- Repair scheduling
- Maintenance history

## 📊 Database Schema

### Core Tables
- `users` - User accounts with role-based access
- `departments` - Organizational structure
- `staff` - Employee records and assignments
- `inmates` - Prisoner information and status
- `security_incidents` - Incident reporting and tracking
- `medical_records` - Health and medical data
- `rehabilitation_programs` - Program definitions and tracking
- `visits` - Visitor management and scheduling
- `food_services` - Meal planning and dietary management
- `maintenance_requests` - Facility maintenance tracking

## 🔐 Security Features

- Role-based middleware protection
- Form validation and sanitization
- CSRF protection
- SQL injection prevention
- XSS protection
- Secure authentication system

## 🎨 UI/UX Features

- Responsive Bootstrap 5 design
- Modern card-based layouts
- Interactive modals for CRUD operations
- Real-time status indicators
- Search and filter functionality
- Pagination for large datasets
- Toast notifications for user feedback

## 📁 Project Structure

```
prison-management-system/
├── app/
│   ├── Console/Commands/     # Artisan commands
│   ├── Http/
│   │   ├── Controllers/      # All application controllers
│   │   └── Middleware/       # Role-based middleware
│   └── Models/               # Eloquent models
├── database/
│   ├── migrations/           # Database schema
│   └── seeders/             # Test data seeders
├── resources/
│   └── views/               # Blade templates
│       ├── admin/           # Admin-specific views
│       ├── auth/            # Authentication views
│       ├── inmates/         # Inmate management views
│       ├── staff/           # Staff management views
│       └── ...              # Other module views
└── routes/
    └── web.php              # Application routes
```

## 🧪 Testing

The application includes comprehensive test data through seeders:
- Department data
- User accounts with different roles
- Staff records
- Inmate records
- Medical records
- Security incidents
- Rehabilitation programs
- Visit records

## 🔧 Configuration

### Environment Variables
- `DB_CONNECTION` - Database connection type
- `DB_DATABASE` - Database name
- `APP_KEY` - Application encryption key
- `APP_ENV` - Environment (local, production)

### Database Configuration
The system supports multiple database types:
- SQLite (development)
- MySQL (production)
- PostgreSQL (production)

## 📈 Performance

- Optimized database queries
- Eager loading for relationships
- Pagination for large datasets
- Caching for frequently accessed data
- Asset compilation for production

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🆘 Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Review the code comments

## 🔄 Updates

To update your local repository:
```bash
git pull origin master
composer install
php artisan migrate
```

---

**Built with ❤️ using Laravel and Bootstrap**
