<!-- User Inertia component -->
<template>
  <div class="users-wrapper">
    <h1 class="title">👥 Users Dashboard</h1>

    <ul class="user-list">
      <li v-for="user in users" :key="user.id" class="user-card">

        <!-- Header, User info-->
        <div class="user-header">
          <div class="user-name">👤 {{ user.name }}</div>
          <div class="user-email">📧 {{ user.email }}</div>
          <div class="user-date">🕒 {{ user.created_at }}</div>
        </div>

        <!-- Roles realtion  -->
        <div v-if="user.roles?.length" class="section">
          <div class="label">Roles</div>
          <div class="badges">
            <span v-for="role in user.roles" :key="role.id" class="badge role">
              🏷 {{ role.name }}
            </span>
          </div>
        </div>

        <!-- Supabase Images relation  -->
        <div v-if="user.supabase_storage_images?.length" class="section">
          <div class="label">Storage Images</div>
          <div class="badges">
            <span
              v-for="image in user.supabase_storage_images"
              :key="image.id"
              class="badge image"
            >
              🖼 {{ image.path }}
            </span>
          </div>
        </div>

        <div v-else class="empty">
          ❌ No images found
        </div>

      </li>
    </ul>
  </div>
</template>

<script setup>
const props = defineProps({
  users: Array
})

console.log("Inertia")
console.log(props.users)
</script>

<style scoped>
.users-wrapper {
  padding: 30px;
  background: linear-gradient(135deg, #eef2ff, #fdf2f8);
  min-height: 100vh;
  font-family: system-ui, sans-serif;
}

.title {
  font-size: 30px;
  font-weight: bold;
  margin-bottom: 20px;
  color: #1f2937;
}

/* Grid layout */
.user-list {
  list-style: none;
  padding: 0;
  display: grid;
  gap: 18px;
}

/* Card */
.user-card {
  background: white;
  border-radius: 16px;
  padding: 18px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  border-left: 6px solid #6366f1;
  transition: transform 0.2s ease;
}

.user-card:hover {
  transform: translateY(-4px);
}

/* Header */
.user-name {
  font-size: 18px;
  font-weight: 700;
  color: #111827;
}

.user-email {
  color: #6366f1;
  font-size: 14px;
}

.user-date {
  font-size: 12px;
  color: #9ca3af;
}

/* Sections */
.section {
  margin-top: 12px;
}

.label {
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  color: #6b7280;
  margin-bottom: 6px;
}

/* Badges */
.badges {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}

/* Base badge */
.badge {
  padding: 5px 10px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 500;
  display: inline-block;
}

/* Role badge (blue) */
.badge.role {
  background: linear-gradient(135deg, #3b82f6, #60a5fa);
  color: white;
}

/* Image badge (pink/purple) */
.badge.image {
  background: linear-gradient(135deg, #ec4899, #f472b6);
  color: white;
  font-family: monospace;
}

/* Empty state */
.empty {
  margin-top: 10px;
  font-size: 12px;
  color: #ef4444;
  font-style: italic;
}
</style>