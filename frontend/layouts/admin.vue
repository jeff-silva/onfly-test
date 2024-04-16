<template>
    <div v-if="!app.ready" style="display: flex; align-items: center; justify-content: center; width: 100vw; height:100vh;">
        <!-- https://www.svgbackgrounds.com/elements/animated-svg-preloaders/ -->
        <svg style="height:100px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin="0"></animate></circle><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" opacity=".8" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin="0.05"></animate></circle><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" opacity=".6" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".1"></animate></circle><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" opacity=".4" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".15"></animate></circle><circle fill="#1976D2" stroke="#1976D2" stroke-width="15" opacity=".2" r="15" cx="35" cy="100"><animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".2"></animate></circle></svg>
    </div>
    <q-layout v-if="app.ready" view="hHh Lpr lff" container style="height: 100vh" class="shadow-2">
        <q-header bordered>
            <q-toolbar>
                <q-btn flat @click="nav.drawer()" round dense icon="menu" />
                <q-toolbar-title v-if="props.title">
                    {{ props.title }}
                </q-toolbar-title>
                <q-spacer />
                <div v-if="app.data.user">Olá {{ app.data.user.name }}</div>
            </q-toolbar>
        </q-header>

        <q-drawer
            v-model="nav.drawerVisible"
            show-if-above
            :breakpoint="700"
            bordered
        >
            <q-scroll-area class="fit">
                <q-list>
                    <template v-for="item in nav.items">
                        <q-item v-bind="item.bind">
                            <q-item-section @click="item.bind.onClick">
                                {{ item.title }}
                            </q-item-section>
                        </q-item>
                    </template>
                </q-list>
            </q-scroll-area>
        </q-drawer>

        <q-drawer
            v-model="actions.drawerVisible"
            show-if-above
            :behavior="$q.screen.gt.md ? 'desktop' : 'mobile'"
            :breakpoint="700"
            bordered
            side="right"
        >
            <q-scroll-area class="fit q-pa-md elevation-2">
                <slot name="sidebar"></slot>
            </q-scroll-area>
        </q-drawer>

        <q-page-container>
            <div v-if="props.subtitle" class="bg-primary text-white q-pa-md">
                {{ props.subtitle }}
            </div>
            <slot name="header"></slot>
            <q-page padding>
                <slot></slot>
            </q-page>
        </q-page-container>

        <q-page-sticky position="bottom-right" :offset="[10, $q.screen.gt.md ? 10 : 50]">
            <slot name="actions"></slot>
        </q-page-sticky>
        
        <q-page-sticky position="bottom" class="bg-blue-grey-1" v-if="!$q.screen.gt.md">
            <q-btn flat label="Ações" @click="actions.drawer()" />
        </q-page-sticky>
    </q-layout>
  </template>

<script setup>
const props = defineProps({
    title: {
        type: String,
        default: null,
    },
    subtitle: {
        type: String,
        default: null,
    },
});

const app = useApp();

const nav = reactive({
    drawerVisible: false,
    drawer(value = null) {
        this.drawerVisible = value===null ? !this.drawerVisible : value;
    },
    items: [
        {
            title: 'Dashboard',
            bind: { to: '/admin' },
        },
        {
            title: 'Usuários',
            bind: { to: '/admin/app_user' },
        },
        {
            title: 'Despesas',
            bind: { to: '/admin/financial_expense' },
        },
        {
            title: 'Logout',
            bind: {
                style: { cursor: 'pointer' },
                async onClick() {
                    await app.logout();
                    location.reload();
                },
            },
        },
    ],
});

const actions = reactive({
    drawerVisible: false,
    drawer(value = null) {
        this.drawerVisible = value===null ? !this.drawerVisible : value;
    },
});
</script>