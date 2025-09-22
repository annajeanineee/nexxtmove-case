<template>
    <div class="bg-white">
        <div class="pb-16 pt-6 sm:pt-10 sm:pb-24 lg:mx-auto lg:max-w-7xl lg:px-8">
            <div class="flex items-center justify-between px-4 sm:px-6 lg:px-0">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Actueel aanbod</h2>
            </div>

            <div class="px-4 sm:px-6 lg:px-0 mt-6">
                <div v-if="isLoading" class="text-gray-600">Laden...</div>
                <div v-else-if="error" class="text-red-600">{{ error }}</div>
            </div>

            <div v-if="!isLoading && !error" class="relative mt-4">
                <div class="relative -mb-6 w-full overflow-x-auto pb-6">
                    <ul role="list" class="mx-4 inline-flex space-x-8 sm:mx-6 lg:mx-0 lg:grid lg:grid-cols-4 lg:gap-x-8 lg:space-x-0">
                        <li v-for="listing in listings" :key="listing.id" class="inline-flex w-64 flex-col text-center lg:w-auto">
                            <div class="group relative">
                                <img :src="listing.image_path" :alt="listing.title" class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75" />
                                <div class="mt-6">
                                    <p class="text-sm text-gray-500">{{ listing.city?.name ?? 'Onbekende stad' }}</p>
                                    <h3 class="mt-1 font-semibold text-gray-900">
                                        <a :href="listing.url">
                                            <span class="absolute inset-0" />
                                            {{ listing.title }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-gray-900">{{ formatPrice(listing.price, listing.price_currency) }}</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </template>

<script setup>
import { onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useListingsStore } from '../stores/listings.js'

const listingsStore = useListingsStore()
const { listings, isLoading, error } = storeToRefs(listingsStore)

onMounted(async () => {
    if (listings.value.length === 0) {
        await listingsStore.fetchListings({ include: 'city' })
    }
})

function formatPrice(value, currency) {
    try {
        return new Intl.NumberFormat('nl-NL', { style: 'currency', currency }).format(value)
    } catch (e) {
        return `${value} ${currency}`
    }
}
</script>
