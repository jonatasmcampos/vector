# 🚀 Vector

**Vector** é um sistema de gestão orçamentária desenvolvido para lidar com fluxos reais de compras, garantindo que cada ordem de compra seja validada com base nos recursos financeiros disponíveis antes de ser aprovada.

A aplicação centraliza o controle de orçamento e a autorização de compras, reduzindo o risco de gastos excessivos e trazendo consistência aos processos de tomada de decisão dentro da organização. Ao aplicar regras de negócio na camada da aplicação, o Vector fornece uma base confiável para gerenciar operações financeiras e evoluí-las ao longo do tempo.

---

## 📌 Visão Geral

O Vector foi desenvolvido com forte foco em **arquitetura de software e qualidade de código**, aplicando princípios como:

* SOLID
* Clean Architecture
* Clean Code
* Design Patterns

O projeto simula um cenário corporativo real, onde solicitações de compra precisam ser validadas com base no orçamento disponível antes de serem aprovadas.

---

## 🛠️ Tech Stack

* **Backend:** PHP 8.2, Laravel 12
* **Frontend:** Bootstrap 5.3.8, DataTables 2.3.4, jQuery 3.7.1
* **Banco de Dados:** MySQL
* **Ambiente:** Docker

---

## ⚡ Quick Start

```bash
git clone https://github.com/jonatasmcampos/vector.git
cd vector

composer install
sudo docker compose up -d --build

docker exec -it vector bash
cp .env.example .env
php artisan key:generate
php artisan vector:atualizar
```

## 🌐 Acesse a aplicação

Após a configuração estar completa, a aplicação estará disponível em:
`http://localhost:8000/entrar`

---

### 🔐 Permissões

Em alguns ambientes (especialmente ao usar Docker), pode ser necessário ajustar as permissões de pastas para permitir que o Laravel escreva logs e arquivos de cache.

Execute o seguinte comando dentro do container:

```
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

Isso garante que a aplicação tenha as permissões corretas para funcionar adequadamente.

---

## 🧠 Conceito Principal

O principal objetivo do sistema é:

> Validar e registrar ordens de compra com base na disponibilidade orçamentária.

Quando uma ordem de compra é criada:

1. O sistema recebe a requisição via API
2. Um **orquestrador** coordena o fluxo
3. As regras de negócio são aplicadas
4. A ordem é aprovada ou rejeitada com base na validação do orçamento

---

## 🏗️ Arquitetura

O projeto segue os princípios de **Clean Architecture**, separando responsabilidades em camadas bem definidas:

### 📂 Estrutura

* **Domain**

  * Entidades
  * Value Objects
  * Regras de negócio

* **Application**

  * Casos de uso
  * DTOs (Data Transfer Objects)

* **Infrastructure**

  * Implementações de repositórios
  * Integrações externas

* **Interfaces**

  * Controllers (API / Web)

---

### 🔁 Exemplo de Fluxo

```
Controller → Orchestrator → UseCase → Domain → Repository
```

Isso garante:

* Alta manutenibilidade
* Testabilidade
* Clara separação de responsabilidades

---

## 🔌 API

### ➕ Criar Ordem de Compra

**Endpoint:**

```
POST /api/purchase-order/store
```

**Descrição:**
Cria uma ordem de compra e valida com base no orçamento disponível.

**Fluxo:**

* Recebe o payload
* Envia para o orquestrador
* Executa validação + criação
* Retorna sucesso ou falha

---

## 🧪 Testes & Dados de Exemplo

O projeto inclui um teste automatizado que não apenas valida o fluxo de criação de ordens de compra, mas também gera dados de exemplo para simular cenários reais.

Isso permite que o sistema seja inicializado com dados significativos, facilitando a exploração e o entendimento do seu comportamento sem começar do zero.

### ▶️ Executar teste e gerar dados

Dentro do container:

```
php artisan test tests/Feature/RegisterPurchaseOrderTest.php
```

---

## 🗄️ Banco de Dados

O sistema utiliza **MySQL** como seu banco de dados principal.

---

## 💡 Principais Destaques Técnicos

* Implementação de Clean Architecture no Laravel
* Uso de DTOs para transporte de dados
* Value Objects para reforçar regras de domínio
* Padrão Orchestrator para coordenar casos de uso
* Repository Pattern para abstração de dados
* Ambiente baseado em Docker
* Testes automatizados

---

## 📈 Melhorias Futuras

* Implementação de módulo de pagamentos
* Arquitetura orientada a eventos (Kafka / filas)
* Autenticação baseada em token (JWT / Sanctum)
* Melhorias em logs e auditoria
* Documentação da API (Swagger / OpenAPI)

---

## 👨‍💻 Autor

Desenvolvido por **Jonatas Campos**

---

## ⭐ Considerações Finais

Este projeto foi desenvolvido não apenas para resolver um problema de negócio, mas também para demonstrar forte conhecimento em:

* Arquitetura de software
* Design de sistemas escaláveis
* Boas práticas de desenvolvimento backend
