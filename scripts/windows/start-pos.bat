@echo off
setlocal EnableDelayedExpansion

REM Thar Cho POS - Windows Launcher
REM Starts Laravel backend and opens POS in default browser (or Tauri EXE if installed)

set "APP_DIR=%~dp0..\.."
set "PORT=8765"
set "HOST=127.0.0.1"
set "URL=http://%HOST%:%PORT%/login"

cd /d "%APP_DIR%"

echo ========================================
echo   Thar Cho POS - Starting...
echo ========================================

REM Check PHP
where php >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP not found. Install PHP 8.2+ and add to PATH.
    pause
    exit /b 1
)

REM Check if server already running
curl -s -o nul -w "%%{http_code}" "%URL%" 2>nul | findstr /r "^[23]" >nul
if not errorlevel 1 (
    echo Server already running at %URL%
    goto :open_app
)

echo Starting Laravel server on %URL% ...
start "TharChoPOS-Server" /min cmd /c "cd /d \"%APP_DIR%\" && set DESKTOP_MODE=true && php artisan serve --host=%HOST% --port=%PORT%"

REM Wait for server
set /a tries=0
:wait_loop
set /a tries+=1
if %tries% gtr 30 (
    echo [ERROR] Server failed to start within 30 seconds.
    pause
    exit /b 1
)
timeout /t 1 /nobreak >nul
curl -s -o nul "%URL%" 2>nul
if errorlevel 1 goto :wait_loop

echo Server ready!

:open_app
REM Try Tauri EXE first (release build or bundled name), fallback to browser
set "TAURI_EXE=%APP_DIR%\desktop\src-tauri\target\release\tharcho-pos-desktop.exe"
set "TAURI_EXE_ALT=%APP_DIR%\desktop\src-tauri\target\release\Thar Cho POS.exe"
if exist "%TAURI_EXE%" (
    start "" "%TAURI_EXE%"
) else if exist "%TAURI_EXE_ALT%" (
    start "" "%TAURI_EXE_ALT%"
) else (
    echo Opening in browser...
    start "" "%URL%"
)

echo.
echo POS is running. Close the server window to stop.
endlocal
