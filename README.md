# SchedulaPro

Sistema de agendamentos **multi-tenant (por empresa)** construído em **Laravel**.

O objetivo do projeto é simular um produto real (**SaaS**), onde cada **Business** (empresa) gerencia seus **Services** (serviços) e **Appointments** (agendamentos).

---

## 📌 Status do Projeto

- ✅ Infraestrutura com Laravel Sail (Docker)
- ✅ Modelagem base: Businesses ↔ Users
- ✅ Modelagem de agenda: Services ↔ Appointments
- ⏳ Próximos passos: autenticação + CRUD + regras de conflito de horário

---

## 🛠 Stack (Tecnologias)

**Stack** é o conjunto de tecnologias usadas no projeto.

- **PHP + Laravel**  
  Framework principal para construir a aplicação web (rotas, controllers, validações, ORM).

- **Laravel Sail**  
  Ambiente de desenvolvimento baseado em Docker (padroniza o setup, evita “na minha máquina funciona”).

- **Docker**  
  Executa serviços (PHP, MySQL, etc.) em containers isolados.

- **MySQL**  
  Banco de dados relacional.

- **Git + GitHub**  
  Controle de versão, issues e PRs (fluxo similar ao de uma empresa).

---

## 📋 Requisitos

- Docker Desktop instalado e rodando  
- WSL2 (para Windows)  
- Git  

---

## ▶️ Como rodar localmente (Setup)

### 1️⃣ Clonar o repositório (SSH recomendado)

```bash
git clone git@github.com:freitastech/schedulapro.git
cd schedulapro
```

### 2️⃣ Subir os containers

```bash
./vendor/bin/sail up -d
```

### 3️⃣ Configurar a aplicação

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
```

### 4️⃣ Acessar no navegador

http://localhost

---

## ⚙️ Comandos Úteis

### Parar containers
```bash
./vendor/bin/sail down
```

### Recriar o banco do zero
```bash
./vendor/bin/sail artisan migrate:fresh
```

### Ver status das migrations
```bash
./vendor/bin/sail artisan migrate:status
```

### Abrir Tinker (REPL do Laravel)
```bash
./vendor/bin/sail artisan tinker
```

---

## 🗄 Modelagem de Dados (Resumo)

### Entidades

- **businesses**  
  Empresas/estabelecimentos (ex.: salão, clínica)

- **users**  
  Usuários (`admin`, `staff`, `client`)

- **services**  
  Serviços oferecidos por uma empresa

- **appointments**  
  Agendamentos (serviço + data/hora + participantes)

### Relacionamentos

- Business **1:N** Users  
- Business **1:N** Services  
- Business **1:N** Appointments  
- Service **1:N** Appointments  
- Appointment **belongsTo** User (`client_id`)  
- Appointment **belongsTo** User (`staff_id`, nullable)

### Observações Técnicas

- `price_cents` armazena valor em centavos (evita erro de arredondamento com `float`)
- `start_at` e `end_at` são `datetime`
- `appointments` possui índices para consultas de agenda por empresa, staff e cliente

---

## 🔁 Fluxo de Trabalho (Padrão Empresa)

### Branch Naming

- `feat/...` → novas funcionalidades  
- `fix/...` → correções  
- `docs/...` → documentação  

**Exemplo:**
```text
feat/s1-03-services-appointments
```

### Pull Requests

- Toda mudança deve passar por PR
- O PR deve referenciar a Issue correspondente:

```text
Closes #X
```

### Commits (Padrão Sugerido)

- `feat: ...`
- `fix: ...`
- `docs: ...`
- `chore: ...`

---

## 🗺 Roadmap (Próximas Issues)

- Autenticação e autorização (roles: `admin`, `staff`, `client`)
- CRUD de Services
- CRUD de Appointments
- Regra de conflito de horário  
  (não permitir dois agendamentos no mesmo período para o mesmo staff)
- Deploy (ex.: VPS/DigitalOcean + Nginx + MySQL)

---

## 📄 Licença

Este projeto é **educacional / portfólio**.