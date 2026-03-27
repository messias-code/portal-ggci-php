#!/bin/bash

echo "🚀 Iniciando a configuração do Apache..."

# 1. Pega o diretório atual do script (a pasta scripts/) e volta uma casa para achar a raiz do repo
DIR_SCRIPTS="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
RAIZ_PROJETO="$(dirname "$DIR_SCRIPTS")"

echo "📦 Instalando Apache e PHP..."
sudo apt-get update -y
sudo apt-get install apache2 php libapache2-mod-php -y

echo "🧹 Limpando o diretório /var/www/html..."
sudo rm -rf /var/www/html/*

echo "📂 Copiando o projeto de $RAIZ_PROJETO para o Apache..."
# Remove a pasta de destino caso exista, para evitar conflitos
sudo rm -rf /var/www/html/portal-ggci
# Copia o repositório inteiro para o local final com o nome exato esperado
sudo cp -r "$RAIZ_PROJETO" /var/www/html/portal-ggci

# 2. Ajusta as permissões de forma universal e segura
# Pega o usuário real que chamou o script (mesmo se usou sudo, ex: labs)
USUARIO_REAL=${SUDO_USER:-$USER}

echo "🔑 Ajustando permissões para o usuário $USUARIO_REAL e o Apache (www-data)..."
# Dono = usuário real / Grupo = Apache
sudo chown -R $USUARIO_REAL:www-data /var/www/html
# 775 garante que tanto o dono quanto o Apache possam ler, executar e GRAVAR (essencial para o auto-backup)
sudo chmod -R 775 /var/www/html

echo "🔄 Reiniciando o Apache..."
sudo systemctl restart apache2

echo "✅ Apache configurado e Portal GGCI implantado com sucesso!"