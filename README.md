# SchedulaPro

Sistema de agendamentos multi-tenant (por empresa) construído em Laravel.  
O objetivo do projeto é simular um produto real (SaaS) onde cada **Business** (empresa) gerencia seus **Services** (serviços) e **Appointments** (agendamentos).

## Status do Projeto
- ✅ Infraestrutura com Laravel Sail (Docker)
- ✅ Modelagem base: Businesses ↔ Users
- ✅ Modelagem de agenda: Services ↔ Appointments
- ⏳ Próximos passos: autenticação + CRUD + regras de conflito de horário

---

## Stack (Tecnologias)

**Stack** é o conjunto de tecnologias usadas no projeto.

- **PHP + Laravel**: framework principal para construir a aplicação web (rotas, controllers, validações, ORM).
- **Laravel Sail**: ambiente de desenvolvimento baseado em Docker (padroniza o setup, evita “na minha máquina funciona”).
- **Docker**: executa serviços (PHP, MySQL, etc.) em containers isolados.
- **MySQL**: banco de dados relacional.
- **Git + GitHub**: controle de versão, issues e PRs (fluxo similar a empresa).

---

## Requisitos
- Docker Desktop instalado e rodando
- WSL2 (para Windows)
- Git

---

## Como rodar localmente (Setup)

### 1) Clonar o repositório (SSH recomendado)
```bash
git clone git@github.com:freitastech/schedulapro.git
cd schedulapro
