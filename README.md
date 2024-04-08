# FullStackProject-E-Commerce (Dev Utopia)
Este repositório teve como o objetivo armazenar meu primeiro projeto desenvolvendo FullStack(Frontend e Backend), para o Frontend foi utilizado a linguagem Typescript com o framework Angular(versão 16) e para o Backend PHP com o framework Slim(versão 3).

## Introdução
O software em questão foi desenvolvido com foco em atender às necessidades de um público apaixonado por tecnologia e desenvolvedores, oferecendo uma plataforma de comércio eletrônico especializada na venda e compra de produtos de alta tecnologia. Com uma identidade visual marcante e funcionalidades intuitivas, o software proporciona uma experiência de compra e venda de produtos eletrônicos de forma eficiente e agradável.

Este projeto, embora simulado, foi concebido com o propósito de testar conhecimentos e habilidades no desenvolvimento de software, não tendo fins lucrativos ou conexão com sistemas de pagamento reais. Toda a operação relacionada a transações financeiras é fictícia e serve apenas para demonstrar as funcionalidades do software.

Ao explorar este documento, você encontrará uma descrição detalhada das principais características e funcionalidades do software, juntamente com informações sobre seu desenvolvimento, tecnologias utilizadas e perspectivas futuras. Espera-se que este software atenda às necessidades do seu público-alvo e proporcione uma experiência de compra online gratificante e confiável.

## Banco de Dados
O banco de dados foi construído com SQL Server, empregando uma estrutura que utiliza múltiplos relacionamentos entre as tabelas e deletes em cascata. Essas escolhas visam otimizar o desempenho do banco e garantir uma limpeza automatizada dos dados. Vale ressaltar que a concepção do banco não foi pré-definida, mas sim desenvolvida e refinada ao longo do processo de desenvolvimento. Embora possam existir áreas para melhorias na organização, foram aplicados esforços para garantir que o banco desempenhe suas funções de forma eficaz e eficiente.

Dentro dos arquivos do Backend, você encontrará a pasta "SQL", que contém o script responsável pela construção do banco de dados. Além disso, há um arquivo com os inserts dos perfis, os quais são essenciais para o correto funcionamento do software.

## Perfis
O sistema possui três perfis de acesso distintos. O primeiro nível é o perfil "customer", que tem todas as permissões necessárias para navegar pelo sistema, visualizar produtos e realizar compras. O segundo nível é o perfil "seller", que inclui todas as funcionalidades do perfil "customer", mas também oferece uma aba adicional na lista de produtos, dedicada ao gerenciamento e criação de produtos próprios. Por fim, o último nível de acesso é o perfil "admin", que só pode ser atribuído diretamente no banco de dados. Este perfil possui todas as funcionalidades dos outros perfis, além de recursos adicionais, como visualizar a lista de usuários, remover usuários, e editar ou excluir qualquer produto. O perfil "admin" tem a responsabilidade de garantir que apenas produtos relevantes para o objetivo do software sejam inseridos no sistema.

## Telas
## Login/Register
A tela de Login/Register desempenha um papel crucial na segurança do sistema, sendo a porta de entrada para os usuários e uma parte vital do processo de criação de contas. Neste contexto, que busca simular um ambiente semelhante a um e-commerce, embora com um sistema de pagamento fictício, esta tela assume uma responsabilidade fundamental.

Ao apresentar-se como o ponto de partida para novos usuários, ela requer informações essenciais para o registro, como nome, e-mail e a criação de uma senha segura. Estes campos não apenas facilitam a identificação única de cada usuário, mas também garantem a integridade e confidencialidade de suas informações pessoais.

Com um foco especial na segurança, a tela de registro implementa medidas para validar e proteger as informações fornecidas. Isso inclui a verificação da singularidade do endereço de e-mail para evitar duplicatas e a aplicação de critérios rigorosos para a criação de senhas robustas, promovendo a proteção contra acesso não autorizado às contas dos usuários.

Além de oferecer uma experiência de registro intuitiva e amigável, a tela de Login/Register desempenha um papel vital na construção da confiança dos usuários no sistema, assegurando-lhes que suas informações estão protegidas e que podem navegar e interagir com a plataforma com segurança e tranquilidade.

Tela Padrão:  
![localhost_63549_auth](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/a8c0590f-7214-4ebe-b8de-126ffe1f3fa8)  
Register:  
![localhost_63549_auth (1)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/a1795455-619b-48dc-b668-d774980ca10b)  
Login:  
![localhost_63549_auth (2)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/06777812-82ea-45e5-aab3-66e38c1d3a4f)  

As telas também contam com indicadores visuais para campos obrigatórios(*), e botão para visualização de senha.

## Home
A página inicial é o ponto de entrada do sistema, projetada para receber os usuários e fornecer uma visão geral do propósito e funcionalidades do software. Além de oferecer uma breve explicação sobre a plataforma, esta tela apresenta alguns tipos de produtos que o sistema possui, promovendo uma rápida imersão no catálogo disponível. Sua interface intuitiva e atrativa tem como objetivo cativar os visitantes e incentivá-los a explorar mais profundamente o sistema.

![localhost_63549_home](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/ca36ffa7-115f-4ae3-8e73-730d4a378b8f)

## Perfil/Usuário
A tela de Perfil/Usuário desempenha um papel essencial ao fornecer aos usuários uma visão completa de suas informações pessoais, incluindo nome, e-mail, detalhes de localização e tipo de perfil. Além disso, ela oferece a funcionalidade de atualizar esses dados de forma intuitiva e conveniente.

Um dos aspectos distintivos dessa tela é sua capacidade de integrar-se com fontes externas de dados, como a [API do IBGE](https://servicodados.ibge.gov.br/api/docs/localidades) para obter informações sobre Estado e Cidade e a [API do Brasil Aberto](https://brasilaberto.com/docs) para preencher automaticamente os dados de Estado, Cidade e Endereço com base no CEP fornecido pelo usuário.

Esta integração com APIs externas não apenas enriquece a experiência do usuário, fornecendo informações precisas e atualizadas, mas também simplifica o processo de atualização e verificação dos dados de localização, eliminando a necessidade de inserção manual e garantindo a precisão das informações.

Além disso, a presença de um botão dedicado para atualização dos dados facilita o acesso e a execução dessa funcionalidade, garantindo que os usuários possam manter suas informações pessoais sempre atualizadas com facilidade e rapidez.

Adicionalmente, o sistema possui uma ferramenta de troca de senha, que valida a senha atual do usuário antes de permitir a alteração. Isso adiciona uma camada adicional de segurança, garantindo que apenas o usuário autenticado possa modificar sua senha com sucesso.

### Perfil/Usuário como Cliente
A tela de Perfil/Usuário para clientes oferece todas as funcionalidades mencionadas anteriormente, além de incluir um botão dedicado à troca de perfil, permitindo aos usuários mudarem facilmente para o perfil de vendedor, caso desejem começar a vender produtos na plataforma.

![localhost_63549_profile](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/5990d658-98e3-41a1-8315-99aafe68f51c)

## Perfil/Usuário como Vendedor
A tela de Perfil/Usuário para vendedor oferece todas as funcionalidades bases.

![localhost_63549_profile (1)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/13c7ace1-c8f2-4ddf-b560-4fc89ea7abf9)

## Perfil/Usuário como Admin
A tela de Perfil/Usuário para administradores oferece todas as funcionalidades básicas, além de apresentar uma lista abrangente dos usuários registrados na plataforma, exibindo seus nomes, e-mails e perfis de acesso. Esta funcionalidade é acompanhada por um recurso de filtro de nome, permitindo aos administradores localizarem usuários específicos com facilidade.

Além disso, a tela inclui um botão dedicado para excluir usuários, proporcionando aos administradores a capacidade de gerenciar de forma eficiente o banco de dados de usuários. Essa funcionalidade é essencial para manter a integridade e a segurança da plataforma, permitindo que os administradores ajam rapidamente em caso de necessidade de remoção de contas.

Em resumo, a tela de Perfil/Usuário para administradores oferece uma visão completa e ferramentas robustas para o gerenciamento de usuários, garantindo que os administradores possam supervisionar e manter a plataforma de forma eficaz e eficiente.

![localhost_63549_profile (5)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/08a01b9b-7d87-4539-b64d-739f35bc7ebd)


### Visão de Edição 
Ao clicar no lápis na tela, independente do perfil, o card dos dados se expande e mostra inputs e select para alterar os dados do usuário.

![localhost_63549_profile (4)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/dbb57713-c900-4289-bc24-f24a85252f78)

## Produtos
A tela de Produtos desempenha um papel central ao apresentar todos os itens disponíveis no sistema, oferecendo aos usuários uma experiência de navegação intuitiva e eficiente. Equipada com funcionalidades úteis, como filtros por nome e opções de ordenação por preço ou data de criação, ela proporciona uma experiência de compra personalizada e conveniente.

Além disso, essa tela também varia de acordo com o perfil do usuário, adaptando-se às suas necessidades específicas.

### Produtos como Cliente
A tela apresenta todos os recursos citados anteriormente.

![localhost_63549_products_view_6](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/00cd2f47-0ab3-409f-ba5c-a0746f9ad4bb)

### Produtos como Vendedor
Além dos recursos básicos, os vendedores têm acesso a uma aba adicional no topo chamada "Meus Produtos". Esta aba exibe a listagem dos produtos pertencentes ao vendedor, juntamente com botões que permitem editar, excluir e cadastrar novos produtos diretamente. Essa funcionalidade proporciona aos vendedores um controle completo sobre seus produtos, facilitando a gestão e atualização de seu catálogo na plataforma.

![localhost_63549_products_view_6 (1)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/4ebc97a3-ff91-4a06-9079-cab2c26e1d55)

### Produtos como Admin
Além dos recursos padrão, o perfil de administrador possui a capacidade exclusiva de editar ou excluir qualquer produto na plataforma. Isso garante um gerenciamento completo e abrangente, permitindo que o administrador mantenha total controle sobre o catálogo de produtos. Essa funcionalidade é essencial para garantir a integridade e a qualidade do conteúdo oferecido aos usuários, além de proporcionar uma gestão eficaz e ágil do sistema como um todo.

![localhost_63549_products_view_6 (2)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/0fb8a436-f41f-48b4-8229-f20278b22108)

### Visualização de Produto
Ao clicar em um dos produtos abre a perte referente ao detalhamento dele.

![localhost_63549_products_view_6 (3)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/ab23aae3-9fca-4e2b-8d44-661a7791953b)

Ao clicar para exibir as avaliações de um produto:

![localhost_63549_products_view_6 (5)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/db46d9f3-8e50-4f4c-b9a4-10a29fdd6e74)

OBS: Os botões que aparecem sobre a tela no print, é devido a eles serem fixos(acompanharem a tela) então com o print de tela toda ele aparenta estar meio solto.
Exemplo da tela normal:

![image](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/4a89a027-be5c-41c2-91fb-2b844514b0fd)

### Edição de Produto

![localhost_63549_products_view_6 (6)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/e17668c8-cb95-4428-9dcd-674656a1a1d6)

### Criação de Produto

![localhost_63549_products_view_6 (7)](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/566bb8e9-7746-436c-9b70-eb7548c34218)

## Carrinho de Compras
O carrinho de compras tem a função fundamental de armazenar os produtos selecionados pelo usuário durante a sessão de compras. Ele permite que os usuários visualizem e revisem os itens escolhidos antes de prosseguir para a tela de finalização da compra. Essa funcionalidade proporciona uma experiência de compra conveniente e organizada, permitindo que os usuários controlem e gerenciem seus pedidos de forma eficiente antes de concluir a compra.

Ao clicar no ícone na top bar abre a exibição do carrinho:

![image](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/d3da990c-5ed1-4608-b0c6-0e0559018ad6)

### Tela de Finalização de Compra

![image](https://github.com/kauanrfontana/FullStackProject-E-Commerce/assets/96593822/e7012d9c-c78a-48aa-b0f4-a69691448c83)

OBS: Como uma regra de negócio fundamental, estabeleci que os usuários só podem comentar em produtos após terem efetuado a compra correspondente. Essa medida visa garantir a autenticidade e relevância dos comentários, promovendo uma experiência de interação mais genuína e confiável entre os usuários e os produtos.



