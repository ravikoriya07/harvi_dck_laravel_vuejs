<script setup>
import { computed, useAttrs } from 'vue';
import { Link } from '@inertiajs/vue3';
import { isSpaHref } from '@/utils/inertiaNav';

const props = defineProps({
    href: { type: String, required: true },
});

const attrs = useAttrs();
const useInertia = computed(() => isSpaHref(props.href));
</script>

<template>
    <Link v-if="useInertia" :href="href" v-bind="attrs">
        <slot />
    </Link>
    <a v-else :href="href" v-bind="attrs">
        <slot />
    </a>
</template>
