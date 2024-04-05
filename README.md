# FullStackProject-E-Commerce (Dev Utopia)
Este repositório teve como o objetivo armazenar meu primeiro projeto desenvolvendo FullStack(Frontend e Backend), para o Frontend foi utilizado a linguagem Typescript com o framework Angular(versão 16) e para o Backend PHP com o framework Slim(versão 3).

## Introdução
O software em questão foi desenvolvido com foco em atender às necessidades de um público apaixonado por tecnologia e desenvolvedores, oferecendo uma plataforma de comércio eletrônico especializada na venda e compra de produtos de alta tecnologia. Com uma identidade visual marcante e funcionalidades intuitivas, o software proporciona uma experiência de compra e venda de produtos eletrônicos de forma eficiente e agradável.

Este projeto, embora simulado, foi concebido com o propósito de testar conhecimentos e habilidades no desenvolvimento de software, não tendo fins lucrativos ou conexão com sistemas de pagamento reais. Toda a operação relacionada a transações financeiras é fictícia e serve apenas para demonstrar as funcionalidades do software.

Ao explorar este documento, você encontrará uma descrição detalhada das principais características e funcionalidades do software, juntamente com informações sobre seu desenvolvimento, tecnologias utilizadas e perspectivas futuras. Espera-se que este software atenda às necessidades do seu público-alvo e proporcione uma experiência de compra online gratificante e confiável.

## Banco de Dados
O banco de dados foi construído com SQL Server, empregando uma estrutura que utiliza múltiplos relacionamentos entre as tabelas e deletes em cascata. Essas escolhas visam otimizar o desempenho do banco e garantir uma limpeza automatizada dos dados. Vale ressaltar que a concepção do banco não foi pré-definida, mas sim desenvolvida e refinada ao longo do processo de desenvolvimento. Embora possam existir áreas para melhorias na organização, foram aplicados esforços para garantir que o banco desempenhe suas funções de forma eficaz e eficiente.

Dentro dos arquivos do Backend, você encontrará a pasta "SQL", que contém o script responsável pela construção do banco de dados. Além disso, há um arquivo com os inserts dos perfis, os quais são essenciais para o correto funcionamento do software.

### Perfis
O sistema possui três perfis de acesso distintos. O primeiro nível é o perfil "customer", que tem todas as permissões necessárias para navegar pelo sistema, visualizar produtos e realizar compras. O segundo nível é o perfil "seller", que inclui todas as funcionalidades do perfil "customer", mas também oferece uma aba adicional na lista de produtos, dedicada ao gerenciamento e criação de produtos próprios. Por fim, o último nível de acesso é o perfil "admin", que só pode ser atribuído diretamente no banco de dados. Este perfil possui todas as funcionalidades dos outros perfis, além de recursos adicionais, como visualizar a lista de usuários, remover usuários, e editar ou excluir qualquer produto. O perfil "admin" tem a responsabilidade de garantir que apenas produtos relevantes para o objetivo do software sejam inseridos no sistema.
