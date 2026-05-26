# Database Engineering Skill

## Purpose
Define scalable, secure, maintainable, and high-performance database standards
for backend systems.

---

# Core Responsibilities

- Design normalized database structures
- Maintain relational integrity
- Optimize database performance
- Manage migrations safely
- Prevent data inconsistency
- Support scalable backend architecture
- Ensure database security
- Maintain clean schema organization

---

# Preferred Stack

## Database System

- Database: MySQL
- ORM: Eloquent ORM
- Migration System: Laravel Migrations
- Seeder System: Laravel Seeders

---

# Database Design Rules

## Naming Conventions

Use:
- snake_case for tables
- snake_case for columns
- plural table names

GOOD:
- users
- user_profiles
- order_items

BAD:
- UserTable
- userProfile
- ORDERITEMS

---

# Primary Key Rules

Use:
- id as primary key

Example:

- id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY

---

# Foreign Key Rules

Always:
- define foreign key relationships
- enforce referential integrity

Example:
- user_id
- product_id
- category_id

Use:
- constrained()
- cascadeOnDelete()

When appropriate.

---

# Timestamp Standards

Required:
- created_at
- updated_at

Optional:
- deleted_at for soft deletes

Use:
- Laravel timestamps()

---

# Normalization Rules

Prefer:
- normalized database structure
- reusable relational tables
- minimal data duplication

Avoid:
- repeated data storage
- unnecessary JSON columns
- oversized tables

---

# Relationship Standards

Use proper relationships:

- One-to-One
- One-to-Many
- Many-to-Many

Examples:

User
    ↓
Posts

Product
    ↓
Categories

---

# Migration Rules

Always:
- use migrations
- make migrations reversible
- separate schema changes clearly

Never:
- edit old production migrations
- modify production data manually

Preferred:
- one responsibility per migration

---

# Seeder Rules

Use seeders for:
- development data
- testing data
- demo environments

Never:
- seed sensitive production data

---

# Indexing Rules

Add indexes for:
- foreign keys
- frequently searched columns
- authentication lookups
- sorting/filtering columns

Examples:
- email
- user_id
- created_at

Avoid:
- excessive indexing
- indexing low-value columns

---

# Query Optimization Rules

Optimize:
- N+1 queries
- unnecessary joins
- large payload retrieval
- repeated database calls

Use:
- eager loading
- pagination
- query limits
- selective columns

Example:

BAD:
- SELECT *

GOOD:
- select('id', 'name', 'email')

---

# Transaction Rules

Use database transactions for:
- payment systems
- inventory updates
- multi-table operations
- critical business logic

Always:
- rollback on failure
- preserve consistency

---

# Soft Delete Rules

Use soft deletes when:
- audit recovery is needed
- records may be restored

Avoid soft deletes for:
- temporary tables
- logs
- pivot tables

---

# Security Rules

Always:
- validate inputs
- sanitize user data
- use ORM protections
- prevent SQL injection

Never:
- trust raw user input
- expose database credentials
- commit .env files

---

# Backup & Recovery Rules

Required:
- regular automated backups
- backup verification
- disaster recovery plan

Recommended:
- daily backups
- encrypted storage

---

# Performance Rules

Monitor:
- slow queries
- query execution time
- index usage
- connection count

Use:
- caching when necessary
- optimized relationships
- efficient pagination

Avoid:
- excessive eager loading
- large unfiltered queries

---

# AI Agent Instructions

Before database changes:
1. Review existing schema
2. Check relationships
3. Validate migration impact
4. Consider backward compatibility

Before finishing:
1. Test migrations
2. Verify indexes
3. Validate relationships
4. Review query performance

Never:
- drop critical tables without confirmation
- introduce breaking schema changes silently
- duplicate relational structures