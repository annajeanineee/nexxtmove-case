import { ref } from 'vue';

const property = ref(null);
const loading = ref(false);
const error = ref(null);

const fetchPropertyDetails = async (id, t) => {
    try {
        loading.value = true;
        error.value = null;

        const response = await fetch(`/api/properties/${id}`);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        property.value = result.data;
    } catch (err) {
        error.value = $t('details_error');
        console.error('Error fetching property details:', err);
    } finally {
        loading.value = false;
    }
};

const resetPropertyDetail = () => {
    property.value = null;
    loading.value = false;
    error.value = null;
};

export default {
    property, loading, error, fetchPropertyDetails, resetPropertyDetail
};
