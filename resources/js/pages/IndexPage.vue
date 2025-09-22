<template>
    <AppHeader />
    <Filters />
    <ListingContainer />
</template>

<script setup>
import { ref } from 'vue'
import ListingContainer from "../components/ListingContainer.vue";
import Filters from "../components/Filters.vue";
import AppHeader from "../components/AppHeader.vue";

const mobileMenuOpen = ref(false)
</script>
