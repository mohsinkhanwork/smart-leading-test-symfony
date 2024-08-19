<template>
    <div class="container">
      <h1>Add New Category</h1>
      <form @submit.prevent="saveCategory">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" v-model="category.name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create Category</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';

  
  const category = ref({
    name: ''
  });
  
  const router = useRouter();

  async function saveCategory() {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/category/new', {
      method: 'POST',
      body: JSON.stringify(category.value),
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    router.push('/categories');
  } catch (error) {
    console.error("Error creating category:", error);
    alert("An error occurred while creating the category. Please try again.");
  }
}

  </script>
  