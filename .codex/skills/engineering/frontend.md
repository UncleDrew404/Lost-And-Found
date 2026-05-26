# Frontend Engineering Skill

## Purpose
Define scalable, maintainable, responsive, and user-friendly frontend
development standards for modern Vue applications.

---

# Core Responsibilities

- Build responsive user interfaces
- Create reusable Vue components
- Manage frontend architecture
- Handle state management properly
- Integrate APIs efficiently
- Improve user experience
- Optimize frontend performance
- Maintain accessibility standards

---

# Preferred Stack

## Frontend Stack

- Framework: Vue 3
- Build Tool: Vite
- State Management: Pinia
- Styling: Tailwind CSS
- API Client: Axios / Fetch API
- Package Manager: npm

---

# Frontend Architecture Rules

Use modular frontend structure.

Example:

src/
├── components/
├── pages/
├── layouts/
├── router/
├── stores/
├── services/
├── composables/
├── utils/
├── types/
├── assets/
└── styles/

---

# Vue Component Rules

Prefer:
- Composition API
- reusable components
- single responsibility components

Avoid:
- massive component files
- duplicated UI logic
- deeply nested components

Preferred:
- `<script setup>`

Example:

```vue
<script setup>
</script>