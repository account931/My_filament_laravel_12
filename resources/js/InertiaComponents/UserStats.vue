<!-- User Inertia component, users count -->
<template>
  <div class="stats-wrapper">

    <div class="stats-card">

      <h1 class="title">📊 Users Stats</h1>

      <div class="count-box">
        Total users:
        <span class="count">{{ count }}</span>
      </div>

      <Link href="/inertia/index" class="back-button">
        ← Back to users
      </Link>

    </div>

  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  count: Number
})
</script>

<style scoped>
/* Background same as users page */
.stats-wrapper {
  min-height: 100vh;
  padding: 30px;
  background: linear-gradient(135deg, #eef2ff, #fdf2f8);
  font-family: system-ui, sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Card like user cards */
.stats-card {
  background: white;
  padding: 40px;
  border-radius: 18px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  border-left: 6px solid #6366f1;
  text-align: center;
  min-width: 320px;
}

/* Title */
.title {
  font-size: 28px;
  font-weight: 800;
  margin-bottom: 20px;
  color: #111827;
}

/* Count styling */
.count-box {
  font-size: 18px;
  color: #6b7280;
  margin-bottom: 25px;
}

.count {
  font-size: 34px;
  font-weight: 900;
  color: #6366f1;
  display: block;
  margin-top: 8px;
}

/* Back button same style family */
.back-button {
  display: inline-block;
  padding: 10px 16px;
  background: linear-gradient(135deg, #6366f1, #818cf8);
  color: white;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.2s ease;
}

.back-button:hover {
  transform: translateY(-2px);
  background: linear-gradient(135deg, #4f46e5, #6366f1);
}
</style>