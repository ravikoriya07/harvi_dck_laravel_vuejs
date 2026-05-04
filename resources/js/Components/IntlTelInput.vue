<template>
    <div class="intl-tel-vue">
        <input
            ref="inputRef"
            type="tel"
            :id="inputId"
            :class="inputClass"
            autocomplete="tel"
            required
        />
    </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import intlTelInput from 'intl-tel-input';
import 'intl-tel-input/styles';

const props = defineProps({
    modelValue: { type: String, default: '' },
    inputId: { type: String, default: '' },
    inputClass: { type: String, default: '' },
    /** ISO 3166-1 alpha-2, e.g. gb */
    initialCountry: { type: String, default: 'gb' },
});

const emit = defineEmits(['update:modelValue']);

const inputRef = ref(null);
let iti = null;

function readValue() {
    if (!iti || !inputRef.value) return '';
    try {
        return iti.getNumber() || inputRef.value.value.trim();
    } catch {
        return inputRef.value.value.trim();
    }
}

function publish() {
    emit('update:modelValue', readValue());
}

onMounted(() => {
    const input = inputRef.value;
    if (!input) return;

    iti = intlTelInput(input, {
        initialCountry: props.initialCountry || 'gb',
        countryOrder: ['us', 'gb', 'in'],
        separateDialCode: true,
        nationalMode: false,
        strictMode: false,
        formatAsYouType: true,
        formatOnDisplay: true,
        countrySearch: true,
        dropdownContainer: document.body,
        containerClass: 'jobs-intl-dropdown-portal',
        loadUtils: () => import('intl-tel-input/utils'),
    });

    iti.promise.then(() => {
        if (props.modelValue) {
            iti.setNumber(props.modelValue);
        }
    });

    input.addEventListener('input', publish);
    input.addEventListener('countrychange', publish);
    input.addEventListener('blur', publish);
});

watch(
    () => props.modelValue,
    (v) => {
        if (!iti) return;
        const current = readValue();
        if ((v || '') === (current || '')) return;
        try {
            iti.setNumber(v || '');
        } catch {
            /* ignore invalid partial sync */
        }
    },
);

onBeforeUnmount(() => {
    const input = inputRef.value;
    if (input) {
        input.removeEventListener('input', publish);
        input.removeEventListener('countrychange', publish);
        input.removeEventListener('blur', publish);
    }
    if (iti) {
        iti.destroy();
        iti = null;
    }
});
</script>

<style scoped>
.intl-tel-vue {
    width: 100%;
}

.intl-tel-vue :deep(.iti) {
    --iti-border-color: #e2e6ea;
    --iti-hover-color: rgba(19, 85, 165, 0.08);
    width: 100%;
}

.intl-tel-vue :deep(.iti__tel-input) {
    padding: 11px 14px;
    font-size: 14px;
    color: #2d3748;
    border-radius: 0 6px 6px 0;
}

.intl-tel-vue :deep(.iti__selected-country) {
    border-radius: 6px 0 0 6px;
    background: #f7f9fc;
}

.intl-tel-vue :deep(.iti__selected-dial-code) {
    color: #2d3748;
    font-weight: 600;
    font-size: 14px;
}

.intl-tel-vue :deep(.iti input.iti__tel-input:focus) {
    outline: none;
}
</style>

<!--
  Detached dropdown is appended to document.body inside .iti--container.
  Library default z-index on that container is 1060 — below job modals (99999),
  so the list was hidden behind the backdrop. Raise the whole portal.
-->
<style>
.jobs-intl-dropdown-portal.iti--container {
    z-index: 100000 !important;
}
</style>
