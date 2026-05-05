# Laravel Complaint Management System with MongoDB

A comprehensive complaint management system built with Laravel 12 and MongoDB.

## Features

- **Role-based Authentication** (Citizen, Admin, Department)
- **Complaint Submission** with categories and priority levels
- **Real-time Status Tracking** with history logs
- **Department Assignment** and management
- **Admin Dashboard** with analytics
- **Department Dashboard** for assigned complaints
- **Feedback System** for resolved complaints

## Database: MongoDB

This project uses MongoDB as the database with the `mongodb/laravel-mongodb` package.

### Prerequisites

1. **MongoDB** installed and running on your system
2. **PHP MongoDB Extension** installed
3. **Composer** for dependency management

### Installation

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd laravel-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update .env for MongoDB**
   ```
   DB_CONNECTION=mongodb
   DB_HOST=127.0.0.1
   DB_PORT=27017
   DB_DATABASE=complaint_system
   DB_USERNAME=
   DB_PASSWORD=
   ```

5. **Start MongoDB** (if not running)
   ```bash
   # On Windows with MongoDB installed
   mongod
   
   # Or using Docker
   docker run -d -p 27017:27017 --name mongodb mongo:latest
   ```

6. **Start the application**
   ```bash
   php artisan serve
   ```

### MongoDB Collections

The system uses these MongoDB collections:
- `users` - User accounts with roles
- `complaints` - Main complaint records
- `departments` - Department information
- `complaint_status_logs` - Audit trail of status changes
- `feedback` - User feedback on resolved complaints

### Creating Test Data

```bash
php artisan tinker
```

```php
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

// Create test users
User::create([
    'name' => 'John Citizen',
    'email' => 'citizen@test.com',
    'password' => Hash::make('password'),
    'role' => 'citizen'
]);

User::create([
    'name' => 'Admin User',
    'email' => 'admin@test.com',
    'password' => Hash::make('password'),
    'role' => 'admin'
]);

User::create([
    'name' => 'Water Department',
    'email' => 'water@test.com',
    'password' => Hash::make('password'),
    'role' => 'department'
]);

// Create department
Department::create([
    'name' => 'Water Supply',
    'email' => 'water@test.com',
    'description' => 'Handles water supply complaints'
]);
```

### User Roles

- **Citizen**: Submit and track complaints
- **Admin**: Manage all complaints, assign to departments
- **Department**: Handle assigned complaints, update status

### Next Steps

1. Create Blade views in `resources/views/`
2. Add frontend styling (Tailwind CSS or Bootstrap)
3. Implement email notifications
4. Add form validation
5. Write tests

### MongoDB Advantages

- **Flexible Schema**: Easy to add new fields without migrations
- **JSON Documents**: Natural fit for web applications
- **Scalability**: Horizontal scaling capabilities
- **Performance**: Fast read/write operations
- **Embedded Documents**: Can store related data together

### Project Structure

```
app/
├── Models/              # MongoDB Eloquent models
├── Http/Controllers/    # Request handlers
├── Services/           # Business logic
├── Policies/           # Authorization rules
└── Http/Middleware/    # Role-based access control
```

### License

MIT License