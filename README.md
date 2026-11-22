<div align="center">

# SoloLedger

**Autonomous Back-Office, Invoicing & Financial Intelligence SaaS for Solo Digital Freelancers**

[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com/)
[![MySQL Version](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat-square&logo=alpine.js&logoColor=white)](https://alphinejs.dev/)
[![Architecture](https://img.shields.io/badge/Architecture-Modular_Monolith-10B981?style=flat-square)](#modular-architecture)
[![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)](LICENSE)

*Replace fragmented spreadsheets, manual payment chasing, and tax-season panic with an event-driven financial operating system built for independent developers, designers, and IT consultants.*

[Key Capabilities](#key-capabilities) • [Modular Architecture](#modular-architecture) • [Installation](#installation--setup) • [Configuration](#environment-configuration) • [Automation Engine](#automation--analytics-engine) • [License](#license)

</div>

---

## Overview

**SoloLedger** is a multi-tenant SaaS application engineered on a **Strict Modular Monolith** architecture using **Laravel 13** and **MySQL 8**. Designed specifically for solo digital freelancers and independent contractors, it bridges the gap between scope approval, time tracking, multi-currency billing, payment collection, automated follow-ups, and accountant-ready tax reporting.

Unlike traditional passive bookkeeping tools, SoloLedger features an **Event-Driven Automation Engine**, **Predictive 90-Day Cash-Flow Forecasting**, **Multi-SMTP Failover Routing**, and native **TDS/Withholding & Realized FX Gain/Loss** accounting.

---

## Key Capabilities

### Scope-to-Cash & Invoicing
- **Interactive Estimates & E-Signatures (`/e/{uuid}`):** Send proposals with client-selectable optional add-ons, capture typed or canvas e-signatures with IP/timestamp audit trails, and convert accepted quotes into deposit invoices in one click.
- **Change-Order Micro-Approvals:** Send 1-click approval links (`/approve/{uuid}`) for out-of-scope requests that automatically append to active project invoices.
- **Time-to-Invoice Roll-Up:** Built-in browser timer and manual project logs with one-click conversion of unbilled hours into itemized invoice line items.
- **Milestone & Recurring Billing:** Split projects into automated payment tranches (e.g., 40% upfront, 30% staging, 30% handover) or configure hands-free recurring retainer schedules.

### Frictionless Global Payments & Compliance
- **Direct Gateway Checkout (`/i/{uuid}`):** Accept cards, UPI, and bank transfers directly on public invoice pages via tenant-configured **Stripe**, **Razorpay**, or **PayPal** credentials with signature-verified webhook reconciliation.
- **Multi-Currency & Realized FX Tracking:** Issue invoices in USD, EUR, GBP, or any ISO currency while maintaining books in your base currency. Captures exchange rates at issuance and settlement to compute **Realized FX Gain/Loss** automatically.
- **TDS & Withholding Tax Ledger:** Separately tracks client-deducted withholding taxes (`tds_withheld_amount`) so invoices settled via `Cash + TDS` accurately close as `100% Paid`.
- **Export / LUT & Reverse-Charge Support:** One-click compliance toggles for zero-rated international service exports (GST LUT declarations, EU Reverse-Charge VAT notes).

### Autonomous Operations & Intelligence
- **Visual Rule-Based Automation Engine:** Build `Trigger → Condition → Action` workflows (e.g., *When Invoice is Overdue >= 3 days AND Amount > $500 → Send escalation email + Apply 2% late fee + Fire HMAC webhook*).
- **90-Day Cash-Flow Forecast & Tax Vault:** Projects 30/60/90-day inflows weighted by each client's historical payment velocity, while automatically calculating a dedicated tax reserve from net profits.
- **Client Reliability Scoring:** Automatically grades clients (`A` to `D`) based on on-time payment ratios and average days-to-pay.
- **Multi-Provider Mail Router & Failover:** Configure multiple outbound transports per tenant (**Custom SMTP, Amazon SES, Postmark, Resend, Mailgun**) with encrypted credentials, priority failover, daily rate-limit protection, and signed 1x1 open-tracking pixels.

### Expense Vault, Reconciliation & Portals
- **AI Receipt OCR & Email-to-Expense:** Upload receipt photos/PDFs or forward vendor invoices to your tenant alias (`receipts+{alias}@domain`) to extract vendor, date, tax, and amount via configurable OpenAI-compatible vision/LLM endpoints (supports local **Ollama** or cloud APIs).
- **Bank / UPI CSV Smart Reconciliation:** Fuzzy-matches uploaded bank statements against open invoices and logged expenses for rapid 1-click reconciliation.
- **Client Self-Service Hub (`/portal/{token}`):** Passwordless magic-link portal for repeat clients to view invoice history, download PDFs, and manage billing details.
- **Read-Only Accountant / CA Seat & Export Pack:** Invite external accountants with read-only access and generate one-click Fiscal Year ZIP packs (`invoices_summary.csv`, `expenses_ledger.csv`, `fx_and_tds_report.csv`, `profit_and_loss.pdf`).
- **White-Label Custom Domains:** Map custom CNAME domains (`billing.yourstudio.com`) to serve public invoices, estimates, and portals under your own brand identity.

---

## Modular Architecture

SoloLedger enforces strict domain boundaries inside `app/Modules/`. Each module encapsulates its own Models, Migrations, Actions, Services, Events, Listeners, Policies, Controllers, FormRequests, Routes, and Blade Views. Cross-module communication occurs exclusively via **Domain Events** or **Core Service Contracts**.

```text
app/
├── Core/                          # Shared Kernel (Multi-tenancy, Contracts, Base Concerns)
│   ├── Concerns/
│   │   └── BelongsToTenant.php    # Global Eloquent scope enforcing workspace isolation
│   ├── Contracts/                 # Cross-module interfaces (MailDispatcherContract, etc.)
│   ├── Middleware/
│   │   └── ResolveCustomDomain.php# CNAME white-label tenant resolver
│   └── Support/
│       └── CurrencyConverter.php  # Precision DECIMAL(10,6) FX calculation utilities
│
├── Modules/
│   ├── Identity/                  # Workspace settings, Tax/FX defaults, Accountant RBAC, Sanctum API
│   ├── Crm/                       # Clients, Projects, Client Portal (/portal/{token}), Reliability Scoring
│   ├── Estimates/                 # Quotes, Optional add-ons, E-Signatures (/e/{uuid}), Change-Orders
│   ├── TimeTracking/              # Live timer, Billable logs, Unbilled-hours-to-invoice roll-up
│   ├── Billing/                   # Invoices, Milestones, Recurring schedules, TDS, FX Gain/Loss
│   ├── Payments/                  # Stripe, Razorpay, PayPal drivers, Webhook handlers, Ledger entries
│   ├── Expenses/                  # Expense ledger, Private receipt vault, AI OCR, Email-to-Expense
│   ├── Communications/            # Multi-SMTP/API Mail Router, Failover engine, Open tracking
│   ├── Automation/                # Event-driven Rule Engine, HMAC Webhooks, WhatsApp/Telegram alerts
│   └── Analytics/                 # Dashboard KPIs, 90-Day Forecast, Tax Vault, CSV Reconciliation, CA Pack
│
└── Providers/
    └── ModuleServiceProvider.php  # Auto-registers module routes, migrations, views, and listeners
