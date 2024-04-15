import { reactive } from 'vue';
import axios from 'axios';

export default (options = {}) => {
    options = {
        method: 'get',
        url: '',
        params: {},
        data: {},
        response: false,
        onSuccess: () => null,
        onError: () => null,
        ...options
    };
    
    return reactive({
        busy: false,
        params: options.params,
        data: options.data,
        response: options.response,
        error: false,

        async submit() {
            this.error = false;
            this.busy = true;
            try {
                const resp = await axios({
                    method: options.method,
                    url: options.url,
                    params: this.params,
                    data: this.data,
                });
                this.response = resp.data;
                options.onSuccess(resp);
            } catch(err) {
                this.error = err.message.response || { message: err.message };
                options.onError(this.error);
            }
            this.busy = false;
        },
    });
};