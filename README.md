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

## 🛠️ Tech Stack

* **Backend:** PHP 8.2, Laravel 12
* **Frontend:** Bootstrap 5.3.8, DataTables 2.3.4, jQuery 3.7.1
* **Database:** MySQL
* **Environment:** Docker

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

## 🌐 Access the application

After the setup is complete, the application will be available at:
`http://localhost:8000/entrar`

---

### 🔐 Permissions

In some environments (especially when using Docker), it may be necessary to adjust folder permissions to allow Laravel to write logs and cache files.

Run the following command inside the container:

```
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

This ensures the application has the correct permissions to operate properly.

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

## 🧪 Testing & Sample Data

The project includes an automated test that not only validates the purchase order flow, but also generates sample data to simulate real-world scenarios.

This allows the system to be initialized with meaningful data, making it easier to explore and understand its behavior without starting from an empty state.

### ▶️ Run test and generate data

Inside the container:

```
php artisan test tests/Feature/RegisterPurchaseOrderTest.php
```

---

## 🗄️ Database

The system uses **MySQL** as its primary database.

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
