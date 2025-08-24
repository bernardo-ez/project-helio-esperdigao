@echo off
echo ========================================
echo    Configurando Projeto Elio
echo ========================================

echo.
echo 1. Iniciando XAMPP...
start "" "C:\xampp\xampp-control.exe"

echo.
echo 2. Aguardando XAMPP iniciar...
timeout /t 5 /nobreak >nul

echo.
echo 3. Copiando projeto para htdocs...
xcopy /E /I /Y "%~dp0" "C:\xampp\htdocs\projeto-elio\"

echo.
echo 4. Verificando se a cópia foi bem-sucedida...
if exist "C:\xampp\htdocs\projeto-elio\api.php" (
    echo ✅ Projeto copiado com sucesso!
) else (
    echo ❌ Erro ao copiar projeto
    pause
    exit /b 1
)

echo.
echo 5. Iniciando Apache e MySQL...
echo Por favor, no XAMPP Control Panel:
echo - Clique em "Start" no Apache
echo - Clique em "Start" no MySQL
echo.
echo 6. Aguardando serviços iniciarem...
timeout /t 10 /nobreak >nul

echo.
echo 7. Testando conexão...
curl -s "http://localhost" >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Apache está funcionando!
) else (
    echo ❌ Apache não está respondendo
    echo Verifique se o Apache foi iniciado no XAMPP
)

echo.
echo ========================================
echo    Configuração Concluída!
echo ========================================
echo.
echo 🌐 URLs para acessar:
echo - Login: http://localhost/projeto-elio/public/index.html
echo - Teste da API: http://localhost/projeto-elio/public/test_api.php
echo - Criar usuários: http://localhost/projeto-elio/public/create_users_web.php
echo.
echo 📋 Próximos passos:
echo 1. Abra o XAMPP Control Panel
echo 2. Inicie Apache e MySQL
echo 3. Acesse: http://localhost/projeto-elio/public/create_users_web.php
echo 4. Depois acesse: http://localhost/projeto-elio/public/index.html
echo.
pause
