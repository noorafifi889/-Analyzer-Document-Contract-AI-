# ⚖️ AI Contract & Document Analyzer

Welcome to the **AI Contract & Document Analyzer**—an intelligent, multi-industry platform designed to revolutionize how professionals interact with legal agreements, employment contracts, and business documentation. 

Instead of spending hours manually reading through dozens of complex pages, users—whether they are **HR Professionals, Lawyers, or Business Managers**—can simply upload their documents to instantly unlock actionable, AI-driven insights, assess structural risks, and converse directly with their files.

---

## 🌟 Developed By
* **Nour Al Afifi**
  * *Front-End & Full-Stack Developer*

---

## 🚀 The Core Vision

Reading contracts line-by-line is tedious and prone to human oversight. This platform bridges the gap between modern web architectures and cutting-edge Artificial Intelligence. It is tailor-made to handle various document types, from complex legal settlements and NDAs to company policies and **HR employment contracts**. By simplifying complex legal prose into clear, structured insights, it empowers teams to accelerate operational workflows and make data-backed decisions.

---

## ✨ Key Features

* **🧠 Multi-Industry AI Summarization:** Automatically extracts critical metadata tailored to your field—such as contract types (Employment, NDA, Vendor), involved parties, effective durations, and primary obligations.
* **🛡️ Automated Risk Assessment (Risk Score):** Analyzes document texts to calculate a custom risk percentage (0-100%). It categorizes documents into *Low, Medium, or High Risk* tiers, explicitly highlighting strict penalties, non-compete clauses, or automatic renewals.
* **💬 Interactive "Chat with Contract":** Features a context-aware AI chatbot. Users can ask natural language questions specific to their domain (e.g., **HR:** *"What is the probation period?"* or **Legal:** *"Is there an arbitration clause?"*).
* **📊 Professional PDF Export:** Generates highly polished executive PDF summaries compiling the risk analysis, key extracted clauses, and full user-AI conversation logs into a single, downloadable report.
* **👥 Dual-Role System & API:** Features an advanced Dashboard to manage private files grouped by department tags, and a comprehensive Admin Panel for system oversight, all accessible via a secure REST API.

---

## 🛠️ Technical Ecosystem

The architecture is engineered for performance, security, and smooth asynchronous execution:

| Layer | Technologies Used |
| :--- | :--- |
| **Backend Framework** | Laravel (PHP) & Composer |
| **Frontend UI** | Blade Templates & Tailwind CSS |
| **Authentication** | Laravel Breeze (Role-based: User / Admin) |
| **Database & Storage** | MySQL / MariaDB & Laravel Storage |
| **Async Background Processing** | Laravel Queues & Jobs (for seamless text extraction and AI parsing) |
| **AI Integration** | OpenAI API (or any compatible AI provider) |
| **API Layer** | REST API via Laravel Sanctum |
| **Document Processing** | PDF & DOCX Text Extraction engines |

---

## 🔒 Security & Privacy

* **Strict Isolation:** Users and departments only have access to their own uploaded files and historical analysis.
* **Secure API Endpoints:** Protected via token-based authentication using Laravel Sanctum.