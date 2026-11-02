#!/usr/bin/env bash
# Builds build/iforum-<version>.zip with the module in an "iforum" folder.
# Usage: bin/build-release.sh [version]
# Without a version, it is read from src/icms_version.php.

set -euo pipefail

MODULE_NAME="iforum"
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SOURCE_DIR="$ROOT_DIR/src"
BUILD_DIR="$ROOT_DIR/build"

VERSION="${1:-}"

if [ -z "$VERSION" ]; then
    VERSION="$(sed -n "s/.*\$modversion\['version'\] *= *[\"']\([^\"']*\)[\"'].*/\1/p" "$SOURCE_DIR/icms_version.php" | head -n 1)"
    VERSION="$(echo "$VERSION" | tr 'A-Z ' 'a-z-')"
fi

VERSION="${VERSION#v}"

if [ -z "$VERSION" ]; then
    echo "Could not determine the version" >&2
    exit 1
fi

PACKAGE_DIR="$BUILD_DIR/$MODULE_NAME"
ZIP_FILE="$BUILD_DIR/$MODULE_NAME-$VERSION.zip"

rm -rf "$PACKAGE_DIR" "$ZIP_FILE"
mkdir -p "$PACKAGE_DIR"
cp -R "$SOURCE_DIR/." "$PACKAGE_DIR/"
echo "$VERSION" > "$PACKAGE_DIR/VERSION"

cd "$BUILD_DIR"

if command -v zip > /dev/null 2>&1; then
    zip -qr "$ZIP_FILE" "$MODULE_NAME"
elif python3 -c "" > /dev/null 2>&1; then
    python3 -m zipfile -c "$ZIP_FILE" "$MODULE_NAME"
elif python -c "" > /dev/null 2>&1; then
    python -m zipfile -c "$ZIP_FILE" "$MODULE_NAME"
else
    echo "zip or python is required to create the package" >&2
    exit 1
fi

echo "Created $ZIP_FILE"
