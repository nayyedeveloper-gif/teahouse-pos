# Thar Cho POS — Windows Desktop (Tauri)

This folder wraps the Laravel POS web app in a native Windows window.

## Requirements (Windows)

- [Rust](https://rustup.rs/) (MSVC toolchain)
- Node.js 18+
- PHP 8.2+ (for the Laravel backend, started by `scripts/windows/start-pos.bat`)

## Quick start (development)

From the **project root** (not this folder):

```bat
scripts\windows\start-pos.bat
```

This starts Laravel on `http://127.0.0.1:8765` with `DESKTOP_MODE=true` and opens the Tauri EXE if built, otherwise the browser.

## Build Windows installer

On a **Windows** machine:

```bat
scripts\windows\build-desktop.bat
```

Or manually:

```bash
cd desktop
npm install
npm run build:windows
```

Output:

| Artifact | Path |
|----------|------|
| Executable | `desktop/src-tauri/target/release/tharcho-pos-desktop.exe` |
| NSIS installer | `desktop/src-tauri/target/release/bundle/nsis/` |
| MSI installer | `desktop/src-tauri/target/release/bundle/msi/` |

## Configuration

`desktop/src-tauri/tauri.conf.json`:

- Loads `http://127.0.0.1:8765/login`
- User agent: `TharChoPOS/1.0` (detected by `is_desktop_app()`)

`.env` for desktop mode:

```env
DESKTOP_MODE=true
DESKTOP_SERVER_PORT=8765
APP_URL=http://127.0.0.1:8765
```

## macOS / Linux

Tauri builds for Windows require a Windows host (or cross-compile with extra setup). On macOS you can still run the web app:

```bash
php artisan serve
```

Use `scripts/windows/start-pos.bat` only on Windows.
