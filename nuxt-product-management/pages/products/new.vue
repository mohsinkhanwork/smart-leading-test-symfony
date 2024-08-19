<template>
    <div class="container">
      <h1>Add New Product</h1>
      <form @submit.prevent="saveProduct">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" v-model="product.name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea v-model="product.description" id="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label for="price" class="form-label">Price</label>
          <input type="number" v-model="product.price" id="price" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="category" class="form-label">Category</label>
          <select v-model="product.category_id" id="category" class="form-select" required>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="type" class="form-label">Type</label>
          <select v-model="product.type_id" id="type" class="form-select" required>
            <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  
  const product = ref({
    name: '',
    description: '',
    price: null,
    category_id: null,
    type_id: null,
  });
  
  const categories = ref([]);
  const types = ref([]);
  const router = useRouter();
  
  onMounted(async () => {
    try {
      const categoriesResponse = await fetch('http://127.0.0.1:8000/api/category', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      });

      if (!categoriesResponse.ok) {
        throw new Error(`HTTP error! status: ${categoriesResponse.status}`);
      }

      categories.value = await categoriesResponse.json();

      const typesResponse = await fetch('http://127.0.0.1:8000/api/type', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      });

      if (!typesResponse.ok) {
        throw new Error(`HTTP error! status: ${typesResponse.status}`);
      }

      types.value = await typesResponse.json();

    } catch (error) {
      console.error("Error fetching categories and types:", error);
      alert("An error occurred while fetching the categories and types. Please try again.");
    }
  });
  
  async function saveProduct() {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/product/new', {
        method: 'POST',
        body: JSON.stringify(product.value),
        headers: {
          'Content-Type': 'application/json',
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      router.push('/products');
    } catch (error) {
      console.error("Error creating product:", error);
      alert("An error occurred while creating the product. Please try again.");
    }
  }

  </script>
  