<template>
  <div class="container">
    <h1>Product List</h1>
    <NuxtLink to="/products/new" class="btn btn-primary mb-3">Add New Product</NuxtLink>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Category</th>
          <th>Type</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.name }}</td>
          <td>{{ product.category?.name || 'N/A' }}</td>
          <td>{{ product.type?.name || 'N/A' }}</td>
          <td>{{ product.price }}</td>
          <td>
            <button class="btn btn-danger btn-sm" @click="confirmDelete(product.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

  
  <script setup>
  import { ref, onMounted } from 'vue';
  
  const products = ref([]);
  const productIdToDelete = ref(null);
  
  onMounted(async () => {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/product', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      products.value = await response.json();
    } catch (error) {
      console.error("Error fetching products:", error);
      alert("An error occurred while fetching the products. Please try again.");
    }
  });
  
  function confirmDelete(id) {
    productIdToDelete.value = id;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
  }
  
  async function deleteProduct() {
    await $fetch(`/api/product/${productIdToDelete.value}`, { method: 'DELETE' });
    products.value = products.value.filter(product => product.id !== productIdToDelete.value);
    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
    deleteModal.hide();
  }
  </script>
  