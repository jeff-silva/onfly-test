<template>
    <div v-if="!app.ready" style="display: flex; align-items: center; justify-content: center; width: 100vw; height:100vh;">
        <!-- https://www.svgbackgrounds.com/elements/animated-svg-preloaders/ -->
        <svg style="height:100px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin="0"></animate></circle><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" opacity=".8" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin="0.05"></animate></circle><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" opacity=".6" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".1"></animate></circle><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" opacity=".4" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".15"></animate></circle><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" opacity=".2" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".2"></animate></circle></svg>
    </div>

    <div v-if="app.ready" class="column items-center justify-center" style="height: 100vh; background: #f5f5f5;">
        <div style="min-width: 300px; max-width: 300px; background: #fff;">
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
const app = useApp();
</script>
