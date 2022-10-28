# OAuth Authentication Usecase

> ## Caso de sucesso
1. Sistema valida os dados
2. Sistema faz a utilização de um meio de autenticação
3. Sistema valida os dados recebidos
4. Sistema entrega o Token

> ## Exceção - Dados inválidos
1. Sistema retorna uma mensagem de dados inválidos e status code correspondente

> ## Exceção - Credenciais inválidas
1. Sistema retorna uma mensagem de credenciais inválidas e status code correspondente

> ## Exceção - Inesperada
1.  Sistema retorna uma mensagem de erro interno e status code correspondente