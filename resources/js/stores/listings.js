import { defineStore } from 'pinia'

export const useListingsStore = defineStore('listings', {
    state: () => ({
        listings: [],
        isLoading: false,
        error: null,
    }),
    actions: {
        async fetchListings(params = {}) {
            this.isLoading = true
            this.error = null
            try {
                const response = await window.axios.get('/listings', { params })
                // Laravel resource collections respond with { data: [...] }
                this.listings = Array.isArray(response.data?.data) ? response.data.data : []
            } catch (e) {
                this.error = 'Kon aanbod niet laden.'
                // Optionally log for debugging
                // console.error(e)
            } finally {
                this.isLoading = false
            }
        },
        clear() {
            this.listings = []
            this.error = null
            this.isLoading = false
        }
    }
})


