<template>
  <main>
    <header>
      <h1>Woningoverzicht (case)</h1>
      <p class="muted">Jouw oplossing komt hier: lijst + filters + detail.</p>
    </header>

    <section>
      <div class="card">
        <p>API endpoint: <code>/api/properties</code> (nu dummy).</p>
        <p>Minimaal: lijst + filters (plaats, prijsklasse) + detail.</p>
      </div>
    </section>
  </main>
</template>

<script setup>
// Do the API call here to /api/properties to get the data
</script>

<style>
.muted { 
  opacity: .7 
}
.card {
  border: 1px solid #eee; 
  padding:1rem; 
  border-radius:12px 
}
</style>
