# Laravel Excel User API

A Laravel 12 REST API for user management with Excel import/export functionality. Register users, manage user data, and seamlessly import/export user information via Excel files (.xlsx/.xls).

## ✨ Features

- **User Registration** - Register new users with validation
- **User Management** - Retrieve all users with JSON API
- **Excel Export** - Export user data to Excel format (.xlsx)
- **Excel Import** - Bulk import users from Excel files
- **RESTful API** - Clean and consistent API endpoints
- **Data Validation** - Server-side validation for all inputs
- **Error Handling** - Comprehensive error responses

## 🛠️ Tech Stack

- **Laravel 12** - PHP framework
- **Laravel Excel** (Maatwebsite) - Excel import/export package
- **SQLite** - Database (easily configurable)
- **PHP 8.2+** - Programming language

## 📋 Requirements

- PHP ^8.2
- Composer
- Laravel 12
- PHP Extensions: zip, xml, gd, iconv, simplexml, xmlreader, zlib

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/laravel-excel-user-api.git
   cd laravel-excel-user-api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   ```

5. **Install Laravel Excel**
   ```bash
   composer require maatwebsite/excel
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## 📡 API Endpoints

### User Registration
```http
POST /api/register
Content-Type: application/json

{
    "full_name": "John Doe",
    "password": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "User registered successfully",
    "user": {
        "id": 1,
        "full_name": "John Doe",
        "created_at": "2025-07-21T23:16:24.000000Z",
        "updated_at": "2025-07-21T23:16:24.000000Z"
    }
}
```

### Get All Users
```http
GET /api/users
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "full_name": "John Doe",
            "created_at": "2025-07-21T23:16:24.000000Z",
            "updated_at": "2025-07-21T23:16:24.000000Z"
        }
    ],
    "count": 1
}
```

### Export Users to Excel
```http
GET /api/users/export
```

Downloads an Excel file (`users.xlsx`) containing all user data.

### Import Users from Excel
```http
POST /api/users/import
Content-Type: multipart/form-data

file: [Excel file (.xlsx or .xls)]
```

**Response:**
```json
{
    "message": "Users imported successfully"
}
```

## 📊 Excel File Format

### For Import
Your Excel file should have these columns:
| full_name | password |
|-----------|----------|
| John Doe  | password123 |
| Jane Smith| password456 |

### Export Format
Exported files contain:
| ID | Full Name | Created At |
|----|-----------|------------|
| 1  | John Doe  | 2025-07-21 23:16:24 |

## 🧪 Testing

### Using cURL

**Register a user:**
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"full_name":"Test User","password":"password123"}'
```

**Get all users:**
```bash
curl -X GET http://localhost:8000/api/users
```

**Export users:**
```bash
curl -X GET http://localhost:8000/api/users/export --output users.xlsx
```

### Using Postman

1. **Import Collection**: Import the API endpoints into Postman
2. **File Upload**: For import endpoint, use form-data with file type
3. **File Download**: Use "Save Response" for export endpoint

## 🔧 Configuration

### Database
The project uses SQLite by default. To use MySQL or PostgreSQL:

1. Update `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

2. Run migrations:
   ```bash
   php artisan migrate
   ```

### Excel Configuration
Publish Excel config (optional):
```bash
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
```

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   └── UserController.php      # Main API controller
├── Models/
│   └── User.php               # User model
├── Exports/
│   └── UsersExport.php        # Excel export logic
└── Imports/
    └── UsersImport.php        # Excel import logic

routes/
└── api.php                    # API routes

database/
└── migrations/
    └── create_users_table.php # Database schema
```

## 🛡️ Validation Rules

### User Registration
- `full_name`: Required, string, max 255 characters
