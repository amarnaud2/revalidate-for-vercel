#!/bin/bash

PLUGIN_SLUG="revalidate-for-vercel"
ZIP_NAME="$PLUGIN_SLUG.1.5.zip"

# Directories
BUILD_DIR="build"
SOURCE_DIR="."

# Clean previous build
rm -rf "$BUILD_DIR" "$ZIP_NAME"
mkdir -p "$BUILD_DIR/$PLUGIN_SLUG"

# Copy plugin source except ignored files
rsync -av --progress $SOURCE_DIR/ $BUILD_DIR/$PLUGIN_SLUG \
  --exclude ".git" \
  --exclude "node_modules" \
  --exclude ".gitignore" \
  --exclude "README.md" \
  --exclude "$BUILD_DIR" \
  --exclude "*.zip" \
  --exclude "readme-wp.txt"

# Copy and rename WordPress-specific readme
cp "$SOURCE_DIR/readme-wp.txt" "$BUILD_DIR/$PLUGIN_SLUG/readme.txt"

# Create the zip file
cd "$BUILD_DIR"
zip -r "../$ZIP_NAME" "$PLUGIN_SLUG"
cd ..

# Cleanup
rm -rf "$BUILD_DIR"

# Done
echo "✅ Plugin packaged as $ZIP_NAME"
