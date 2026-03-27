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
# Remove a pasta de destino caso exista, para evitar que o cp crie subpastas erradas
sudo rm -rf /var/www/html/portal-ggci
# Copia o repositório inteiro para o local final com o nome exato esperado
sudo cp -r "$RAIZ_PROJETO" /var/www/html/portal-ggci

echo "🔑 Ajustando permissões de usuário para $USER..."
sudo chown -R $USER:$USER /var/www/html
sudo chmod -R 755 /var/www/html

echo "🔄 Reiniciando o Apache..."
sudo systemctl restart apache2

echo "✅ Apache configurado e Portal GGCI implantado com sucesso!"