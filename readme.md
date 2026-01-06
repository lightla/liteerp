<p align="center">
  <img src="app/public/assets/logo-full.png" alt="LiteERP Logo" width="180" />
</p>

<h1 align="center">LiteERP</h1>

<p align="center">
  Lightweight Open-Source ERP for internal business use.
</p>

---

<p align="center">
  <img src="screenshoot2.png" alt="LiteERP Logo" />
</p>

---


# 🏢 LiteERP – A Pure Core with Unlimited Extensions

LiteERP is built with **ReactJS**, **Laravel**, and **MySQL 8**, following modern software architecture principles such as  
**Clean Architecture**, **Domain-Driven Design (DDD)**, and **Domain Events**.

The system is designed to be lightweight, scalable, and maintainable, with extremely low framework coupling.

---

## 🧠 A Pure and Minimal Core

LiteERP is built around a **small, clean, and pure core**.

The core intentionally focuses only on:
- Essential operational workflows
- Clear and predictable business rules
- Stability and long-term maintainability

Instead of trying to handle every possible business scenario,  
LiteERP keeps the core minimal and **treats complexity as an external concern**.

This approach makes the core:
- Easy to understand
- Safe to modify
- Fast to deploy
- Suitable even for low-resource environments

---

## 🧩 Extensions – Where Real Power Lives

All complex, domain-specific, and evolving business logic lives in **Extensions**.

Extensions are:
- Fully decoupled from the core
- Loaded dynamically only when needed
- Able to hook into domain events, validation, workflows, and APIs
- Safe to develop, replace, or remove without touching the core

Through extensions, LiteERP can grow into:
- Industry-specific ERP systems
- Highly customized internal platforms
- Complex enterprise-grade workflows

**The extension system is the true engine of scalability and flexibility in LiteERP.**

---

## 🚀 A New Path for PHP, Laravel Developers, and SMEs

LiteERP opens a new path for:
- **PHP and Laravel developers** who want to build real ERP systems using familiar tools
- **Small and Medium-sized Enterprises (SMEs)** that need flexible systems without the cost and complexity of traditional ERP platforms

Developers can:
- Understand the core in a short time
- Build powerful extensions with Laravel
- Incrementally deliver complex ERP solutions without risking system stability

Businesses can:
- Start small with a clean core
- Add only the features they need
- Scale functionality as their operations grow

---

## ⚖️ Lightweight by Design

Compared to all-in-one ERP platforms like Odoo, LiteERP intentionally stays lightweight.

This results in:
- Lower infrastructure costs
- Faster developer onboarding
- Easier customization
- Better long-term control over complexity

LiteERP invoices are **operational invoices**, not tax invoices.  
They are designed to manage sales, payments, and customers —  
not to replace accounting software or government e-invoicing systems.

---

## ✨ Philosophy

> **Keep the core pure.**  
> **Move complexity to extensions.**  
> **Scale functionality without scaling chaos.**


--- 

## What LiteERP is NOT

❌ Not an accounting software

❌ Not a tax-compliant invoicing system

❌ Not a replacement for government e-invoice providers

--- 


## Extensions

List extension example

<a href="https://github.com/steveleetn91/liteerp-extension-example">Extensions</a>


--- 

## 📦 Document 

<a href="./development.md">Development document</a>

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
- **Notification**
- **Overview Dashboard**
- **Employee Role** 
- **Storage**
- **Extension**

### ⏳ In Progress
- **Reports**
- **Multiple Language**

---

## 🧪 Testing
- **Global Testing**
- **Unit Tests**
- **Clean Code Standard (ReactJS & Laravel)**

---

## 🛠️ Technologies Used
- **ReactJS**
- **Laravel 12**
- **MySQL 8**
- **Clean Architecture**
- **Domain Driven Design**
- **Domain Events**
- **PHP 8.3 or greater than**

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
- Managed through middleware + Redux  

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
- [x] Notification Center  
- [ ] Reporting Engine  
- [x] Overview Dashboard  
- [ ] Extended test coverage  
- [x] Realtime event streaming (WebSocket)  
- [ ] Reports
- [ ] Multiple Language
- [x] Extensions

---

## 📄 Diagram Event 

I will continue update to easy to understand

https://drive.google.com/file/d/1acR1X12C4dLYNyK7w4grxWdTnfyswQDi/view?usp=sharing

--- 

## 📦 Setup by Docker 

Setup basic information for business, you need change information like business information working for. 

`APP_TIMEZONE="Asia/Ho_Chi_Minh"`

`APP_CURRENCY="USD"`

`APP_CURRENCY_LOCALE="en-US"` 

You also need config SMTP mail, timezone, pusher at `./app/.env` before start.

- First go to root folder and run `docker compose build && docker compose up -d` 
- Next login in to docker container `docker exec -it erpsoft-8.3 bash`
- Next run `composer install`, `cp -r ./.env.example .env`
- Next run `php artisan generate:key`
- Next run `php artisan migrate`
- Next run `php artisan storage:link`
- Next run `php artisan jwt:generate-keys` to generate private key and public key for Json Web Token
- Next run `php artisan app:create-admin {email} {password} {name}` to create admin account
- Next run `php artisan queue:work --queue=low,default,high`
- Next run `php artisan schedule:work`
- Last step exit docker container and go to `./app` and run `npm run dev` or `npm run build` for production.

Visit: http://localhost:8001/dashboard/login

Note: You can change password for mysql account at `docker-compose.yml` 

--- 

## 👨‍💻 Author
**Stevelee**  

LiteERP

## 📄 Contact

Contact email: hoang.le.tn91@gmail.com

## ❤️ Support LiteERP

If this project helps you, consider sponsoring via GitHub Sponsors.