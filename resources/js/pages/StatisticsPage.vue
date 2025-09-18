<template>
    <div class="app-container">
        <SideMenu />
        <main class="content">
            <header>
                <h1>{{ $t('PLACEHOLDER') }}</h1>
            </header>

            <section>
                <div class="card">
                    <p class="coming-soon">{{ $t('PLACEHOLDER') }}</p>
                    <div class="placeholder-chart">
                        <div class="chart-bar" v-for="(height, index) in chartBars" :key="index" :style="{ height: `${height}px` }"></div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import SideMenu from '../components/SideMenu.vue';

    const { t } = useI18n();
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
        color: #2c3e50;
    }

    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
    }

    .coming-soon {
        text-align: center;
        font-size: 18px;
        color: #6c757d;
        margin: 20px 0;
    }

    .placeholder-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        height: 200px;
        margin: 40px 0;
        padding: 0 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .chart-bar {
        width: 30px;
        background-color: #3490dc;
        border-radius: 3px 3px 0 0;
        transition: height 0.5s ease;
    }

    .chart-bar:hover {
        background-color: #2779bd;
    }
</style>
