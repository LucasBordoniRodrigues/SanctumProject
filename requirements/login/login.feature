Feature: Login
Eu como o sistema
Devo receber credenciais e gerar um TOKEN que será utilizado na autenticação das funcionalidades

Cenário: Credenciais Válidas
Dado que foram recebidas credenciais válidas
Quando solicitar para fazer autenticação
Então o sistema deve retornar um token válido

Cenário: Credenciais Inválidas
Dado que foram recebidas credenciais inválidas
Quando solicitar para fazer autenticação
Então o sistema deve retorna uma mensagem de erro
