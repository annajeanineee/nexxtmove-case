<template>
    <div class="app-container">
        <SideMenu />
        <main class="content">
            <header>
                <h1>{{ $t('properties_title') }}</h1>
            </header>

            <PropertyDetail :property-id="selectedPropertyId" :is-visible="isDetailVisible" @close="closePropertyDetail"/>

             <section>
                <div class="card filters">
                    <div class="filter-group">
                        <label for="city">{{ $t('filters_city') }}</label>
                        <select id="city" v-model="filters.city">
                            <option value="">{{ $t('filters_all') }}</option>
                            <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="price">{{ $t('filters_price') }}</label>
                        <select id="price" v-model="filters.priceRange">
                            <option value="">{{ $t('filters_all') }}</option>
                            <option value="0-200000">€0 - €200,000</option>
                            <option value="200000-400000">€200,000 - €400,000</option>
                            <option value="400000-600000">€400,000 - €600,000</option>
                            <option value="600000-">€600,000+</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="status">{{ $t('filters_status') }}</label>
                        <select id="status" v-model="filters.status">
                            <option value="">{{ $t('filters_all') }}</option>
                            <option value="available">{{ $t('status_available') }}</option>
                            <option value="under_offer">{{ $t('status_under_offer') }}</option>
                            <option value="sold">{{ $t('status_sold') }}</option>
                            <option value="rented">{{ $t('status_rented') }}</option>
                        </select>
                    </div>

                    <button class="btn" @click="applyFilters(1)">
                        {{ $t('filters_apply') }}
                    </button>
                </div>

                <div v-if="loading" class="loading">
                    Loading...
                </div>
                <div v-else-if="error" class="error">
                    {{ error }}
                </div>
                <div v-else>
                    <div class="dataCount">
                        {{ $t('properties_total') }}: {{ meta.total }}
                    </div>
                    <div class="properties-grid">
                        <div v-for="property in filteredProperties" :key="property.id" class="property-card">
                            <h3>{{ property.address }}</h3>
                            <p class="city">{{ property.city }}</p>
                            <p class="price">€{{ property.price.toLocaleString() }}</p>
                            <p class="details">
                                <span>{{ property.bedrooms }} {{ $t('properties_beds') }}</span> |
                                <span>{{ property.bathrooms }} {{ $t('properties_baths') }}</span>
                                <span v-if="property.balcony"> | {{ $t('properties_balcony') }}</span>
                                <span v-if="property.garden"> | {{ $t('properties_garden') }}</span>
                            </p>
                            <p :class="['status', property.status]">{{ $t(`status_${property.status}`) }}</p>
                            <button class="btn view-details" @click="openPropertyDetail(property.id)">
                                {{ $t('details_view') }}
                            </button>
                        </div>
                    </div>

                    <div v-if="meta.last_page > 1" class="pagination">
                        <button
                            class="pagination-arrow"
                            :disabled="meta.current_page === 1"
                            @click="goToPage(meta.current_page - 1)"
                            aria-label="Previous page"
                        >
                            &larr;
                        </button>

                        <div class="pagination-numbers">
                            <button
                                v-for="page in pageNumbers"
                                :key="page"
                                :class="['pagination-number', { active: meta.current_page === page }]"
                                @click="goToPage(page)"
                            >
                                {{ page }}
                            </button>
                        </div>

                        <button
                            class="pagination-arrow"
                            :disabled="meta.current_page === meta.last_page"
                            @click="goToPage(meta.current_page + 1)"
                            aria-label="Next page"
                        >
                            &rarr;
                        </button>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { useI18n } from 'vue-i18n';
    import SideMenu from '../components/SideMenu.vue';
    import PropertyDetail from '../components/PropertyDetail.vue';
    import propertyService from '../services/propertyService';
    import propertyDetailService from '../services/propertyDetailService';

    const { t } = useI18n();
    const {
        properties,
        loading,
        error,
        filters,
        meta,
        currentPage,
        fetchProperties,
        getCities: cities,
        getFilteredProperties: filteredProperties,
        applyFilters,
        goToPage,
        getPageNumbers: pageNumbers
    } = propertyService;

    const {
        fetchPropertyDetails
    } = propertyDetailService;

    const selectedPropertyId = ref(null);
    const isDetailVisible = ref(false);

    const openPropertyDetail = (propertyId) => {
        selectedPropertyId.value = propertyId;
        isDetailVisible.value = true;
    };
    
    const closePropertyDetail = () => {
        isDetailVisible.value = false;
    };

    onMounted(fetchProperties);
</script>

<style scoped>
    .app-container {
        display: flex;
         min-height: 100vh;
    }

    .content {
        flex: 1;
        padding: 30px;
        background-color: #f5f7fa;
        margin-left: 240px; /*compenseer sidebar hack*/
    }

    header {
        margin-bottom: 20px;
    }

    h1 {
        margin: 0;
        font-size: 24px;
        color: #497eb8;
    }

    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
    }

    .filters {
        display: flex;
        align-items: flex-end;
        gap: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        min-width: 200px;
    }

    label {
        margin-bottom: 8px;
        font-size: 14px;
        color: #6c757d;
    }

    select {
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .btn {
        background-color: #497eb8;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #497eb8;
    }

    .properties-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .property-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .property-card h3 {
        margin-top: 0;
        margin-bottom: 8px;
        font-size: 18px;
        color: #2c3e50;
        height: 3lh;
    }

    .city {
        color: #6c757d;
        margin-bottom: 8px;
    }

    .price {
        font-weight: bold;
        font-size: 18px;
        color: #497eb8;
        margin-bottom: 10px;
    }

    .details {
        color: #6c757d;
        margin-bottom: 15px;
    }

    .status {
        margin-bottom: 8px;
    }
    .under_offer {
        color: orange;
    }
    .available {
        color: green;
    }
    .rented, .sold {
        color: red;
    }

    .view-details {
        width: 100%;
    }

    .loading, .error {
        text-align: center;
        padding: 30px;
        color: #6c757d;
    }

    .error {
        color: red;
    }

    .dataCount {
        color: #6c757d;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
        gap: 10px;
    }

    .pagination-numbers {
        display: flex;
        gap: 5px;
    }

    .pagination-number {
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        border: 1px solid #e1e4e8;
        border-radius: 4px;
        color: #6c757d;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pagination-number:hover {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }

    .pagination-number.active {
        background-color: #497eb8;
        border-color: #497eb8;
        color: white;
    }

    .pagination-arrow {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        border: 1px solid #e1e4e8;
        border-radius: 4px;
        color: #6c757d;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pagination-arrow:hover:not(:disabled) {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }

    .pagination-arrow:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
