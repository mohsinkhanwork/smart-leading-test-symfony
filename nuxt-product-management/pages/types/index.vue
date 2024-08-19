<template>
    <div class="container">
      <h1>Type List</h1>
      <NuxtLink to="/types/new" class="btn btn-primary mb-3">Add New Type</NuxtLink>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="type in types" :key="type.id">
            <td>{{ type.id }}</td>
            <td>{{ type.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  
  const types = ref([]);
  
  onMounted(async () => {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/type', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      types.value = await response.json();
    } catch (error) {
      console.error("Error fetching types:", error);
      alert("An error occurred while fetching the types. Please try again.");
    }
  });
  </script>
  