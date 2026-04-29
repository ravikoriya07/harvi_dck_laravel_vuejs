<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <Link href="/" class="text-xl font-semibold text-gray-800">
                            {{ appName }}
                        </Link>
                    </div>
                    <div class="flex items-center gap-4">
                        <Link href="/" class="text-sm text-gray-600 hover:text-gray-900">Home</Link>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const appName = import.meta.env.VITE_APP_NAME ?? 'Laravel';
</script>
