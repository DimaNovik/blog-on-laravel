<template>
  <div id="app">

    <app-header></app-header>

    <transition appear name="fade" mode="out-in">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>

  import Header from '@/components/layouts/Header';

   export default {
     name: "app",
     components: {
       'app-header': Header,
     }
   }
</script>