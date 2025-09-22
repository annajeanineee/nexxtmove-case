<template>
    <header class="bg-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Nexxtmove</span>
                    <img class="h-6 w-auto" src="https://nexxtmove.nl/wp-content/uploads/2022/01/logo-nexxtmove.svg" alt="" />
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = true">
                    <span class="sr-only">Open main menu</span>
                    <Bars3Icon class="size-6" aria-hidden="true" />
                </button>
            </div>
        </nav>
        <Dialog class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
            <div class="fixed inset-0 z-10" />
            <DialogPanel class="fixed inset-y-0 right-0 z-10 flex w-full flex-col justify-between overflow-y-auto bg-white sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <a href="#" class="-m-1.5 p-1.5">
                            <span class="sr-only">Your Company</span>
                            <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" />
                        </a>
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = false">
                            <span class="sr-only">Close menu</span>
                            <XMarkIcon class="size-6" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a v-for="item in products" :key="item.name" :href="item.href" class="group -mx-3 flex items-center gap-x-6 rounded-lg p-3 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">
                                    <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        <component :is="item.icon" class="size-6 text-gray-600 group-hover:text-indigo-600" aria-hidden="true" />
                                    </div>
                                    {{ item.name }}
                                </a>
                            </div>
                            <div class="space-y-2 py-6">
                                <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Features</a>
                                <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Marketplace</a>

                                <a v-for="item in company" :key="item.name" :href="item.href" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">{{ item.name }}</a>
                            </div>
                            <div class="py-6">
                                <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Log in</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sticky bottom-0 grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50 text-center">
                    <a v-for="item in callsToAction" :key="item.name" :href="item.href" class="p-3 text-base/7 font-semibold text-gray-900 hover:bg-gray-100">{{ item.name }}</a>
                </div>
            </DialogPanel>
        </Dialog>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon, ChartPieIcon, CursorArrowRaysIcon } from '@heroicons/vue/24/outline'

const products = [
    { name: 'Steden', description: 'Bekijk huizen in verschillende steden', href: '#', icon: ChartPieIcon },
    { name: 'Prijsklassen', description: 'Bekijk huizen in verschillende prijsklassen', href: '#', icon: CursorArrowRaysIcon },
]
const callsToAction = []
const company = [
    { name: 'About us', href: '#', description: 'Learn more about our company values and mission to empower others' },
    { name: 'Careers', href: '#', description: 'Looking for you next career opportunity? See all of our open positions' },
    {
        name: 'Support',
        href: '#',
        description: 'Get in touch with our dedicated support team or reach out on our community forums',
    },
    { name: 'Blog', href: '#', description: 'Read our latest announcements and get perspectives from our team' },
]

const mobileMenuOpen = ref(false)
</script>


