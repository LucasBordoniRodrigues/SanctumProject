Feature: Login
Na chamada do serviço
Deve-se receber credenciais e gerar um Token para utilização na autenticação das funcionalidades

Cenário: Credenciais Válidas
Dado que foram recebidas credenciais válidas
Quando solicitar para fazer autenticação
Então o sistema deve retornar um token válido

Cenário: Credenciais Inválidas
Dado que foram recebidas credenciais inválidas
Quando solicitar para fazer autenticação
Então o sistema deve retorna uma mensagem de erro