<template>
    <div class="app-wrapper">
        <router-view />
    </div>
</template>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        font-size: 16px;
        line-height: 1.5;
        color: #333;
    }

    .app-wrapper {
        width: 100%;
        min-height: 100vh;
    }

    a {
        color: #3490dc;
        text-decoration: none;
    }

    button {
        cursor: pointer;
    }
</style>
