<template>
    <div class="property-detail-overlay" v-if="isVisible" @click.self="close">
        <div class="property-detail-modal">
            <button class="close-button" @click="close">&times;</button>

            <div v-if="loading" class="loading">
                {{ $t('details_loading') }}
            </div>
            <div v-else-if="error" class="error">
                {{ error }}
            </div>
            <div v-else-if="property" class="property-content">
                <header>
                    <h2>{{ property.address }}</h2>
                    <p :class="['status', property.status]">{{ $t(`status_${property.status}`) }}</p>
                </header>

                <div class="property-info">
                    <div class="property-main-details">
                        <p class="price">€{{ property.price.toLocaleString() }}</p>
                        <p class="city">{{ property.city }}</p>
                    </div>

                    <div class="property-specs">
                        <div class="spec">
                            <span class="spec-value">{{ property.bedrooms }}</span>
                            <span class="spec-label">{{ $t('properties_beds') }}</span>
                        </div>
                        <div class="spec">
                            <span class="spec-value">{{ property.bathrooms }}</span>
                            <span class="spec-label">{{ $t('properties_baths') }}</span>
                        </div>
                        <div class="spec">
                            <span class="spec-label">{{ $t('properties_balcony') }}: </span>
                            <span v-if="property.balcony" class="spec-label-yes">V</span>
                            <span v-else class="spec-label-no">X</span>
                        </div>
                        <div class="spec">
                          <span class="spec-label">{{ $t('properties_garden') }}: </span>
                          <span v-if="property.garden" class="spec-label-yes">V</span>
                          <span v-else class="spec-label-no">X</span>
                        </div>
                    </div>
                </div>

                <div class="property-description">
                    <h3>{{ $t('details_description') }}</h3>
                    <p>{{ property.description }}</p>
                </div>

                <footer>
                    <button class="btn" @click="close">{{ $t('details_back') }}</button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { watch } from 'vue';
    import { useI18n } from 'vue-i18n';
    import propertyDetailService from '../services/propertyDetailService';

    const { t } = useI18n();

    const props = defineProps({
        propertyId: {
            type: Number,
            default: null
        },
        isVisible: {
            type: Boolean,
            default: false
        }
    });

    const emit = defineEmits(['close']);

    const {
        property,
        loading,
        error,
        fetchPropertyDetails,
        resetPropertyDetail
    } = propertyDetailService;

    // Change our details when we open a second details page.
    watch(() => props.propertyId, async (newId) => {
        if (newId && props.isVisible) {
            await fetchPropertyDetails(newId, t);
        }
    });

    // Empty or fill the pop-up when it becomes visible or disappears.
    watch(() => props.isVisible, async (visible) => {
        if (visible && props.propertyId) {
            await fetchPropertyDetails(props.propertyId, t);
        } else if (!visible) {
            resetPropertyDetail();
        }
    });

    const close = () => {
        emit('close');
    };
</script>

<style scoped>
    .property-detail-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        overflow-y: auto;
        padding: 20px;
    }

    .property-detail-modal {
        background-color: white;
        border-radius: 8px;
        width: 100%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .close-button {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 24px;
        color: #6c757d;
        cursor: pointer;
    }

    .property-content header {
        margin-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 15px;
    }

    .property-content h2 {
        margin: 0 0 10px 0;
        font-size: 24px;
        color: #2c3e50;
    }

    .property-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .property-main-details {
        flex: 1;
        min-width: 200px;
    }

    .price {
        font-size: 28px;
        font-weight: bold;
        color: #497eb8;
        margin: 0 0 5px 0;
    }

    .city {
        font-size: 16px;
        color: #6c757d;
    }

    .property-specs {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .spec {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .spec-value {
        font-size: 20px;
        font-weight: bold;
        color: #2c3e50;
    }

    .spec-label {
        font-size: 14px;
        color: #6c757d;
    }
    .spec-label-no, .spec-label-yes{
        font-size: 20px;
        font-weight: bold;
    }
    .spec-label-no{
        color: red;
    }
    .spec-label-yes{
        color: green;
    }

    .property-description {
        margin-bottom: 30px;
    }

    .property-description h3 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .property-description p {
        line-height: 1.6;
        color: #333;
    }

    footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
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
        background-color: #3867a3;
    }

    .loading, .error {
        padding: 40px;
        text-align: center;
        color: #6c757d;
    }

    .error {
        color: #dc3545;
    }

    .status {
        font-weight: 500;
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        background-color: rgba(0, 0, 0, 0.05);
    }

    .status.available {
        color: green;
    }

    .status.under_offer {
        color: orange;
    }

    .status.sold, .status.rented {
        color: red;
    }
</style>
