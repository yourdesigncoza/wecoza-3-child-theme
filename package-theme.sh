#!/bin/bash

# WeCoza 3 Child Theme Packaging Script
# This script packages only the necessary files for a WordPress child theme upload

# Set variables
THEME_NAME="wecoza-3-child-theme"
TIMESTAMP=$(date +"%Y%m%d%H%M%S")
PACKAGE_DIR="$THEME_NAME-package-$TIMESTAMP"
ZIP_NAME="$THEME_NAME-$TIMESTAMP.zip"

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

# Create directory structure
mkdir -p "$PACKAGE_DIR/app/Controllers"
mkdir -p "$PACKAGE_DIR/app/Models/Assessment"
mkdir -p "$PACKAGE_DIR/app/Models/Learner"
mkdir -p "$PACKAGE_DIR/app/Helpers"
mkdir -p "$PACKAGE_DIR/app/Services/Database"
mkdir -p "$PACKAGE_DIR/app/Services/Validation"
mkdir -p "$PACKAGE_DIR/app/Views/components/class-capture-partials"
mkdir -p "$PACKAGE_DIR/app/Views/learner"

mkdir -p "$PACKAGE_DIR/assets/agents/js"
mkdir -p "$PACKAGE_DIR/assets/classes"
mkdir -p "$PACKAGE_DIR/assets/clients"
mkdir -p "$PACKAGE_DIR/assets/learners/components"
mkdir -p "$PACKAGE_DIR/assets/learners/js"

mkdir -p "$PACKAGE_DIR/includes/admin"
mkdir -p "$PACKAGE_DIR/includes/css"
mkdir -p "$PACKAGE_DIR/includes/functions"
mkdir -p "$PACKAGE_DIR/includes/js"
mkdir -p "$PACKAGE_DIR/includes/shortcodes"

mkdir -p "$PACKAGE_DIR/public/js/components"
mkdir -p "$PACKAGE_DIR/public/js/validation"
mkdir -p "$PACKAGE_DIR/public/css"
mkdir -p "$PACKAGE_DIR/public/assets"
mkdir -p "$PACKAGE_DIR/templates"
mkdir -p "$PACKAGE_DIR/config"

# Copy MVC structure
echo "Copying MVC structure..."
cp app/bootstrap.php "$PACKAGE_DIR/app/"
cp app/Controllers/*.php "$PACKAGE_DIR/app/Controllers/"
cp app/Models/Assessment/*.php "$PACKAGE_DIR/app/Models/Assessment/"
cp app/Models/Learner/*.php "$PACKAGE_DIR/app/Models/Learner/"
cp app/Helpers/*.php "$PACKAGE_DIR/app/Helpers/"
cp app/Services/Database/*.php "$PACKAGE_DIR/app/Services/Database/"
cp app/Services/Validation/*.php "$PACKAGE_DIR/app/Services/Validation/"
cp app/Views/components/*.php "$PACKAGE_DIR/app/Views/components/"
cp app/Views/components/class-capture-partials/*.php "$PACKAGE_DIR/app/Views/components/class-capture-partials/"
cp app/Views/learner/*.php "$PACKAGE_DIR/app/Views/learner/"

# Copy assets
echo "Copying assets..."
cp assets/agents/*.php "$PACKAGE_DIR/assets/agents/"
cp assets/agents/js/*.js "$PACKAGE_DIR/assets/agents/js/"
cp assets/classes/*.php "$PACKAGE_DIR/assets/classes/"
cp assets/clients/*.php "$PACKAGE_DIR/assets/clients/"
cp assets/learners/*.php "$PACKAGE_DIR/assets/learners/"
cp assets/learners/components/*.php "$PACKAGE_DIR/assets/learners/components/"
cp assets/learners/js/*.js "$PACKAGE_DIR/assets/learners/js/"

# Copy includes
echo "Copying includes..."
cp includes/admin/*.php "$PACKAGE_DIR/includes/admin/"
cp includes/css/*.css "$PACKAGE_DIR/includes/css/"
cp includes/functions/*.php "$PACKAGE_DIR/includes/functions/"
cp includes/js/*.js "$PACKAGE_DIR/includes/js/"
cp includes/shortcodes/*.php "$PACKAGE_DIR/includes/shortcodes/"
cp includes/*.php "$PACKAGE_DIR/includes/"

# Copy public assets
echo "Copying public assets..."
cp public/js/*.js "$PACKAGE_DIR/public/js/"

# Copy subdirectory files if they exist
if [ "$(ls -A public/js/components 2>/dev/null)" ]; then
    cp public/js/components/*.js "$PACKAGE_DIR/public/js/components/"
fi

if [ "$(ls -A public/js/validation 2>/dev/null)" ]; then
    cp public/js/validation/*.js "$PACKAGE_DIR/public/js/validation/"
fi

if [ "$(ls -A public/css 2>/dev/null)" ]; then
    cp public/css/*.css "$PACKAGE_DIR/public/css/"
fi

if [ "$(ls -A public/assets 2>/dev/null)" ]; then
    cp -r public/assets/* "$PACKAGE_DIR/public/assets/"
fi

# Copy templates
echo "Copying templates..."
cp templates/*.php "$PACKAGE_DIR/templates/"

# Copy config
echo "Copying config..."
cp config/*.php "$PACKAGE_DIR/config/"

# Remove any .git or development files that might have been copied
echo "Cleaning up development files..."
find "$PACKAGE_DIR" -name "*.md" -type f -delete
find "$PACKAGE_DIR" -name "*.git*" -type f -delete
find "$PACKAGE_DIR" -name "*.DS_Store" -type f -delete

# Create zip archive
echo "Creating zip archive: $ZIP_NAME"
zip -r "$ZIP_NAME" "$PACKAGE_DIR"

# Clean up
echo "Cleaning up temporary directory..."
rm -rf "$PACKAGE_DIR"

echo "Package created successfully: $ZIP_NAME"
echo "Your theme is ready for upload!"
