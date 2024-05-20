<template>
  <div id="app">
    <header>
      <h1 class="heading-1">To do list</h1>
    </header>
    <TaskList/>
    <footer>
      <p class="copyright"></p>
    </footer>
  </div>
</template>

<script setup>
import TaskList from './TaskList.vue';
</script>