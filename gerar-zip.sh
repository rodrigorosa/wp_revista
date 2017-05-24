#!/bin/bash -e

echo $'\n\n\e[1;34m'"$*"$'Gerando pacote...\n\n\e[0m'

rm -rf dist/plugin.zip
zip dist/plugin.zip ./*.php

echo $'\n\n\n\e[1;34m'"$*"$'Pacote gerado com sucesso!\e[0m'
