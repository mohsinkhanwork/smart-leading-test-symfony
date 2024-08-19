<template>
    <div class="container">
      <h1>Add New Type</h1>
      <form @submit.prevent="saveType">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" v-model="type.name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create Type</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  
  const type = ref({
    name: ''
  });
  
  const router = useRouter();
  
  async function saveType() {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/type/new', {
        method: 'POST',
        body: JSON.stringify(type.value),
        headers: {
          'Content-Type': 'application/json',
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      router.push('/types');
    } catch (error) {
      console.error("Error creating type:", error);
      alert("An error occurred while creating the type. Please try again.");
    }
  }
  </script>
  