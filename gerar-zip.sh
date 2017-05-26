#!/bin/bash -e

echo $'\n\n\e[1;34m'"$*"$'Gerando pacote...\n\n\e[0m'

rm -rf dist/wp-revista.zip
zip dist/wp-revista.zip ./*.php ./*.css

echo $'\n\n\n\e[1;34m'"$*"$'Pacote gerado com sucesso!\e[0m'
