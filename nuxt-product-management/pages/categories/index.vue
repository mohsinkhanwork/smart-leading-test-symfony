<template>
  <div class="container">
    <h1>Category List</h1>
    <NuxtLink to="/categories/new" class="btn btn-primary mb-3">Add New Category</NuxtLink>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories" :key="category.id">
          <td>{{ category.id }}</td>
          <td>{{ category.name }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const categories = ref([]);

onMounted(async () => {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/category', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    categories.value = await response.json();
  } catch (error) {
    console.error("Error fetching categories:", error);
    alert("An error occurred while fetching the categories. Please try again.");
  }
});
</script>
