<template>
    <div class="container">
      <h1>Welcome to Product Management</h1>
      <div class="row mt-4">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Products</h5>
              <p class="card-text">Manage all your products here.</p>
              <NuxtLink to="/products" class="btn btn-primary">Go to Products</NuxtLink>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Categories</h5>
              <p class="card-text">Manage all your categories here.</p>
              <!-- Update the link when you have a categories page -->
              <NuxtLink to="/categories" class="btn btn-secondary" disabled>Go to Categories</NuxtLink>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Types</h5>
              <p class="card-text">Manage all your types here.</p>
              <!-- Update the link when you have a types page -->
              <NuxtLink to="/types" class="btn btn-secondary" disabled>Go to Types</NuxtLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  </script>
  