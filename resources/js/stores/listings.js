import { defineStore } from 'pinia'

export const useListingsStore = defineStore('listings', {
    state: () => ({
        listings: [],
        isLoading: false,
        error: null,
        useServerFiltering: true,
        _debounceHandle: null,
        sort: '',
        pagination: {
            page: 1,
            perPage: 12,
            total: 0,
            lastPage: 1,
        },
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
            const params = { include: 'city', filter: {}, page: this.pagination.page, per_page: this.pagination.perPage }
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
        setPage(page) {
            this.pagination.page = Math.max(1, Number(page) || 1)
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
                if (Array.isArray(response.data?.data)) {
                    this.listings = response.data.data
                    const meta = response.data.meta || {}
                    this.pagination.total = Number(meta.total || 0)
                    this.pagination.lastPage = Number(meta.last_page || 1)
                    this.pagination.page = Number(meta.current_page || 1)
                } else {
                    this.listings = []
                    this.pagination.total = 0
                    this.pagination.lastPage = 1
                }
            } catch (e) {
                this.error = 'Kon aanbod niet laden.'
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


