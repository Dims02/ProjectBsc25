# ComplianceCheck – Cybersecurity Survey Platform

>This README was generated using copilot

**ComplianceCheck** is a web-based platform developed for the creation and management of cybersecurity compliance surveys. It enables organizations to assess their alignment with the European NIS2 Directive and the Portuguese National Cybersecurity Framework (QNRCS). The platform provides an intuitive interface for users to answer surveys and receive automated, level-based recommendations.

## 📌 Project Context

This project was developed as part of the Bachelor's Degree in Computer Engineering at the **University of Beira Interior**, under the course unit **Project**.

## 🎯 Objectives

- Create and manage compliance-focused surveys.
- Automatically generate personalized recommendations.
- Provide a secure and accessible system for users and administrators.
- Export results in both **PDF** and **JSON** formats.
- Ensure compliance with cybersecurity best practices.

## 🚀 Features

### Administrator Interface
- CRUD operations for surveys and questions
- Toggle survey visibility
- Manage user permissions
- Edit recommendations
- View dashboards and analytics

### User Interface
- View and complete surveys
- Navigate across survey sections
- Analyze responses with visual charts
- Export responses and recommendations

### Security
- JWT-based authentication
- Role-based access control
- SQL injection and XSS protection
- HTTPS and secure session management
- Cloudflare DDoS and bot mitigation

## 🧰 Technologies Used

| Category      | Stack                              |
|---------------|------------------------------------|
| Frontend      | HTML, Tailwind CSS                 |
| Backend       | PHP                                |
| Database      | MySQL                              |
| Server        | Apache (XAMPP for dev, Fedora for prod) |
| Security      | JWT, bcrypt, HTTPS, Cloudflare     |

## ⚙️ Development Environment

- **XAMPP** (Apache, MySQL, PHP, phpMyAdmin)
- **OpenSSL** for HTTPS
- **Firefox** for browser testing
- Hosted on **Okeanos** (EU IaaS cloud)

## 📂 Database Schema Overview

The platform uses a normalized relational schema with the following core tables:
- `users`
- `surveys`
- `question_groups`
- `questions`
- `options`
- `recommendations`
- `responses`

## 📈 Example Workflow

1. Admin creates a survey with multiple groups of questions.
2. User logs in and completes the survey.
3. Platform analyzes answers and provides:
   - Level of compliance (basic/intermediate/advanced)
   - Recommendations based on performance
4. User exports results to PDF or JSON.

## 🔐 Security Highlights

- Secure login and session handling using JWT
- Prepared SQL statements
- Encrypted password storage (bcrypt)
- HTTPS for all communication
- Cloudflare to mitigate bots, DoS and DDoS attacks

## 📄 License

This project is academic and developed as part of a final year course. Commercial use is prohibited without permission.

---

