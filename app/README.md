# 🏢 ERP System – Clean Architecture & Domain Driven Design

This ERP system is built with **ReactJS**, **Laravel**, and **MySQL8**, following modern software architecture principles including **Clean Architecture**, **Domain-Driven Design (DDD)**, and **Domain Events**.  
The project is designed for scalability, multi-business support, maintainability, and high performance.

---

## 🚀 Features

### ✅ Completed Features
- **Purchase**
- **Invoice In**
- **Stock In**
- **Warehouse**
- **Product**
- **Product Category**
- **Customer**
- **Customer Group**
- **Inventory**
- **Order Shipping**
- **Shipping Provider**
- **Authentication**
- **Multiple Business**
- **Log**
- **Order**
- **Invoice Out**
- **Stock Out**

### ⏳ In Progress
- **Reports**
- **Notification**
- **Overview Dashboard**
- **Employee Role** 
- **Storage**

---

## 🧪 Testing
- **Global Testing**
- **Unit Tests**
- **Clean Code Standard (ReactJS & Laravel)**

---

## 🛠️ Technologies Used
- **ReactJS**
- **Laravel**
- **MySQL 8**
- **Clean Architecture**
- **Domain Driven Design**
- **Domain Events**

---

## 🏗️ System Architecture

### Clean Architecture Layers

```
/core
├── Domain
│   ├── Entities
│   ├── ValueObjects
│   ├── Events
│   ├── Services
│   └── Repository Interfaces
│
├── Application
│   ├── UseCases
│   ├── DTOs
│   └── Handlers
│
├── Infrastructure
│   ├── Persistence (Eloquent, DB)
│   ├── Event Handlers
│   ├── Providers
│
└── Resources
    └── js
        └── ReactJS UI
```

---

## 🧩 Domain Driven Design (DDD)

### Core Concepts
- **Entity** – domain objects with identity  
- **Value Object** – objects compared by value  
- **Aggregate & Aggregate Root** – consistent clusters of domain logic  
- **Domain Service** – domain logic not tied to a specific entity  
- **Repository Interface** – abstracted persistence  
- **Event** – communication between domain modules  

### Example Domain Events:
Event::dispatch("erp.user.create", $data);

Event::listener("erp.user.*", function(string $eventName, array $data));

---


## 🔄 Module Communication
Modules communicate via **Domain Events**, enabling:

- Loose coupling  
- High scalability  
- Easier testing  
- Event-driven workflow  


---

## 📦 Multiple Business Support
- A user can belong to multiple businesses  
- Each request is processed under the selected `current_business`  
- Fully isolated business data  
- Managed through middleware + storage + Redux  

---



## 🔐 Authentication
- JWT authentication  
- Refresh token  
- Multi-business session  
- Role & Permission per business  

---

## 📝 Coding Standards
- PSR-12 (Laravel)
- Event-driven communication
- Clear domain separation
- Consistent folder structure

---

## 🧭 Roadmap
- [ ] Notification Center  
- [ ] Reporting Engine  
- [ ] Overview Dashboard  
- [ ] Extended test coverage  
- [ ] Realtime event streaming (WebSocket)  

---

## 📄 License
This project uses a private license.  
All rights reserved.

---

## 👨‍💻 Author
**Stevelee**  

LiteERP

## 📄 Contact

Contact email: hoang.le.tn91@gmail.com