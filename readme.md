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

## 🎯 Who Is LiteERP Built For?

LiteERP is primarily designed for **retail and wholesale businesses** that need
a **clean, operational ERP core** without enterprise-level complexity.

Typical use cases include:
- Retail stores and chains
- Wholesale distributors
- Trading companies
- Import / export businesses
- SMEs managing inventory, orders, pricing, and customers

LiteERP focuses on **day-to-day operations**, such as:
- Product & inventory management
- Purchase & sales workflows
- Pricing rules and discounts
- Customer & supplier management
- Internal operational reporting

Industry-specific requirements — such as tax rules, accounting integration,
custom pricing logic, or workflow automation — are intentionally handled
through **extensions**, not hardcoded into the core.


# 🏢 LiteERP – A Pure Core ERP, Built for Extension, Not Complexity

LiteERP is an open-source ERP built with **ReactJS**, **Laravel**, and **MySQL 8**,  
designed as a **pure, minimal core** with an **unlimited extension model**.

Unlike traditional ERP systems such as **Odoo** or **SAP**, which bundle everything into a single, ever-growing core,  
LiteERP follows a fundamentally different philosophy:

> **Keep the core small, stable, and predictable —  
> push complexity outward into extensions.**

LiteERP is built on **Clean Architecture**, **Domain-Driven Design (DDD)**, and **Domain Events**,  
with extremely low framework coupling and long-term maintainability as first-class goals.

---

## ⚖️ LiteERP vs Odoo vs SAP

| Aspect | LiteERP | Odoo | SAP |
|------|--------|------|-----|
| Core size | **Small & pure** | Large, feature-heavy | Very large |
| Customization | Extensions & hooks | Core overrides & modules | Consultants & customization layers |
| Infrastructure | **Low-resource friendly** | Medium–High | High–Very High |
| Upgrade safety | **High** | Medium | Low–Medium |
| Target users | SMEs & developers | SMEs–Enterprises | Large enterprises |

Odoo and SAP aim to **cover every possible business scenario inside the core**.  
This makes them powerful, but also heavy, expensive, and difficult to evolve safely.

LiteERP deliberately chooses a different path.

---

## 🧠 A Pure and Minimal Core

LiteERP is built around a **small, clean, and stable core**.

The core intentionally focuses only on:
- Essential operational workflows
- Clear and predictable business rules
- Strong domain boundaries
- Long-term architectural stability

Instead of absorbing complexity,  
LiteERP treats **complexity as an external concern** handled by extensions.

This makes the core:
- Easy to understand  
- Safe to evolve  
- Fast to deploy  
- Suitable even for low-resource environments  

---

## 🧩 Extensions – Where Real Power Lives

All complex, domain-specific, and evolving business logic lives in **Extensions**.

Extensions are:
- Fully decoupled from the core
- Loaded dynamically only when needed
- Able to hook into domain events, validation, workflows, and APIs
- Safe to develop, replace, or remove without touching core logic

Through extensions, LiteERP can grow into:
- Industry-specific ERP systems
- Highly customized internal platforms
- Complex enterprise workflows — **without bloating the core**

**The extension system is the true engine of scalability in LiteERP.**

---

## 🚀 Built for Laravel Developers and SMEs

LiteERP opens a new path for:
- **Laravel developers** who want to build real ERP systems with clean architecture
- **SMEs** that need flexibility without enterprise-level complexity and cost

Developers can:
- Understand the core quickly
- Build extensions using familiar Laravel patterns
- Deliver complex ERP features incrementally and safely

Businesses can:
- Start with a clean operational core
- Enable only what they need
- Scale functionality as operations grow

---

## 📉 Lightweight by Design

LiteERP intentionally stays lightweight.

Compared to all-in-one ERP platforms like Odoo or SAP, this results in:
- Lower infrastructure costs
- Faster onboarding
- Easier customization
- Better long-term control over complexity

> LiteERP invoices are **operational invoices**, not tax invoices.  
> The system focuses on **operations**, not replacing accounting software  
> or government e-invoicing platforms.


---


## 🌐 Multi-language Support

LiteERP is built with **full multi-language support**, making it easy to use for teams across different regions.

### Supported languages
- 🇺🇸 **English**
- 🇯🇵 **Japanese (日本語)**
- 🇻🇳 **Vietnamese (Tiếng Việt)**


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

<a href="https://github.com/liteerp-oss/docs">Development document</a>

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
- **Multiple Language**

### ⏳ In Progress
- **Reports**

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
- [x] Multiple Language
- [x] Extensions

---

## 📄 Diagram Event 

I will continue update to easy to understand

https://drive.google.com/file/d/1acR1X12C4dLYNyK7w4grxWdTnfyswQDi/view?usp=sharing

--- 

## System Requirements & Build Notes

The source code currently supports **extensions** and **parallel builds using Node.js**.

During normal operation, memory usage is stable. However, in **some specific scenarios**—such as:

- Initial resource build
- Installing or updating extensions
- Rebuilding large assets in parallel

the build process may temporarily require **higher RAM usage**. This does **not happen frequently**, but it can occur at those critical moments.

### ⚠️ Server Requirement

To ensure the build process runs smoothly without unexpected failures, we **recommend a server with at least 4GB of RAM**.

This requirement helps:
- Prevent out-of-memory (OOM) errors during build
- Ensure stable parallel builds
- Improve reliability when working with extensions

> 💡 Note: Once the build process is completed, runtime memory usage is significantly lower.


---

## 📦 Setup by Docker 

Setup basic information for business, you need change information like business information working for. 

`APP_TIMEZONE="Asia/Ho_Chi_Minh"`

`APP_CURRENCY="USD"`

`APP_CURRENCY_LOCALE="en-US"` 

You also need config SMTP mail, timezone, pusher at `./app/.env` before start.

To config docker environment you can copy file `.env.example` at root folder and rename to `.env`

- First go to root folder and run `docker compose build && docker compose up -d` 
- Next login in to docker container `docker exec -it LiteERP-8.3 bash`
- Next run `composer install` 
- Next run `php artisan app:setup` 
- Next run `php artisan app:create-admin {email} {password} {name}` to create admin account
- At here system has been building for production, if you wanna continue development then run `npm run dev`, but you shuold exit docker container and run with OS Environment.

If you using for production then please change `ENV` at `.env` to value `production`.

Visit: http://localhost:8002/dashboard/login. 

To config all devices inernal using together, you need check current ip local of server and change `APP_URL` example: 

`APP_URL=http://192.168.1.2:8002`. Then all devices can access to this endpoint and use software. But don't forget devices shuold connect with one device router.

--- 

## 👨‍💻 Author
**Stevelee**  

LiteERP

## 📄 Contact

Contact email: hoang.le.tn91@gmail.com

## ❤️ Support LiteERP

If this project helps you, consider sponsoring via GitHub Sponsors.