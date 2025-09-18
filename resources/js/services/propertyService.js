import { ref, computed } from 'vue';

const properties = ref([]);
const meta = ref([]);
const loading = ref(true);
const error = ref(null);

const filters = ref({
    city: '',
    priceRange: '',
    status: ''
});

const fetchProperties = async () => {
    try {
        loading.value = true;
        const response = await fetch('/api/properties');
        const data = await response.json();
        properties.value = data.data;
        meta.value = data.meta
        loading.value = false;
    } catch (err) {
        error.value = 'Failed to load properties. Please try again later.';
        loading.value = false;
        console.error(err);
    }
};


const getCities = computed(() => {
    const uniqueCities = new Set(properties.value.map(property => property.city));
    return [...uniqueCities].sort();
});

const getFilteredProperties = computed(() => {
    return properties.value.filter(property => {
        // Filter by city
        if (filters.value.city && property.city !== filters.value.city) {
            return false;
        }

        // Filter by price range
        if (filters.value.priceRange) {
            const [min, max] = filters.value.priceRange.split('-').map(Number);
            if (min && property.price < min) return false;
            if (max && property.price > max) return false;
        }

        // Filter by status
        if (filters.value.status && property.status !== filters.value.status) {
            return false;
        }

        return true;
    });
});

// Function to apply filters (can be expanded later)
const applyFilters = () => {
    console.log('Filters applied:', filters.value);
};

export default {
    properties,
    loading,
    error,
    filters,
    meta,
    fetchProperties,
    getCities,
    getFilteredProperties,
    applyFilters
};
