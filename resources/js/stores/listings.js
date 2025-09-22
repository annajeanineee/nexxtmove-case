import { defineStore } from 'pinia'

export const useListingsStore = defineStore('listings', {
    state: () => ({
        listings: [],
        isLoading: false,
        error: null,
        useServerFiltering: true,
        _debounceHandle: null,
        sort: '',
        filters: {
            city: '',
            status: '',
            priceMin: null,
            priceMax: null,
        },
    }),
    getters: {
        filteredListings(state) {
            if (state.useServerFiltering) {
                return state.listings
            }
            return state.listings.filter((item) => {
                const cityOk = state.filters.city
                    ? (item.city?.name || '').toLowerCase().includes(String(state.filters.city).toLowerCase())
                    : true
                const statusOk = state.filters.status
                    ? String(item.status) === String(state.filters.status)
                    : true
                const minOk = state.filters.priceMin != null
                    ? Number(item.price) >= Number(state.filters.priceMin)
                    : true
                const maxOk = state.filters.priceMax != null
                    ? Number(item.price) <= Number(state.filters.priceMax)
                    : true
                return cityOk && statusOk && minOk && maxOk
            })
        },
    },
    actions: {
        buildApiParams() {
            const params = { include: 'city', filter: {} }
            if (this.filters.city) params.filter.city = this.filters.city
            if (this.filters.status) params.filter.status = this.filters.status
            const hasMin = this.filters.priceMin != null && this.filters.priceMin !== ''
            const hasMax = this.filters.priceMax != null && this.filters.priceMax !== ''
            if (hasMin) params.filter.price_min = this.filters.priceMin
            if (hasMax) params.filter.price_max = this.filters.priceMax
            if (this.sort) params.sort = this.sort
            return params
        },
        setSort(sortValue) {
            this.sort = sortValue || ''
            return this.applyFiltersNow()
        },
        applyFiltersNow() {
            const params = this.buildApiParams()
            return this.fetchListings(params)
        },
        applyFiltersDebounced(delayMs = 350) {
            if (this._debounceHandle) {
                clearTimeout(this._debounceHandle)
            }
            this._debounceHandle = setTimeout(() => {
                this.applyFiltersNow()
            }, delayMs)
        },
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
        async fetchListingById(id, params = {}) {
            this.isLoading = true
            this.error = null
            try {
                const response = await window.axios.get(`/listings/${id}`, { params })
                return response.data?.data ?? null
            } catch (e) {
                this.error = 'Kon woningdetails niet laden.'
                return null
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


