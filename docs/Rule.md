# Contribution Rules

These rules apply to **everyone**.  
They are **not optional**.

> LiteERP is governed by rules.  
> Without strict rules, the system will collapse like dominoes.

---

## 1. No Composer Updates

- **Do NOT modify `composer.json` or `composer.lock`**
- Updating dependencies can introduce unexpected breaking changes.
- If dependency updates cause issues, the **entire system may stop working**.

❌ Any PR that updates Composer files **will be reverted** unless explicitly approved by core maintainers.

---

## 2. Commit Discipline

- **Do NOT use `git add .`**
- Only stage files that are **directly related** to your change.
- Avoid committing:
  - unrelated files
  - formatting noise
  - accidental changes

> Small, focused commits are mandatory.

---

## 3. Code Comments & Language

- **English only** for:
  - code comments
  - commit messages
  - pull request descriptions

LiteERP is a global project.  
Using local languages makes the codebase hard to understand and maintain.

---

## 4. Core Modules Must Not Be Changed

- **Core modules are immutable**
- Respect the project philosophy: **“Simple and Pure”**
- All complexity must be implemented in **Extensions**

Use:
- Hooks
- Events

❌ Do NOT:
- add logic to core modules
- modify core workflows
- expand core responsibilities

> **Core is a stable contract, not a feature layer.**

---

## 5. Correct Way to Reuse Core Data

When you need data from a core module (e.g. user list):

✅ **Use the module `Service`**

❌ **Do NOT use:**
- `UseCase`  
  → UseCases coordinate business flows and may contain logic unrelated to your feature.
- `Model`  
  → Direct model access bypasses domain rules and invariants.

> The `Service` layer is the **only correct and stable entry point**.

### Read-only Joins

- You **may** join tables for **read-only queries**
- This must NOT:
  - modify data
  - bypass business rules
  - introduce write logic

---

## 6. Branch Rules

We use the following branch naming conventions:

- `extensions/your-feature-name`
- `features/your-feature-name`
- `devops/your-feature-name`

### Rules

- `extensions/*`  
  → For extension development (**recommended for contributors**)

- `features/*`  
  → **Core team only**

- `devops/*`  
  → **Core team only**, unless explicitly approved

❌ Unauthorized branches targeting core areas may be rejected.

---

## 7. Forking Is Encouraged

If you disagree with these rules:
- Fork the project
- Experiment freely

LiteERP is intentionally **opinionated**.

---

## Final Note

> **Rules protect the architecture.  
> Architecture protects the project.**

If rules are broken, contributions will be reverted — without debate.
