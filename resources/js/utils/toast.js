import { useToast } from 'vue-toastification';

export function notifySuccess(message, options = {}) {
    useToast().success(message, options);
}

export function notifyError(message, options = {}) {
    useToast().error(message, options);
}
