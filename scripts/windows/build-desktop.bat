@echo off
setlocal EnableDelayedExpansion

REM Build Thar Cho POS Windows desktop (Tauri)
set "APP_DIR=%~dp0..\.."
set "DESKTOP_DIR=%APP_DIR%\desktop"

cd /d "%DESKTOP_DIR%"

echo ========================================
echo   Thar Cho POS - Building Desktop...
echo ========================================

where npm >nul 2>&1
if errorlevel 1 (
    echo [ERROR] npm not found. Install Node.js 18+.
    pause
    exit /b 1
)

where cargo >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Rust/cargo not found. Install from https://rustup.rs/
    pause
    exit /b 1
)

echo Installing desktop dependencies...
call npm install
if errorlevel 1 (
    echo [ERROR] npm install failed.
    pause
    exit /b 1
)

echo Building Windows release...
call npm run build:windows
if errorlevel 1 (
    echo [ERROR] Tauri build failed.
    pause
    exit /b 1
)

set "EXE=%DESKTOP_DIR%\src-tauri\target\release\tharcho-pos-desktop.exe"
if exist "%EXE%" (
    echo.
    echo Build successful!
    echo EXE: %EXE%
    echo.
    echo Run scripts\windows\start-pos.bat to launch POS.
) else (
    echo [WARN] Build finished but EXE not found at expected path.
    echo Check: %DESKTOP_DIR%\src-tauri\target\release\
)

pause
endlocal
