#!/bin/bash

# This script packages the plugin for WordPress.org
# It creates a zip file containing the plugin code, excluding unnecessary files
# and directories, and renames the readme file for WordPress.
# Usage: ./build-release.sh
# PLUGIN_SLUG="revalidate-for-vercel"
# ZIP_NAME="$PLUGIN_SLUG.1.5.zip"
# Directories
# BUILD_DIR="build"
# SOURCE_DIR="."
# Clean previous build
# rm -rf "$BUILD_DIR" "$ZIP_NAME"
# mkdir -p "$BUILD_DIR/$PLUGIN_SLUG"
# Copy plugin source except ignored files
# rsync -av --progress $SOURCE_DIR/ $BUILD_DIR/$PLUGIN_SLUG \
#   --exclude ".git" \
#   --exclude "node_modules" \
#   --exclude ".gitignore" \
#   --exclude "README.md" \
#   --exclude "$BUILD_DIR" \
#   --exclude "*.zip" \
#   --exclude "readme-wp.txt"
# Copy and rename WordPress-specific readme
# cp "$SOURCE_DIR/readme-wp.txt" "$BUILD_DIR/$PLUGIN_SLUG/readme.txt"
# Create the zip file
# cd "$BUILD_DIR"
# zip -r "../$ZIP_NAME" "$PLUGIN_SLUG"
# cd ..
# Cleanup
# rm -rf "$BUILD_DIR"
# Done
# This script updates the version number in the readme.txt and README.md files
# It takes a version number as an argument and updates the Stable tag in readme.txt
# and the version badge in README.md
# Usage: ./update-version.sh <version>
# Example: ./update-version.sh 1.5
# Check if the version number is provided
# If not, print an error message and exit
# This script updates the version number in the readme.txt and README.md files
# It takes a version number as an argument and updates the Stable tag in readme.txt
# and the version badge in README.md
# Usage: ./update-version.sh <version>
# Example: ./update-version.sh 1.5
# Check if the version number is provided
# If not, print an error message and exit
# This script updates the version number in the readme.txt and README.md files
# It takes a version number as an argument and updates the Stable tag in readme.txt
# and the version badge in README.md
# Usage: ./update-version.sh <version>
# Example: ./update-version.sh 1.5
# Check if the version number is provided
# If not, print an error message and exit
# This script updates the version number in the readme.txt and README.md files
# It takes a version number as an argument and updates the Stable tag in readme.txt
# and the version badge in README.md
# Usage: ./update-version.sh <version>
# Example: ./update-version.sh 1.5
# Check if the version number is provided
# If not, print an error message and exit
# This script updates the version number in the readme.txt and README.md files
# It takes a version number as an argument and updates the Stable tag in readme.txt
# and the version badge in README.md
# Usage: ./update-version.sh <version>
# Example: ./update-version.sh 1.5
# Check if the version number is provided
# If not, print an error message and exit
# This script updates the version number in the readme.txt and README.md files
# It takes a version number as an argument and updates the Stable tag in readme.txt
# and the version badge in README.md
# Usage: ./update-version.sh <version>
# Example: ./update-version.sh 1.5
# Check if the version number is provided
# If not, print an error message and exit
# This script updates the version number in the readme.txt and README.md files
# It takes a version number as an argument and updates the Stable tag in readme.txt
# and the version badge in README.md
# Usage: ./update-version.sh <version>
# Example: ./update-version.sh 1.5
# Check if the version number is provided
# If not, print an error message and exit
# This script updates the version number in the readme.txt and README.md files
# It takes a version number as an argument and updates the Stable tag in readme.txt
# and the version badge in README.md
# Usage: ./update-version.sh <version>
# Example: ./update-version.sh 1.5
# Check if the version number is provided
# If not, print an error message and exit
# This script updates the version number in the readme.txt and README.md files  

VERSION=$1

if [[ -z "$VERSION" ]]; then
  echo "❌ Error: Please provide the version number. Example: ./update-version.sh 1.5"
  exit 1
fi

# ✅ Update Stable tag in readme.txt
echo "🔄 Updating Stable tag in readme.txt..."
sed -i.bak "s/^Stable tag: .*/Stable tag: $VERSION/" readme.txt && rm readme.txt.bak

# ✅ Update version badge in README.md (if it exists)
echo "🔄 Updating version badge in README.md..."
sed -i.bak "s/version-[0-9.]*-blue/version-${VERSION}-blue/" README.md && rm README.md.bak

echo "✅ Version updated to $VERSION in readme.txt and README.md"
