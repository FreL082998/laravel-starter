# Laravel 12 Production-Ready Backend API

A fully modular, action-based Laravel 12 backend API with advanced authentication, RBAC, UUID primary keys, soft deletes, audit logging, real-time capabilities, and comprehensive search functionality.

## Quick Start

```bash
# Install dependencies
composer install

# Configure .env
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan passport:install
php artisan db:seed

# Run app
php artisan serve
# Or use Laravel Herd: https://laravel-starter.test

# Optional: Start Reverb for WebSockets
php artisan reverb:start

# Optional: Index models for search
php artisan scout:import "Modules\User\Models\User"
```

## Features

### Core Architecture
- ✅ Modular architecture with separate User, Role, and Auth modules
- ✅ Action-based business logic (thin controllers)
- ✅ Specialized service providers (Observer, Gate, Auth)
- ✅ UUID primary keys and soft deletes by default
- ✅ Comprehensive PHPDoc blocks on all classes and methods

### Authentication & Authorization
- ✅ Separate Auth module with specialized controllers
- ✅ JWT authentication with Laravel Passport
- ✅ Configurable token expiration (15 min access, 1 day refresh)
- ✅ Automatic token refresh middleware for seamless auth
- ✅ Refresh token endpoint for manual token renewal
- ✅ RBAC via spatie/laravel-permission
- ✅ Authorization policies for fine-grained access control

### Data & Logging
- ✅ Audit logging via spatie/laravel-activitylog
- ✅ Activity tracking for all model changes
- ✅ Event-driven architecture with observers
- ✅ Queued notifications for async processing
- ✅ Attribute masking in logs for sensitive data

### Search & Indexing
- ✅ Full-text search via Laravel Scout + Meilisearch
- ✅ Indexed User model for fast searching
- ✅ Configurable search fields and data types
- ✅ Support for typo tolerance and relevancy

### Real-Time Features
- ✅ WebSocket support via Laravel Reverb
- ✅ Event broadcasting ready
- ✅ Real-time channel subscriptions
- ✅ Production-ready scaling configuration

### Code Quality
- ✅ Strict typing (declare strict_types=1) on all files
- ✅ PSR-12 compliance with Laravel Pint
- ✅ Rate limiting and throttling
- ✅ Global exception handler for API
- ✅ Comprehensive PestPHP test suite

### Developer Experience
- ✅ Comprehensive documentation and setup guide
- ✅ Laravel Telescope for local debugging (dev only)

## API Endpoints

### Authentication
| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| POST | `/api/auth/register` | Register new user | No |
| POST | `/api/auth/login` | Login and get token | No |
| POST | `/api/auth/logout` | Logout all devices | Yes |
| POST | `/api/auth/refresh` | Refresh access token | Yes |
| GET | `/api/me` | Get authenticated user | Yes |

### Users (CRUD)
| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/users` | List all users (paginated) | Yes |
| POST | `/api/users` | Create new user | Yes |
| GET | `/api/users/{id}` | Get specific user | Yes |
| PUT | `/api/users/{id}` | Update user | Yes |
| DELETE | `/api/users/{id}` | Delete user | Yes |

### Roles (CRUD)
| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/roles` | List roles | Yes |
| POST | `/api/roles` | Create role with permissions | Yes |
| GET | `/api/roles/{id}` | Get role details | Yes |
| PUT | `/api/roles/{id}` | Update role | Yes |
| DELETE | `/api/roles/{id}` | Delete role | Yes |

## Authentication Flow

### Token Expiration & Refresh

The authentication system uses a refreshable token model:

1. **Access Token**: 15 minutes (short-lived)
2. **Refresh Token**: 1 day (long-lived)
3. **Personal Access Tokens**: 6 months (for daemon access)

```
┌─ User Login ─────────────────────────────────────────┐
│                                                      │
│  POST /api/auth/login                               │
│  Returns: access_token, refresh_token, expires_in   │
│                                                      │
└──────────────────────────────────────────────────────┘
                          │
                          v
┌─ Client stores tokens ─────────────────────────────────┐
│                                                        │
│  - Access token in memory (or secure storage)          │
│  - Refresh token in httpOnly cookie or secure storage  │
│                                                        │
└────────────────────────────────────────────────────────┘
                          │
                          v
┌─ Access Token Expires ─────────────────────────────────┐
│                                                        │
│  Middleware detects expired token                      │
│  Automatically refreshes using refresh token           │
│  New token in X-New-Access-Token header                │
│                                                        │
└────────────────────────────────────────────────────────┘
```

### Manual Token Refresh

```bash
curl -X POST http://localhost:8000/api/auth/refresh \
  -H "Authorization: Bearer {access_token}"
  
# Returns: { access_token, token_type, expires_in }
```

## Project Structure

```
app/
├── Modules/
│   ├── Auth/
│   │   ├── Actions/{Login,Register,Logout,RefreshToken}Action.php
│   │   ├── Http/Controllers/AuthController.php
│   │   ├── Http/Middleware/EnsureTokenNotExpired.php
│   │   └── Http/Requests/{Login,Register}Request.php
│   ├── User/
│   │   ├── Actions/{CreateUser,UpdateUser,DeleteUser,CreateRole,UpdateRole,DeleteRole}Action.php
│   │   ├── Events/{UserRegistered}Event.php
│   │   ├── Http/Controllers/{User,Role}Controller.php
│   │   └── Http/Requests/{CreateUser,UpdateUser,CreateRole,UpdateRole}Request.php
│   │   └── Http/Resources/{Role,User}Collection.php
│   │   └── Http/Resources/{Role,User}Resource.php
│   │   └── Models/{Role,User}.php
│   │   └── Notifications/WelcomeEmail.php
│   │   └── Observers/{User}Observer.php
│   │   └── Policies/{Role,User}Policy.php
├── Providers/
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php (Passport config)
│   └── GateServiceProvider.php
│   ├── ObserverServiceProvider.php
│   ├── RepositoryServiceProvider.php
│   ├── TelescopeServiceProvider.php
└── Shared/
    ├── Contracts/{RepositoryInterface,BaseRepository}.php
    └── Traits/HasUuid.php

config/
├── scout.php (Meilisearch configuration)
├── reverb.php (WebSocket configuration)
└── auth.php, broadcasting.php, ...

database/
├── factories/ (Model factories)
├── seeders/ (Database seeders)
└── migrations/ (Schema migrations)
```

## Search Integration (Meilisearch)

### Setup

```bash
# Install Meilisearch (Docker)
docker run -it --rm -p 7700:7700 getmeili/meilisearch:latest

# Configure .env
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=masterKey
```

### Index Models

```bash
# Index all users
php artisan scout:import "Modules\User\Models\User"

# Flush index
php artisan scout:flush "Modules\User\Models\User"

# Search
GET /api/users/search?q=admin
```

### Adding Search to New Modules

1. Add `Searchable` trait to model
2. Implement `toSearchableArray()` method
3. Run `php artisan scout:import`

```php
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
```

## Real-Time Features (Reverb)

### Setup WebSockets

```bash
# Start Reverb server
php artisan reverb:start --host=0.0.0.0 --port=8080

# Or with scaling (Redis required)
REVERB_SCALING_ENABLED=true php artisan reverb:start
```

### Configure Environment

```env
# .env
BROADCAST_DRIVER=reverb
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
REVERB_SCHEME=http
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
```

### Frontend Integration

```javascript
// resources/js/bootstrap.js
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Subscribe to channel
window.Echo.channel('posts')
    .listen('.post.created', (data) => {
        console.log('New post:', data);
    });
```

### Broadcasting Events

```php
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\ShouldBroadcast;

class PostCreated implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('posts');
    }

    public function broadcastAs(): string
    {
        return 'post.created';
    }
}
```

## Service Providers

The application has specialized service providers for better organization:

### AuthServiceProvider
Configures Passport token expiration times:
- Access tokens: 15 minutes
- Refresh tokens: 1 day
- Personal access tokens: 6 months

### RepositoryServiceProvider
Registers all repository bindings in the service container for dependency injection.

### ObserverServiceProvider
Registers model observers that handle lifecycle events and trigger business logic.

### GateServiceProvider
Registers authorization policies for resource protection.

### AppServiceProvider
General application configuration (HTTPS in production, etc.)

## Middleware

### EnsureTokenNotExpired

Automatically refreshes expired access tokens:
- Checks if token is expired
- Generates new token if refresh token is valid
- Returns new token in `X-New-Access-Token` header

```php
Route::middleware(['auth:api', 'ensure.token.not.expired'])->group(function () {
    // Protected routes
});
```

## Token Configuration

Update token expiration in `app/Providers/AuthServiceProvider.php`:

```php
use Carbon\CarbonInterval;

Passport::tokensExpireIn(CarbonInterval::minutes(15));
Passport::refreshTokensExpireIn(CarbonInterval::days(1));
Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));
```

## Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/UserApiTest.php

# With coverage
php artisan test --coverage

# Filter by name
php artisan test --filter=test_can_register

# Compact output
php artisan test --compact
```

## Code Quality

```bash
# Check PSR-12 compliance
vendor/bin/pint --test

# Fix code style
vendor/bin/pint

# Fix specific file
vendor/bin/pint app/Modules/User/Models/User.php
```

## Security

- ✅ JWT authentication with Passport
- ✅ Automatic token refresh for seamless auth
- ✅ Authorization policies for fine-grained access control
- ✅ HTTPS enforced in production
- ✅ Rate limiting on all API endpoints
- ✅ Request validation with custom error messages
- ✅ Audit trails for all model changes
- ✅ Soft deletes for data recovery
- ✅ Password hashing with bcrypt
- ✅ Masked attributes in logs (email, phone)
- ✅ CORS configuration for frontend domains

## Database Models

**User**
- UUID PK, soft deletes, has many roles/posts, Passport tokens, audit logging, activity logging

**Role**
- UUID PK, soft deletes, many-to-many with users, many-to-many with permissions, audit logging

## Configuration

Key environment variables:

```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
CACHE_DRIVER=redis
QUEUE_CONNECTION=database
MAIL_DRIVER=mailtrap

# Passport (JWT)
PASSPORT_PERSONAL_ACCESS_CLIENT_ENABLED=true

# Search (Meilisearch)
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=masterKey

# Broadcasting (Reverb)
BROADCAST_DRIVER=reverb
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
```

## Production Deployment

- [ ] Set APP_DEBUG=false, APP_ENV=production
- [ ] Run `composer install --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Enable HTTPS
- [ ] Configure CORS
- [ ] Set strong APP_KEY
- [ ] Configure mail/queue
- [ ] Setup Meilisearch server
- [ ] Configure Reverb horizontal scaling with Redis
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan passport:install`
- [ ] Index models: `php artisan scout:import "Modules\User\Models\User"`

## Tools & Packages

| Package | Purpose | Version |
|---------|---------|---------|
| laravel/framework | Core framework | v12 |
| laravel/passport | JWT authentication | v13 |
| laravel/scout | Full-text search | v10 |
| laravel/reverb | WebSocket server | v1 |
| spatie/laravel-permission | RBAC | v7 |
| spatie/laravel-activitylog | Audit logging | v4 |
| laravel/telescope | Dev debugging | v5 |
| meilisearch/meilisearch-php | Search engine | Latest |
| pestphp/pest | Testing framework | v4 |
| laravel/pint | Code formatting | v1 |

## Support

For issues or questions:
1. Check the documentation in README.md or SETUP_GUIDE.md
2. Review existing tests for implementation examples
3. Consult Laravel documentation for framework specifics
4. Check package documentation for third-party tools

---

**Last Updated:** February 23, 2026  
**Laravel Version:** v12.50.0  
**PHP Version:** 8.4.16

