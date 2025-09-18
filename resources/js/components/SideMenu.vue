<template>
    <div class="side-menu">
        <div class="logo">
            <img class="logo-default" src="https://nexxtmove.nl/wp-content/uploads/2022/01/logo-nexxtmove.svg" alt="Nexxtmove" itemprop="url">
        </div>

        <nav>
            <ul>
                <li>
                    <router-link :to="{ name: 'properties' }" class="nav-item" active-class="active">
                        {{ $t('navigation_properties') }}
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'statistics' }" class="nav-item" active-class="active">
                        {{ $t('navigation_statistics') }}
                    </router-link>
                </li>
            </ul>
        </nav>

        <div class="language-selector">
            <span>{{ $t('language_select') }}: </span><br/>
            <button @click="changeLanguage('nl')" :class="{ active: currentLanguage === 'nl' }">NL</button>
            <button @click="changeLanguage('en')" :class="{ active: currentLanguage === 'en' }">EN</button>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import { useI18n } from 'vue-i18n';

    const { t, locale } = useI18n();
    const currentLanguage = computed(() => locale.value);
    const changeLanguage = (lang) => {
      locale.value = lang;
    };
</script>

<style scoped>
    .side-menu {
        width: 250px;
        background-color: #497eb8;
        color: white;
        height: 100vh;
        padding: 20px;
        display: flex;
        flex-direction: column;
        position: fixed;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    nav {
        flex-grow: 1;
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    li {
        margin-bottom: 10px;
    }

    .nav-item {
        display: block;
        padding: 10px 15px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .nav-item.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .language-selector {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .language-selector button {
        background: none;
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: rgba(255, 255, 255, 0.7);
        padding: 5px 10px;
        margin-left: 5px;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .language-selector button:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .language-selector button.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border-color: rgba(255, 255, 255, 0.5);
    }
</style>
