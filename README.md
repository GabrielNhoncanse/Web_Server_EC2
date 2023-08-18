# Web_Server_EC2

Entrega ponderada da semana 03 - módulo 07

Os códigos contidos neste repositório são responsáveis por hospedar uma aplicação web e conectá-la a um banco de dados RDS integrado a um EC2. Cada um dos códigos é descrito com mais detalhes abaixo.

## Página de Exemplo (Sample Page)

Esta página é construída com base no tutorial de servidor web da AWS. Ela cria e hospeda uma página web que contém dois campos de entrada, ambos do tipo string, e um botão "submit". Ao iniciar a página, verifica-se se a tabela de employees existe no banco e, caso não exista, ela é criada. Ao clicar no botão, as informações são adicionadas ao banco de dados em suas respectivas colunas de "Nome" e "Endereço", e uma variável é criada para representar os dados salvos no banco naquele momento. Com base nessa variável, todas as linhas da tabela são apresentadas na página.

## Página de Alunos (Alunos Page)

Esta página foi desenvolvida para a atividade ponderada. Ela é responsável por hospedar uma aplicação web em um EC2 conectado a um RDS, criar uma tabela no banco e modificá-la. Ao carregar a aplicação, verifica-se se a tabela "Aluno" existe e, caso não exista, ela é criada. Na página, existem 4 campos de entrada, que representam as informações: nome (tipo VARCHAR com tamanho máximo de 45), curso (tipo VARCHAR com tamanho máximo de 45), média de notas (float) e ano de formatura (inteiro). Na tabela, há também uma coluna "id", a qual respeita a característica de AUTO_INCREMENT do MySQL, ou seja, a cada nova linha ela é incrementada em 1. Além disso, há um botão "submit", que envia e armazena as informações no banco. Outro campo nesta página é o de exclusão de aluno por id. Neste campo, é recebido um inteiro que representa um id e, ao clicar no botão submit, a linha com o id inserido é deletada da tabela. Ao final da página, são mostrados ao usuário todos os dados salvos na tabela até aquele momento.
