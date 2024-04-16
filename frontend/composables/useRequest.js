import { reactive } from 'vue';
import axios from 'axios';

export default (options = {}) => {
    options = {
        method: 'get',
        url: '',
        params: {},
        data: {},
        response: false,
        onRequestBefore: () => null,
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

        getErrors(field, asArray=true) {
            let errors = [];

            if (this.error && this.error.errors) {
                errors = this.error.errors[field] || [];
            }

            return asArray ? errors : errors.join("\n");
        },
        
        hasError(field) {
            return this.getErrors(field).length > 0;
        },

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
                options.onRequestBefore();
                const resp = await axios(axiosOptions);
                this.response = resp.data;
                this.success = true;
                options.onSuccess(resp);
            } catch(err) {
                this.error = { message: err.message, errors: [] };
                if (err.response && err.response.data) {
                    this.error = err.response.data;
                }
                options.onError(this.error);
            }
            this.busy = false;
        },
    });
};