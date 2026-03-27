#!/bin/bash

echo "🧨 Iniciando a limpeza profunda e reinstalação do MySQL..."

# 1. Mapeamento de caminho dinâmico para achar o arquivo .sql na raiz do repo
DIR_SCRIPTS="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
RAIZ_PROJETO="$(dirname "$DIR_SCRIPTS")"
ARQUIVO_SQL="$RAIZ_PROJETO/database.sql"

# 2. Extermínio do MySQL antigo
echo "🛑 Parando e removendo o MySQL antigo..."
sudo systemctl stop mysql
sudo apt-get purge "mysql-server*" "mysql-client*" mysql-common -y

echo "🗑️ Apagando arquivos residuais..."
sudo rm -rf /etc/mysql /var/lib/mysql /var/log/mysql
sudo apt-get autoremove -y
sudo apt-get autoclean -y

# 3. Instalação do MySQL novo
echo "📦 Instalando o MySQL Server do zero..."
sudo apt-get update -y
sudo apt-get install mysql-server php-mysql -y

# 4. Inicia o serviço do banco
echo "🟢 Iniciando o serviço do MySQL..."
sudo systemctl start mysql

# 5. Injeta o banco mapeado na variável
echo "💾 Lendo e injetando o banco de dados ($ARQUIVO_SQL)..."
sudo mysql -u root < "$ARQUIVO_SQL"

echo "✅ MySQL reinstalado e Banco de Dados injetado com sucesso!"