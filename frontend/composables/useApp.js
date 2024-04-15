import { defineStore } from "pinia";
import { reactive } from 'vue';
import axios from 'axios';

import useRequest from '@/composables/useRequest';

export default () => {
    const r = defineStore('app', () => {
        return {
            ready: false,
            data: false,
    
            async init() {
                if (r.ready) return;
                const { data } = await axios.get('api://app/load');
                r.data = data;
                r.ready = true;
            },
            
            async refresh() {
                const { data } = await axios.get('api://app/load');
                r.data = data;
                r.ready = true;
            },
            
            async logout() {
                await axios.post('api://auth/logout');
                localStorage.removeItem('app_token');
                r.data = false;
                r.ready = true;
            },
        };
    })();

    r.init();
    return r;
};