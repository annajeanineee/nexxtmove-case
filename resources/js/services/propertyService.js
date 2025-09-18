import { ref, computed } from 'vue';

const properties = ref([]);
const meta = ref([]);
const loading = ref(true);
const error = ref(null);
const currentPage = ref(1);

const filters = ref({
    city: '',
    priceRange: '',
    status: ''
});

const fetchProperties = async (page = 1) => {
    try {
        loading.value = true;
        currentPage.value = page;

        const params = new URLSearchParams();
        params.append('page', page);

        const response = await fetch(`/api/properties?${params.toString()}`);
        const data = await response.json();
        properties.value = data.data;
        meta.value = data.meta;
        loading.value = false;
    } catch (err) {
        error.value = $t('error_failed_properties');
        loading.value = false;
        console.error(err);
    }
};


const getCities = computed(() => {
    const uniqueCities = new Set(properties.value.map(property => property.city));
    return [...uniqueCities].sort();
});


const getFilteredProperties = computed(() => {
    return properties.value;
});


const applyFilters = async (page = 1) => {
    try {
        loading.value = true;
        currentPage.value = page;

        const params = new URLSearchParams();
        params.append('page', page);

        if (filters.value.city) {
            params.append('city', filters.value.city);
        }
        if (filters.value.status) {
            params.append('status', filters.value.status);
        }
        if (filters.value.priceRange) {
            const [min, max] = filters.value.priceRange.split('-').map(Number);
            if (min) params.append('price_min', min);
            if (max) params.append('price_max', max);
        }

        const response = await fetch(`/api/properties?${params.toString()}`);
        const data = await response.json();

        properties.value = data.data;
        meta.value = data.meta;

        loading.value = false;
    } catch (err) {
        error.value = $t('error_failed_filters');
        loading.value = false;
        console.error(err);
    }
};

const goToPage = (page) => {
    applyFilters(page);
};

const getPageNumbers = computed(() => {
    if (!meta.value || !meta.value.last_page) return [];

    const currentPageNum = meta.value.current_page;
    const lastPage = meta.value.last_page;

    let pages = [];

    if (lastPage <= 5) {
        for (let i = 1; i <= lastPage; i++) {
            pages.push(i);
        }
    } else {
        const startPage = Math.max(1, currentPageNum - 2);
        const endPage = Math.min(lastPage, startPage + 4);
        const adjustedStartPage = Math.max(1, endPage - 4);

        for (let i = adjustedStartPage; i <= endPage; i++) {
            pages.push(i);
        }
    }

    return pages;
});


export default {
    properties,
    loading,
    error,
    filters,
    meta,
    currentPage,
    fetchProperties,
    getCities,
    getFilteredProperties,
    applyFilters,
    goToPage,
    getPageNumbers
};
