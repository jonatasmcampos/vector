# 🚀 Vector

**Vector** is a budget management system built to handle real-world purchasing workflows, ensuring that every purchase order is validated against available financial resources before being approved.

The application centralizes budget control and purchase authorization, reducing the risk of overspending and bringing consistency to decision-making processes within the organization. By enforcing business rules at the application layer, Vector provides a reliable foundation for managing financial operations and evolving them over time.

---

## 📌 Overview

Vector was built with a strong focus on **software architecture and code quality**, applying principles such as:

* SOLID
* Clean Architecture
* Clean Code
* Design Patterns

The project simulates a real-world corporate scenario where purchase requests must be validated against available budget before being approved.

---

## 🧠 Core Concept

The main goal of the system is to:

> Validate and register purchase orders based on budget availability.

When a purchase order is created:

1. The system receives the request via API
2. An **orchestrator** coordinates the flow
3. Business rules are applied
4. The order is either approved or rejected based on budget validation

---

## 🏗️ Architecture

The project follows **Clean Architecture principles**, separating responsibilities into well-defined layers:

### 📂 Structure

* **Domain**

  * Entities
  * Value Objects
  * Business rules

* **Application**

  * Use Cases
  * DTOs (Data Transfer Objects)

* **Infrastructure**

  * Repository implementations
  * External integrations

* **Interfaces**

  * Controllers (API / Web)

---

### 🔁 Flow Example

```
Controller → Orchestrator → UseCase → Domain → Repository
```

This ensures:

* High maintainability
* Testability
* Clear separation of concerns

---

## 🔌 API

### ➕ Create Purchase Order

**Endpoint:**

```
POST /api/purchase-order/store
```

**Description:**
Creates a purchase order and validates it against the available budget.

**Flow:**

* Receives payload
* Sends to orchestrator
* Executes validation + creation
* Returns success or failure

---

## 🧪 Testing

The project includes automated tests for validating the purchase order flow.

### ▶️ Run specific test

Inside the container:

```
php artisan test tests/Feature/RegisterPurchaseOrderTest.php
```

---

## 🐳 Running the Project (Docker)

### 📦 Requirements

* Docker
* Docker Compose

---

### ▶️ Setup

```bash
git clone https://github.com/jonatasmcampos/vector.git
cd vector

docker compose up -d
```

---

### ⚙️ Initialize the project

After the containers are up:

```bash
docker exec -it vector bash
php artisan vector:atualizar
```

This command will:

* Run migrations
* Seed the database

---

## 🗄️ Database

The system uses **MySQL** as its primary database.

---

## 🧪 Test Data

A feature test is available to generate fake purchase orders and simulate real scenarios:

```
tests/Feature/RegisterPurchaseOrderTest.php
```

---

## 💡 Key Technical Highlights

* Clean Architecture implementation in Laravel
* Use of DTOs for data transport
* Value Objects to enforce domain rules
* Orchestrator pattern to coordinate use cases
* Repository pattern for data abstraction
* Docker-based environment
* Automated testing

---

## 📈 Future Improvements

* Payment module implementation
* Event-driven architecture (Kafka / queues)
* Token-based authentication (JWT / Sanctum)
* Improved logging and auditing
* API documentation (Swagger / OpenAPI)

---

## 👨‍💻 Author

Developed by **Jonatas Campos**

---

## ⭐ Final Notes

This project was designed not only to solve a business problem, but also to demonstrate strong knowledge of:

* Software architecture
* Scalable system design
* Backend best practices

---
