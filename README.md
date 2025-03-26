# Easylist
- [Easylist](#easylist)
- [Sobre o projeto  ℹ](#sobre-o-projeto--ℹ)
    - [Cenário Atual e Problema 🔴](#cenário-atual-e-problema-)
    - [Proposta da aplicação 🟢](#proposta-da-aplicação-)
- [Principais Objetivos técnicos 🛠️](#principais-objetivos-técnicos-️)
- [Tabelas e Relacionamentos 🗄️](#tabelas-e-relacionamentos-️)
    - [1. categories](#1-categories)
    - [2. product\_categories](#2-product_categories)
    - [3. products](#3-products)
    - [4. product\_picture](#4-product_picture)
    - [5. sizes](#5-sizes)
    - [6. products\_sizes](#6-products_sizes)
    - [7. customer\_order](#7-customer_order)
---
# Sobre o projeto  ℹ
### Cenário Atual e Problema 🔴
* Em períodos em que a loja tem muita demanda, o atendimento online, que é feito por whatsapp, é encerrado devido a dificuldade do atendente em lidar com as conversas no whatsapp ao mesmo tempo que lida com o alto número de clientes na loja física. 
---
### Proposta da aplicação 🟢

* Inicialmente, esta aplicação web irá servir como "primeiro contato" e fará a apresentação de opções, para que os clientes possam selecionar os itens que desejam comprar. Na finalização do pedido, os itens e seus detalhes (como por exemplo tamanho e cor) serão adicionados a uma lista contendo informações do cliente, forma de envio e meio de pagamento.

* Inicialmente, a finalização do pedido ainda será feita via whatsapp. Mas de acordo com o proprietário da loja, caso haja melhora com a implementação da aplicação, todo o checkout será feito pela aplicação e o whatsapp ficará apenas para suporte.
---
# Principais Objetivos técnicos 🛠️

* A escolha do PHP puro, é para que eu possa fazer todo o código da forma mais manual possível, e assim descobrir e entender como as coisas funcionam "por debaixo dos panos".

* Aplicar os conceitos de SOLID, pois acredito que são o conjunto de boas práticas mais importante na orientação a objetos.

* Desenvolver a aplicação pensando em evitar o acoplamento para facilitar manutenção e a implementação de testes automatizados.

* Implementar testes automatizados. Na minha visão, a testabilidade é um dos pilares mais importantes no desenvolvimento de software.

* Realizar o deploy da aplicação. Até o momento, a AWS (free tier) é a escolha de plataforma que será utilizada.

* Documentar toda a aplicação para ter uma visão geral sobre o que cada coisa faz, para o que foi feito, como foi implementado e por quê. Acredito que isso vai servir tanto para resolver problemas quanto para fazer melhorias no futuro.

* Aprender sobre Github Actions e implementar uma esteira de deploy CI/CD.

---

# Tabelas e Relacionamentos 🗄️

* Obs: Atualmente, apenas a tabela de produtos está inserida no projeto. As tabelas abaixo ainda serão implementadas
  
### 1. categories
Tabela que armazena as categorias dos produtos.

| Campo  | Tipo   | Descrição          |
|--------|--------|-----------------|
| id     | INT (PK) | Identificador único da categoria |
| name   | VARCHAR | Nome da categoria |

**Relacionamentos:**
- Relaciona-se com `products` através da tabela intermediária `product_categories`.

---

### 2. product_categories
Tabela intermediária que define o relacionamento muitos-para-muitos entre produtos e categorias.

| Campo       | Tipo   | Descrição          |
|------------|--------|-----------------|
| id         | INT (PK) | Identificador único |
| category_id| INT (FK) | Referência para `categories` |
| product_id | INT (FK) | Referência para `products` |

---

### 3. products
Tabela que armazena os produtos do sistema.

| Campo             | Tipo   | Descrição |
|------------------|--------|-----------|
| id              | INT (PK) | Identificador único do produto |
| name            | VARCHAR | Nome do produto |
| price           | INT | Preço do produto |
| stock           | ENUM (disponível e indisponível) | Disponibilidade do produto |

**Relacionamentos:**
- Possui um relacionamento opcional com `product_picture`.
- Relaciona-se com `categories` através da tabela `product_categories`.
- Relaciona-se com `sizes` através da tabela intermediária `products_sizes`.

---

### 4. product_picture
Tabela que armazena imagens dos produtos.

| Campo         | Tipo   | Descrição |
|--------------|--------|-----------|
| id           | INT (PK) | Identificador único da imagem |
| picture_url  | VARCHAR | URL da imagem |
| product_id   | INT (FK) | Referência para `products` |

---

### 5. sizes
Tabela que armazena os tamanhos disponíveis para os produtos.

| Campo             | Tipo   | Descrição |
|------------------|--------|-----------|
| id              | INT (PK) | Identificador único do tamanho |
| size_description | VARCHAR | Descrição do tamanho |

---

### 6. products_sizes
Tabela intermediária que define o relacionamento muitos-para-muitos entre produtos e tamanhos.

| Campo     | Tipo   | Descrição |
|----------|--------|-----------|
| id       | INT (PK) | Identificador único |
| product_id | INT (FK) | Referência para `products` |
| size_id  | INT (FK) | Referência para `sizes` |

---

### 7. customer_order
Tabela que armazena os pedidos dos clientes.

| Campo             | Tipo   | Descrição |
|------------------|--------|-----------|
| id              | INT (PK) | Identificador único do pedido |
| customer_name   | VARCHAR | Nome do cliente |
| delivery_method | ENUM (retirada ou delivery) | Método de entrega |
| payment_method  | VARCHAR | Forma de pagamento |
| shipping_address| VARCHAR | Endereço de entrega |
| product_sizes_id | INT (FK) | Referência para `products_sizes` |




