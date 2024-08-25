<template>
  <div class="flex items-center min-h-screen bg-zinc-900 flex-col pt-24">
    <h1 class="text-white font-bold text-4xl mb-4">Kanye Quotes</h1>
    <div class="w-full max-w-3xl p-4 text-center min-h-96">
      <!-- Loading Spinner -->
      <div v-if="loading" class="flex justify-center items-center h-96">
        <svg class="animate-spin h-12 w-12 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 1116 0 8 8 0 01-16 0zm0 0a8 8 0 1116 0 8 8 0 01-16 0z" />
        </svg>
      </div>

      <!-- Quotes Display -->
      <div v-else>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-1">
          <div v-for="quote in quotes" :key="quote" class="bg-white p-6 rounded-lg shadow-lg text-left hover:scale-105 transition-all hover:bg-slate-50">
            <p class="text-gray-800">"{{ quote }}"</p>
          </div>
        </div>
        <button @click="refreshQuotes" class="mt-6 block px-24 py-2 w-full bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
          Refresh Quotes
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      quotes: [],
      loading: true // Initialize loading state
    };
  },
  mounted() {
    this.fetchQuotes();
  },
  methods: {
    fetchQuotes() {
      this.loading = true; // Set loading to true before fetching
      axios.get('/api/quotes')
        .then(response => {
          this.quotes = response.data;
          this.loading = false; // Set loading to false after fetching
        })
        .catch(error => {
          console.error('There was an error fetching quotes:', error);
          this.loading = false; // Set loading to false even if there's an error
        });
    },
    refreshQuotes() {
      this.loading = true; // Set loading to true before fetching
      axios.get('/api/quotes/refresh')
        .then(response => {
          this.quotes = response.data;
          this.loading = false; // Set loading to false after fetching
        })
        .catch(error => {
          console.error('There was an error refreshing quotes:', error);
          this.loading = false; // Set loading to false even if there's an error
        });
    }
  }
};
</script>

<style scoped>
/* Tailwind CSS spinner */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

</style>
