# Thar Cho POS - Windows Setup Script
# Run in PowerShell as Administrator for full install (PostgreSQL service)

$ErrorActionPreference = "Stop"
$AppDir = Split-Path (Split-Path $PSScriptRoot -Parent) -Parent

Write-Host "========================================" -ForegroundColor Green
Write-Host "  Thar Cho POS - Windows Setup" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green

Set-Location $AppDir

# 1. Check PHP
if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Host "[!] PHP not found. Install PHP 8.2+ from https://windows.php.net/download/" -ForegroundColor Yellow
    Write-Host "    Add php.exe to your PATH and enable extensions: pdo_pgsql, pgsql, mbstring, openssl, fileinfo" -ForegroundColor Yellow
} else {
    Write-Host "[OK] PHP $(php -r 'echo PHP_VERSION;')" -ForegroundColor Green
}

# 2. Check Composer
if (-not (Get-Command composer -ErrorAction SilentlyContinue)) {
    Write-Host "[!] Composer not found. Install from https://getcomposer.org/" -ForegroundColor Yellow
} else {
    Write-Host "[OK] Composer found" -ForegroundColor Green
    composer install --no-dev --optimize-autoloader
}

# 3. Environment
if (-not (Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    php artisan key:generate
    Write-Host "[OK] Created .env file" -ForegroundColor Green
}

# Desktop mode defaults
$envContent = Get-Content ".env" -Raw
if ($envContent -notmatch "DESKTOP_MODE=") {
    Add-Content ".env" "`nDESKTOP_MODE=true`nDESKTOP_SERVER_PORT=8765`nAPP_URL=http://127.0.0.1:8765"
}
(Get-Content ".env") -replace 'DESKTOP_MODE=false', 'DESKTOP_MODE=true' | Set-Content ".env"

# 4. PostgreSQL check
if (Get-Command psql -ErrorAction SilentlyContinue) {
    Write-Host "[OK] PostgreSQL client found" -ForegroundColor Green
    $dbExists = psql -U postgres -tAc "SELECT 1 FROM pg_database WHERE datname='teahouse_pos'" 2>$null
    if (-not $dbExists) {
        psql -U postgres -c "CREATE DATABASE teahouse_pos;" 2>$null
        Write-Host "[OK] Created database teahouse_pos" -ForegroundColor Green
    }
} else {
    Write-Host "[!] PostgreSQL not found. Install from https://www.postgresql.org/download/windows/" -ForegroundColor Yellow
    Write-Host "    Update DB_* settings in .env after install" -ForegroundColor Yellow
}

# 5. Migrate & seed
php artisan migrate --force
php artisan db:seed --force

# 6. Build frontend assets
if (Get-Command npm -ErrorAction SilentlyContinue) {
    npm ci
    npm run build
    Write-Host "[OK] Frontend assets built" -ForegroundColor Green
}

# 7. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Desktop shortcut
$ShortcutPath = [Environment]::GetFolderPath("Desktop") + "\Thar Cho POS.lnk"
$WshShell = New-Object -ComObject WScript.Shell
$Shortcut = $WshShell.CreateShortcut($ShortcutPath)
$Shortcut.TargetPath = Join-Path $AppDir "scripts\windows\start-pos.bat"
$Shortcut.WorkingDirectory = $AppDir
$Shortcut.Description = "Thar Cho POS"
$Shortcut.Save()
Write-Host "[OK] Desktop shortcut created" -ForegroundColor Green

Write-Host ""
Write-Host "Setup complete! Double-click 'Thar Cho POS' on desktop to start." -ForegroundColor Green
Write-Host ""
Write-Host "To build Windows EXE (optional):" -ForegroundColor Cyan
Write-Host "  1. Install Rust: https://rustup.rs/" -ForegroundColor Cyan
Write-Host "  2. cd desktop && npm install && npm run build:windows" -ForegroundColor Cyan
