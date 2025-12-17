# Contributing to LiteERP

Thank you for your interest in contributing to **LiteERP** 🎉

LiteERP is a **lightweight, practical, and extensible open-source ERP**, built for developers and small to medium-sized businesses.

---

## 📌 Project Goals

* **Readable – maintainable – extensible** code
* Follow **Clean Architecture** and Laravel best practices
* Focus on **stability and real-world use cases**, not unnecessary complexity

---

## 🧑‍💻 How You Can Contribute

You can help LiteERP in many ways:

* 🐛 Reporting bugs
* ✨ Proposing new features
* 📝 Improving documentation
* 🔧 Fixing bugs or refactoring code
* 🌐 Adding or improving translations

---

## 🐞 Bug Reports

When creating an **Issue**, please include:

* A clear description of the bug
* Steps to reproduce the issue
* Expected result vs actual result
* PHP / Laravel / Database version
* Screenshots or logs (if available)

👉 Please **search existing issues** before opening a new one.

---

## ✨ Feature Requests

LiteERP prioritizes:

* **Common, real-world ERP features**
* Features that do not bloat the architecture
* Reusable and extensible solutions

When proposing a feature, please describe:

* The problem you are facing
* Your proposed solution
* Why this feature should be part of LiteERP

---

## 🔀 Pull Request (PR) Guidelines

### 1. Fork & Branch

* Fork the repository
* Create a new branch from `main`

```bash
git checkout -b feature/your-feature-name
```

### 2. Coding Rules

* Follow **PSR-12** coding standards
* Do not commit unused or debug code
* Prefer **Service / UseCase** layers over putting logic in Controllers
* Avoid placing business logic directly in Models

### 3. Commit Messages

Use clear and meaningful messages:

```text
feat: add customer debt report
fix: resolve wrong total calculation
refactor: simplify report query
```

### 4. Testing

* Ensure existing features are not broken
* Add tests where possible

### 5. PR Description

A good PR should include:

* A short description of the changes
* Related issue(s), if any
* Screenshots or demo videos (for UI changes)

---

## 🏗️ Architecture & Principles

LiteERP applies:

* Clean Architecture (Domain / Application / Infrastructure)
* Repository Pattern
* Event / Listener for critical business workflows

⛔ Please avoid:

* Tight coupling
* Complex queries inside Controllers
* Hard-coded business logic

---

## 🌍 Internationalization

* Language files are located in `/core/{Module}/Infrastructure/lang`
* Config files are located in `/core/{Module}/Infrastructure/config`
* Do not hard-code text in backend or frontend

---

## 🤝 Code of Conduct

* Be respectful and inclusive
* Keep discussions constructive
* No toxic behavior or personal attacks

---

## ❤️ Thank You

Every contribution, big or small, is greatly appreciated.

If you like LiteERP, please ⭐ the repository to support the project!

Happy coding 🚀
