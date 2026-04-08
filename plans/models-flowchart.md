# Lost & Found — Models Flowchart & Entity Relationships

## 1. Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS {
        int id PK
        string email UK
        timestamp email_verified_at
        string password
        tinyint status "0 = inactive, 1 = active"
        string remember_token
        timestamps created_at
        timestamps updated_at
    }

    USER_PROFILES {
        bigint id PK
        int user_id FK
        string first_name
        string middle_name
        string last_name
        string gender
        string phone_number
        text bio
        string avatar
        string department
        string student_id
        timestamps created_at
        timestamps updated_at
    }

    CATEGORIES {
        bigint id PK
        string name
        string type UK
        timestamps created_at
        timestamps updated_at
    }

    ITEMS {
        bigint id PK
        int user_id FK
        bigint category_id FK
        string title
        text description
        enum type "lost | found"
        enum status "active | resolved"
        string location
        datetime date_occured
        string contact_info
        string image_path
        timestamps created_at
        timestamps updated_at
    }

    ITEM_IMAGES {
        bigint id PK
        bigint item_id FK
        string image_path
        int sort_order "default 0"
        timestamps created_at
        timestamps updated_at
    }

    CLAIMS {
        bigint id PK
        bigint item_id FK
        int user_id FK
        text mesage
        enum status "pending | approved | rejected"
        timestamps created_at
        timestamps updated_at
    }

    USERS ||--o| USER_PROFILES : "has one"
    USERS ||--o{ ITEMS : "reports many"
    USERS ||--o{ CLAIMS : "submits many"
    CATEGORIES ||--o{ ITEMS : "classifies many"
    ITEMS ||--o{ ITEM_IMAGES : "has many"
    ITEMS ||--o{ CLAIMS : "receives many"
```

---

## 2. Model Relationship Flow

```mermaid
flowchart TD
    U[User] -->|hasOne| UP[UserProfile]
    UP -->|belongsTo| U

    U -->|hasMany| I[Item]
    I -->|belongsTo| U

    C[Category] -->|hasMany| I
    I -->|belongsTo| C

    I -->|hasMany| II[ItemImage]
    II -->|belongsTo| I

    I -->|hasMany| CL[Claim]
    CL -->|belongsTo| I

    U -->|hasMany| CL
    CL -->|belongsTo| U
```

---

## 3. User Flow — Reporting a Lost/Found Item

```mermaid
flowchart TD
    A[User Registers / Logs In] --> B[Complete User Profile]
    B --> C{Report Item?}
    C -->|Lost Item| D[Fill Lost Item Form]
    C -->|Found Item| E[Fill Found Item Form]
    D --> F[Select Category]
    E --> F
    F --> G[Enter Title, Description, Location, Date, Contact Info]
    G --> H[Upload Images]
    H --> I[Item Created - Status: active]
    I --> J[Item Visible on Platform]
```

---

## 4. User Flow — Claiming an Item

```mermaid
flowchart TD
    A[User Browses Items] --> B[Views Item Details]
    B --> C{Want to Claim?}
    C -->|Yes| D[Submit Claim with Message]
    D --> E[Claim Created - Status: pending]
    E --> F[Item Owner Gets Notified]
    F --> G{Owner Reviews Claim}
    G -->|Approve| H[Claim Status: approved]
    G -->|Reject| I[Claim Status: rejected]
    H --> J[Item Status: resolved]
    I --> K[Claimant Notified of Rejection]
```

---

## 5. Models Status Overview

| Model | File Exists? | Relationships Defined? | Notes |
|-------|-------------|----------------------|-------|
| **User** | ✅ | `hasOne` UserProfile | Typo in method name: `useProfiles` should be `userProfile` |
| **UserProfile** | ✅ | `belongsTo` User | All fields nullable for progressive profile completion |
| **Categories** | ✅ | None defined yet | Missing `hasMany` Items relationship |
| **Item** | ❌ Not created | N/A | Migration exists but Model class is missing |
| **ItemImage** | ❌ Not created | N/A | Migration exists but Model class is missing |
| **Claim** | ❌ Not created | N/A | Migration exists but Model class is missing |

---

## 6. Observations & Issues Found

1. **Missing Model classes** — `Item`, `ItemImage`, and `Claim` models have migrations but no corresponding Eloquent Model files in `app/Models/`.
2. **Typo in User model** — [`useProfiles()`](Backend/app/Models/User.php:34) should likely be `userProfile()` or `profile()`.
3. **Missing relationships on Categories** — [`Categories`](Backend/app/Models/Categories.php) model has no `hasMany` relationship to Items.
4. **Column typo in claims migration** — [`mesage`](Backend/database/migrations/2026_04_04_160509_claims_table.php:15) should be `message`.
5. **Unnecessary trait on Categories** — [`Notifiable`](Backend/app/Models/Categories.php:7) trait is used on Categories, which is typically only needed for models that receive notifications like User.
6. **PK type mismatch** — Users table uses `$table->increments('id')` which is `unsignedInteger`, while Items/Claims reference `user_id` with `unsignedInteger` — this is consistent. However, Categories uses `$table->id()` which is `unsignedBigInteger`, and Items references `category_id` as `unsignedBigInteger` — also consistent. Just be aware of the mixed PK strategy.
