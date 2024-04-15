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
        success: false,
        // method: options.method,
        // url: options.url,
        params: options.params,
        data: options.data,
        response: options.response,
        error: false,

        async submit() {
            this.error = false;
            this.success = false;
            this.busy = true;

            let axiosOptions = {
                method: options.method,
                url: options.url,
                params: this.params,
                data: this.data,
            };

            for(let i in axiosOptions) {
                if (typeof axiosOptions[i] == 'function') {
                    axiosOptions[i] = axiosOptions[i]();
                }
            }

            try {
                const resp = await axios(axiosOptions);
                this.response = resp.data;
                this.success = true;
                options.onSuccess(resp);
            } catch(err) {
                this.error = err.response ? err.response.data : { message: err.message };
                options.onError(this.error);
            }
            this.busy = false;
        },
    });
};