@echo off
REM =========================================
REM Setup Database Rental Motor
REM =========================================

setlocal enabledelayedexpansion

echo.
echo ====================================
echo   Setup Database Rental Motor
echo ====================================
echo.

REM Check if MySQL is installed
where mysql >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] MySQL tidak ditemukan di PATH
    echo Silakan install MySQL dan tambahkan ke PATH
    pause
    exit /b 1
)

echo [INFO] MySQL ditemukan
echo.

REM Prompt for MySQL credentials
set /p MYSQL_USER="Masukkan MySQL Username (default: root): "
if "%MYSQL_USER%"=="" set MYSQL_USER=root

set /p MYSQL_PASS="Masukkan MySQL Password (tekan Enter jika kosong): "

echo.
echo [INFO] Menjalankan database setup...
echo.

REM Run SQL file
if "%MYSQL_PASS%"=="" (
    mysql -u %MYSQL_USER% < database\db_rental_motor.sql
) else (
    mysql -u %MYSQL_USER% -p%MYSQL_PASS% < database\db_rental_motor.sql
)

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ====================================
    echo [SUCCESS] Database berhasil dibuat!
    echo ====================================
    echo.
    echo Database: db_rental_motor
    echo Tables: 8 tables
    echo Sample Data: Added
    echo.
    echo Silakan update .env file:
    echo DB_USERNAME=%MYSQL_USER%
    echo DB_PASSWORD=(password Anda)
    echo.
) else (
    echo.
    echo [ERROR] Gagal membuat database!
    echo Silakan cek kembali username dan password MySQL
    echo.
)

pause
