#!/bin/bash

echo "========================================="
echo "  Google OAuth Setup Verification"
echo "========================================="
echo ""

# Check if .env exists
if [ -f .env ]; then
    echo "✅ .env file exists"
    
    # Check if credentials are set
    if grep -q "GOOGLE_CLIENT_ID=" .env; then
        echo "✅ GOOGLE_CLIENT_ID is configured"
    else
        echo "❌ GOOGLE_CLIENT_ID not found in .env"
    fi
    
    if grep -q "GOOGLE_CLIENT_SECRET=" .env; then
        echo "✅ GOOGLE_CLIENT_SECRET is configured"
    else
        echo "❌ GOOGLE_CLIENT_SECRET not found in .env"
    fi
    
    if grep -q "GOOGLE_REDIRECT_URI=" .env; then
        echo "✅ GOOGLE_REDIRECT_URI is configured"
    else
        echo "❌ GOOGLE_REDIRECT_URI not found in .env"
    fi
else
    echo "❌ .env file not found"
fi

echo ""
echo "Files & Directories Check:"
echo "========================================="

# Check controller
if [ -f "app/Http/Controllers/Auth/GoogleController.php" ]; then
    echo "✅ GoogleController.php exists"
else
    echo "❌ GoogleController.php not found"
fi

# Check routes
if grep -q "google.redirect" routes/auth.php; then
    echo "✅ Google routes are configured"
else
    echo "❌ Google routes not found"
fi

# Check User model
if grep -q "google_id" app/Models/User.php; then
    echo "✅ User model has google_id field"
else
    echo "❌ User model missing google_id field"
fi

# Check migration
if [ -f "database/migrations/2025_12_09_000000_add_oauth_fields_to_users_table.php" ]; then
    echo "✅ OAuth migration file exists"
else
    echo "❌ OAuth migration file not found"
fi

# Check services config
if grep -q "google" config/services.php; then
    echo "✅ Google configuration in services.php"
else
    echo "❌ Google configuration not found in services.php"
fi

# Check login view
if grep -q "google.redirect" resources/views/auth/login.blade.php; then
    echo "✅ Google login button configured in login view"
else
    echo "❌ Google login button not found in login view"
fi

echo ""
echo "========================================="
echo "  Database Check"
echo "========================================="

# Check if migration ran
if php artisan migrate:status 2>/dev/null | grep -q "2025_12_09_000000"; then
    echo "✅ OAuth migration has been executed"
else
    echo "⚠️  OAuth migration may not have been executed"
    echo "    Run: php artisan migrate"
fi

echo ""
echo "========================================="
echo "  Next Steps"
echo "========================================="
echo ""
echo "1. Add Google credentials to .env:"
echo "   GOOGLE_CLIENT_ID=your_client_id"
echo "   GOOGLE_CLIENT_SECRET=your_client_secret"
echo ""
echo "2. Clear configuration cache:"
echo "   php artisan config:cache"
echo ""
echo "3. Start the development server:"
echo "   php artisan serve"
echo ""
echo "4. Visit login page:"
echo "   http://localhost:8000/login"
echo ""
echo "For detailed setup instructions, see SETUP_GOOGLE_OAUTH.md"
echo ""
