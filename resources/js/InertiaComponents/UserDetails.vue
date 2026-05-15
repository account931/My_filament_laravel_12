<!-- Inertia component, show 1 user details -->
<template>
  <div class="user-details-wrapper">

    <div class="user-card">

      <!-- Back button -->
      <Link
        href="/inertia/index"
        class="back-button"
      >
        ← Back to users
      </Link>

      <!-- User info -->
      <div class="user-name">
        👤 {{ user.name }}
      </div>

      <div class="user-email">
        📧 {{ user.email }}
      </div>

      <div class="user-date">
        🕒 {{ user.created_at }}
      </div>

      <!-- Roles -->
      <div class="section">
        <div class="section-title">Roles</div>

        <div v-if="user.roles?.length" class="badges">
          <span
            v-for="role in user.roles"
            :key="role.id"
            class="badge role"
          >
            🏷 {{ role.name }}
          </span>
        </div>

        <div v-else class="empty">
          ❌ No roles found
        </div>
      </div>

      <!-- Images -->
      <div class="section">
        <div class="section-title">Storage Images</div>

        <div
          v-if="user.supabase_storage_images?.length"
          class="badges"
        >
          <span
            v-for="image in user.supabase_storage_images"
            :key="image.id"
            class="badge image"
          >
            🖼 {{ image.path }}
          </span>
        </div>

        <div v-else class="empty">
          ❌ No images found
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'  // add Inertia Link
defineProps({
  user: Object
})
</script>


<style scoped>
.user-details-wrapper {
  padding: 30px;
  min-height: 100vh;
  background: linear-gradient(135deg, #eef2ff, #fdf2f8);
  font-family: system-ui, sans-serif;
}

/* Main card */
.user-card {
  background: white;
  border-radius: 18px;
  padding: 28px;
  max-width: 800px;
  margin: 0 auto;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  border-left: 6px solid #6366f1;
}

/* Back button */
.back-button {
  display: inline-block;
  margin-bottom: 22px;
  padding: 10px 16px;
  background: linear-gradient(135deg, #6366f1, #818cf8);
  color: white;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.2s ease;
}

.back-button:hover {
  transform: translateY(-2px);
  background: linear-gradient(135deg, #4f46e5, #6366f1);
}

/* Header */
.user-name {
  font-size: 32px;
  font-weight: 800;
  color: #111827;
  margin-bottom: 10px;
}

.user-email {
  color: #6366f1;
  font-size: 16px;
  margin-bottom: 8px;
}

.user-date {
  font-size: 13px;
  color: #9ca3af;
  margin-bottom: 24px;
}

/* Sections */
.section {
  margin-top: 22px;
}

.section-title {
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  color: #6b7280;
  margin-bottom: 10px;
  letter-spacing: 0.5px;
}

/* Badge container */
.badges {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

/* Base badge */
.badge {
  padding: 7px 12px;
  border-radius: 999px;
  font-size: 13px;
  font-weight: 600;
  display: inline-block;
}

/* Role badge */
.badge.role {
  background: linear-gradient(135deg, #3b82f6, #60a5fa);
  color: white;
}

/* Image badge */
.badge.image {
  background: linear-gradient(135deg, #ec4899, #f472b6);
  color: white;
  font-family: monospace;
}

/* Empty state */
.empty {
  color: #ef4444;
  font-style: italic;
  font-size: 13px;
}

</style>