<template>
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        <div class="-mt-px flex w-0 flex-1">
            <button type="button" @click="goPrev" :disabled="isFirstPage" class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium" :class="isFirstPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                <ArrowLongLeftIcon class="mr-3 size-5" :class="isFirstPage ? 'text-gray-300' : 'text-gray-400'" aria-hidden="true" />
                Vorige
            </button>
        </div>
        <div class="hidden md:-mt-px md:flex">
            <span class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500">Pagina {{ page }} van {{ lastPage }}</span>
        </div>
        <div class="-mt-px flex w-0 flex-1 justify-end">
            <button type="button" @click="goNext" :disabled="isLastPage" class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium" :class="isLastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                Volgende
                <ArrowLongRightIcon class="ml-3 size-5" :class="isLastPage ? 'text-gray-300' : 'text-gray-400'" aria-hidden="true" />
            </button>
        </div>
    </nav>
</template>

<script setup>
import { ArrowLongLeftIcon, ArrowLongRightIcon } from '@heroicons/vue/20/solid'
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import { useListingsStore } from '../stores/listings.js'

const listingsStore = useListingsStore()
const { pagination } = storeToRefs(listingsStore)

const page = computed(() => pagination.value.page)
const lastPage = computed(() => pagination.value.lastPage)
const isFirstPage = computed(() => page.value <= 1)
const isLastPage = computed(() => page.value >= lastPage.value)

function goPrev() {
    if (isFirstPage.value) return
    listingsStore.setPage(page.value - 1)
}

function goNext() {
    if (isLastPage.value) return
    listingsStore.setPage(page.value + 1)
}
</script>
