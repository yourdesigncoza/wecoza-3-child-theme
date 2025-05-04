#!/bin/bash

# WeCoza 3 Child Theme Packaging Script
# This script packages only the necessary files for a WordPress child theme upload

# Set variables
THEME_NAME="wecoza-3-child-theme"
TIMESTAMP=$(date +"%Y%m%d%H%M%S")
PACKAGE_DIR="$THEME_NAME-package-$TIMESTAMP"
ZIP_NAME="$THEME_NAME-$TIMESTAMP.zip"

# Check for required files
echo "Checking for required WordPress theme files..."
REQUIRED_FILES=("style.css" "functions.php" "screenshot.png")
MISSING_FILES=()

for file in "${REQUIRED_FILES[@]}"; do
    if [ ! -f "$file" ]; then
        MISSING_FILES+=("$file")
    fi
done

if [ ${#MISSING_FILES[@]} -gt 0 ]; then
    echo "Error: The following required files are missing:"
    for file in "${MISSING_FILES[@]}"; do
        echo "  - $file"
    done
    echo "Please ensure all required WordPress theme files are present before packaging."
    exit 1
fi

# Create temporary directory
echo "Creating temporary directory: $PACKAGE_DIR"
mkdir -p "$PACKAGE_DIR"

# Copy essential files
echo "Copying essential theme files..."

# Core WordPress theme files
cp style.css "$PACKAGE_DIR/"
cp functions.php "$PACKAGE_DIR/"
cp screenshot.png "$PACKAGE_DIR/"
cp wecoza-3-child-theme.php "$PACKAGE_DIR/"
cp index.php "$PACKAGE_DIR/"
cp version.php "$PACKAGE_DIR/"

# Copy any additional root PHP files that might be needed
if [ -f "ajax-handlers.php" ]; then
    cp ajax-handlers.php "$PACKAGE_DIR/"
fi

# Create directory structure
mkdir -p "$PACKAGE_DIR/app/Controllers"
mkdir -p "$PACKAGE_DIR/app/Models/Assessment"
mkdir -p "$PACKAGE_DIR/app/Models/Learner"
mkdir -p "$PACKAGE_DIR/app/Models/Agent"
mkdir -p "$PACKAGE_DIR/app/Models/Client"
mkdir -p "$PACKAGE_DIR/app/Models/Portfolio"
mkdir -p "$PACKAGE_DIR/app/Helpers"
mkdir -p "$PACKAGE_DIR/app/Services/Database"
mkdir -p "$PACKAGE_DIR/app/Services/Validation"
mkdir -p "$PACKAGE_DIR/app/Services/Export"
mkdir -p "$PACKAGE_DIR/app/Services/Authentication"
mkdir -p "$PACKAGE_DIR/app/Services/FileUpload"
mkdir -p "$PACKAGE_DIR/app/Views/components/class-capture-partials"
mkdir -p "$PACKAGE_DIR/app/Views/learner"
mkdir -p "$PACKAGE_DIR/app/Views/agent"
mkdir -p "$PACKAGE_DIR/app/Views/client"
mkdir -p "$PACKAGE_DIR/app/Views/admin"
mkdir -p "$PACKAGE_DIR/app/Views/layouts"

mkdir -p "$PACKAGE_DIR/assets/agents/js"
mkdir -p "$PACKAGE_DIR/assets/classes"
mkdir -p "$PACKAGE_DIR/assets/clients"
mkdir -p "$PACKAGE_DIR/assets/learners/components"
mkdir -p "$PACKAGE_DIR/assets/learners/js"
mkdir -p "$PACKAGE_DIR/assets/js"

mkdir -p "$PACKAGE_DIR/includes/admin"
mkdir -p "$PACKAGE_DIR/includes/css"
mkdir -p "$PACKAGE_DIR/includes/functions"
mkdir -p "$PACKAGE_DIR/includes/js"
mkdir -p "$PACKAGE_DIR/includes/shortcodes"
mkdir -p "$PACKAGE_DIR/includes/db/migrations"
mkdir -p "$PACKAGE_DIR/includes/db-migrations"

mkdir -p "$PACKAGE_DIR/public/js/components"
mkdir -p "$PACKAGE_DIR/public/js/validation"
mkdir -p "$PACKAGE_DIR/public/css"
mkdir -p "$PACKAGE_DIR/public/assets"
mkdir -p "$PACKAGE_DIR/templates"
mkdir -p "$PACKAGE_DIR/config"

# Copy MVC structure
echo "Copying MVC structure..."
cp app/bootstrap.php "$PACKAGE_DIR/app/"
cp app/ajax-handlers.php "$PACKAGE_DIR/app/"
cp app/Controllers/*.php "$PACKAGE_DIR/app/Controllers/"

# Copy Models
cp app/Models/Assessment/*.php "$PACKAGE_DIR/app/Models/Assessment/" 2>/dev/null || true
cp app/Models/Learner/*.php "$PACKAGE_DIR/app/Models/Learner/" 2>/dev/null || true

# Copy additional Models if they exist
if [ -d "app/Models/Agent" ] && [ "$(ls -A app/Models/Agent 2>/dev/null)" ]; then
    cp app/Models/Agent/*.php "$PACKAGE_DIR/app/Models/Agent/" 2>/dev/null || true
fi

if [ -d "app/Models/Client" ] && [ "$(ls -A app/Models/Client 2>/dev/null)" ]; then
    cp app/Models/Client/*.php "$PACKAGE_DIR/app/Models/Client/" 2>/dev/null || true
fi

if [ -d "app/Models/Portfolio" ] && [ "$(ls -A app/Models/Portfolio 2>/dev/null)" ]; then
    cp app/Models/Portfolio/*.php "$PACKAGE_DIR/app/Models/Portfolio/" 2>/dev/null || true
fi

# Copy Helpers and Services
cp app/Helpers/*.php "$PACKAGE_DIR/app/Helpers/" 2>/dev/null || true
cp app/Services/Database/*.php "$PACKAGE_DIR/app/Services/Database/" 2>/dev/null || true
cp app/Services/Validation/*.php "$PACKAGE_DIR/app/Services/Validation/" 2>/dev/null || true
cp app/Services/Export/*.php "$PACKAGE_DIR/app/Services/Export/" 2>/dev/null || true

# Copy additional Services if they exist
if [ -d "app/Services/Authentication" ] && [ "$(ls -A app/Services/Authentication 2>/dev/null)" ]; then
    cp app/Services/Authentication/*.php "$PACKAGE_DIR/app/Services/Authentication/" 2>/dev/null || true
fi

if [ -d "app/Services/FileUpload" ] && [ "$(ls -A app/Services/FileUpload 2>/dev/null)" ]; then
    cp app/Services/FileUpload/*.php "$PACKAGE_DIR/app/Services/FileUpload/" 2>/dev/null || true
fi

# Copy Views
cp app/Views/components/*.php "$PACKAGE_DIR/app/Views/components/" 2>/dev/null || true
cp app/Views/components/class-capture-partials/*.php "$PACKAGE_DIR/app/Views/components/class-capture-partials/" 2>/dev/null || true
cp app/Views/learner/*.php "$PACKAGE_DIR/app/Views/learner/" 2>/dev/null || true

# Copy additional Views if they exist
if [ -d "app/Views/agent" ] && [ "$(ls -A app/Views/agent 2>/dev/null)" ]; then
    cp app/Views/agent/*.php "$PACKAGE_DIR/app/Views/agent/" 2>/dev/null || true
fi

if [ -d "app/Views/client" ] && [ "$(ls -A app/Views/client 2>/dev/null)" ]; then
    cp app/Views/client/*.php "$PACKAGE_DIR/app/Views/client/" 2>/dev/null || true
fi

if [ -d "app/Views/admin" ] && [ "$(ls -A app/Views/admin 2>/dev/null)" ]; then
    cp app/Views/admin/*.php "$PACKAGE_DIR/app/Views/admin/" 2>/dev/null || true
fi

if [ -d "app/Views/layouts" ] && [ "$(ls -A app/Views/layouts 2>/dev/null)" ]; then
    cp app/Views/layouts/*.php "$PACKAGE_DIR/app/Views/layouts/" 2>/dev/null || true
fi

# Copy assets
echo "Copying assets..."
cp assets/agents/*.php "$PACKAGE_DIR/assets/agents/" 2>/dev/null || true
cp assets/agents/js/*.js "$PACKAGE_DIR/assets/agents/js/" 2>/dev/null || true
cp assets/classes/*.php "$PACKAGE_DIR/assets/classes/" 2>/dev/null || true
cp assets/clients/*.php "$PACKAGE_DIR/assets/clients/" 2>/dev/null || true
cp assets/learners/*.php "$PACKAGE_DIR/assets/learners/" 2>/dev/null || true
cp assets/learners/components/*.php "$PACKAGE_DIR/assets/learners/components/" 2>/dev/null || true
cp assets/learners/js/*.js "$PACKAGE_DIR/assets/learners/js/" 2>/dev/null || true

# Copy assets/js files if they exist
if [ -d "assets/js" ] && [ "$(ls -A assets/js 2>/dev/null)" ]; then
    cp assets/js/*.js "$PACKAGE_DIR/assets/js/" 2>/dev/null || true
fi

# Copy includes
echo "Copying includes..."
cp includes/admin/*.php "$PACKAGE_DIR/includes/admin/" 2>/dev/null || true
cp includes/css/*.css "$PACKAGE_DIR/includes/css/" 2>/dev/null || true
cp includes/functions/*.php "$PACKAGE_DIR/includes/functions/" 2>/dev/null || true
cp includes/js/*.js "$PACKAGE_DIR/includes/js/" 2>/dev/null || true
cp includes/shortcodes/*.php "$PACKAGE_DIR/includes/shortcodes/" 2>/dev/null || true
cp includes/*.php "$PACKAGE_DIR/includes/" 2>/dev/null || true

# Copy database migrations if they exist
if [ -d "includes/db/migrations" ] && [ "$(ls -A includes/db/migrations 2>/dev/null)" ]; then
    cp includes/db/migrations/*.php "$PACKAGE_DIR/includes/db/migrations/" 2>/dev/null || true
fi

# Copy alternative db-migrations if they exist
if [ -d "includes/db-migrations" ] && [ "$(ls -A includes/db-migrations 2>/dev/null)" ]; then
    cp includes/db-migrations/*.php "$PACKAGE_DIR/includes/db-migrations/" 2>/dev/null || true
fi

# Copy public assets
echo "Copying public assets..."
cp public/js/*.js "$PACKAGE_DIR/public/js/" 2>/dev/null || true

# Copy subdirectory files if they exist
if [ -d "public/js/components" ] && [ "$(ls -A public/js/components 2>/dev/null)" ]; then
    cp public/js/components/*.js "$PACKAGE_DIR/public/js/components/" 2>/dev/null || true
fi

if [ -d "public/js/validation" ] && [ "$(ls -A public/js/validation 2>/dev/null)" ]; then
    cp public/js/validation/*.js "$PACKAGE_DIR/public/js/validation/" 2>/dev/null || true
fi

if [ -d "public/css" ] && [ "$(ls -A public/css 2>/dev/null)" ]; then
    cp public/css/*.css "$PACKAGE_DIR/public/css/" 2>/dev/null || true
fi

if [ -d "public/assets" ] && [ "$(ls -A public/assets 2>/dev/null)" ]; then
    cp -r public/assets/* "$PACKAGE_DIR/public/assets/" 2>/dev/null || true
fi

# Copy templates
echo "Copying templates..."
cp templates/*.php "$PACKAGE_DIR/templates/" 2>/dev/null || true

# Copy config
echo "Copying config..."
cp config/*.php "$PACKAGE_DIR/config/" 2>/dev/null || true

# Remove any .git or development files that might have been copied
echo "Cleaning up development files..."
find "$PACKAGE_DIR" -name "*.md" -type f -delete
find "$PACKAGE_DIR" -name "*.git*" -type f -delete
find "$PACKAGE_DIR" -name "*.DS_Store" -type f -delete
find "$PACKAGE_DIR" -name "*.log" -type f -delete
find "$PACKAGE_DIR" -name "*.bak" -type f -delete
find "$PACKAGE_DIR" -name "*.tmp" -type f -delete
find "$PACKAGE_DIR" -name "*.json" -type f -delete
find "$PACKAGE_DIR" -name "*.lock" -type f -delete
find "$PACKAGE_DIR" -name "*.sh" -type f -delete
find "$PACKAGE_DIR" -name "*.yml" -type f -delete
find "$PACKAGE_DIR" -name "*.yaml" -type f -delete

# Remove development directories
rm -rf "$PACKAGE_DIR/scripts" 2>/dev/null || true
rm -rf "$PACKAGE_DIR/project-planning" 2>/dev/null || true
rm -rf "$PACKAGE_DIR/project" 2>/dev/null || true
rm -rf "$PACKAGE_DIR/project-feedback" 2>/dev/null || true

# Create zip archive
echo "Creating zip archive: $ZIP_NAME"
zip -r "$ZIP_NAME" "$PACKAGE_DIR"

# Clean up
echo "Cleaning up temporary directory..."
rm -rf "$PACKAGE_DIR"

# Get the size of the zip file
ZIP_SIZE=$(du -h "$ZIP_NAME" | cut -f1)

echo "Package created successfully: $ZIP_NAME (Size: $ZIP_SIZE)"
echo "Package contains the following directories:"
unzip -l "$ZIP_NAME" | grep -o "$PACKAGE_DIR/[^/]*/$" | sort | uniq | sed "s|$PACKAGE_DIR/||g" | sed 's|/$||g'
echo ""
echo "Your theme is ready for upload!"
