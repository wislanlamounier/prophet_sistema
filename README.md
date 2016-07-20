# prophet_sistema
Sistema de gestão odontológica

# Informações
Para o funcionamento do software, é necessário ao menos 2 bancos de dados: o principal (prophet_main) e outro pertencente à
clínica contratante (prophet_uniqid()). Usuário: rafael@bentonet.com.br. Senha: 123.

# Instalação
**Banco de dados:**
Na pasta *instalação* estão presente dois arquivos SQL: prophet_main.sql e prophet_testes.sql. Importe antes
o prophet_main.

**Apache:**
O sistema funciona com URL amigável. Para que ela funcione, é necessário que o prophet esteja funcionando na pasta raíz do
htdocs (xampp) / www (wamp). Não precisa fazer nenhuma alteração na tua estrutura de diretórios, apenas copia o código
presente no arquivo *modificacoes_httpd.conf* na pasta *instalação*.
Este código vai abrir uma nova porta para o Apache (8083). Caso tu já esteja utilizando ela, por favor, ver próximo item.

**Porta já utilizada:**
Muda o arquivo *modificacoes_httpd.conf*, pra ele dar Listen na porta que tu desejar. Após isto, verificar os seguintes arquivos:
- inc/config.inc.php (linha 29 e 33)
- inc/errorHalnder.inc.php (linha 41)
