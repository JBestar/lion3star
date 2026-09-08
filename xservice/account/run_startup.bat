@echo off
chcp 65001 >nul
cd /d "%~dp0"

set "PHP_EXE=D:\xampp\php\php.exe"
if not exist "%PHP_EXE%" set "PHP_EXE=php"

echo lion3\xservice\account — PBG 회차등록 + 정산 (Ctrl+C 종료)
echo.

"%PHP_EXE%" -f "%~dp0Startup.php"

echo.
echo exit: %ERRORLEVEL%
pause
