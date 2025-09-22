<template>
    <div class="bg-white">
        <AppHeader />
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <div class="px-2 sm:px-0 mb-6">
                <router-link to="/" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:bg-indigo-50">← Terug naar overzicht</router-link>
            </div>
            <div v-if="loading" class="text-gray-600">Laden...</div>
            <div v-if="error" class="text-red-600">{{ error }}</div>
            <div v-if="listing" class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <!-- Image gallery -->
                <TabGroup as="div" class="flex flex-col-reverse">
                    <!-- Image selector -->
                    <div class="mx-auto mt-6 hidden w-full max-w-2xl sm:block lg:max-w-none">
                        <TabList class="grid grid-cols-4 gap-6">
                            <Tab v-for="image in images" :key="image.id" class="relative flex h-24 cursor-pointer items-center justify-center rounded-md bg-white text-sm font-medium text-gray-900 uppercase hover:bg-gray-50 focus:ring-3 focus:ring-indigo-500/50 focus:ring-offset-4 focus:outline-hidden" v-slot="{ selected }">
                                <span class="sr-only">{{ image.name }}</span>
                                <span class="absolute inset-0 overflow-hidden rounded-md">
                  <img :src="image.src" alt="" class="size-full object-cover" />
                </span>
                                <span :class="[selected ? 'ring-indigo-500' : 'ring-transparent', 'pointer-events-none absolute inset-0 rounded-md ring-2 ring-offset-2']" aria-hidden="true" />
                            </Tab>
                        </TabList>
                    </div>

                    <TabPanels>
                        <TabPanel v-for="image in images" :key="image.id">
                            <img :src="image.src" :alt="image.alt" class="aspect-square w-full object-cover sm:rounded-lg" />
                        </TabPanel>
                    </TabPanels>
                </TabGroup>

                <!-- Product info -->
                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ listing.title }}</h1>
                    <div class="mt-2">
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium text-white" :class="statusClass(listing.status)">
                            {{ displayStatus(listing.status) }}
                        </span>
                    </div>

                    <div class="mt-3">
                        <h2 class="sr-only">Prijs</h2>
                        <p class="text-3xl tracking-tight text-gray-900">{{ priceDisplay }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ listing.address || (listing.city?.name ?? 'Onbekende stad') }}</p>
                    </div>

                    <div class="mt-6">
                        <h3 class="sr-only">Description</h3>

                        <div class="space-y-6 text-base text-gray-700" v-html="listing.description" />
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue'
import { onMounted, ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useListingsStore } from '../stores/listings.js'
import AppHeader from '../components/AppHeader.vue'

const route = useRoute()
const listingsStore = useListingsStore()
const loading = ref(false)
const error = ref(null)
const listing = ref(null)

const priceDisplay = computed(() => {
    if (!listing.value) return ''
    try {
        return new Intl.NumberFormat('nl-NL', { style: 'currency', currency: listing.value.price_currency, minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(listing.value.price)
    } catch (e) {
        return `${listing.value.price} ${listing.value.price_currency}`
    }
})

const images = computed(() => {
    if (!listing.value?.image_path) return []
    return [
        { id: 1, name: listing.value.title, src: listing.value.image_path, alt: listing.value.title },
    ]
})

onMounted(async () => {
    const id = route.params.id
    loading.value = true
    error.value = null
    const data = await listingsStore.fetchListingById(id, { include: 'city' })
    loading.value = false
    if (!data) {
        error.value = 'Niet gevonden'
        return
    }
    listing.value = data
})

function displayStatus(status) {
    if (!status) return 'Onbekend'
    switch (status) {
        case 'available':
            return 'Beschikbaar'
        case 'sold':
            return 'Verkocht'
        case 'pending':
            return 'Onder optie'
        default:
            return status
    }
}

function statusClass(status) {
    switch (status) {
        case 'available':
            return 'bg-green-600'
        case 'sold':
            return 'bg-gray-700'
        case 'pending':
            return 'bg-yellow-600'
        default:
            return 'bg-slate-600'
    }
}
</script>
