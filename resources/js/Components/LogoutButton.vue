<template>
    <button
        class="text-base leading-none flex items-center gap-x-1 hover:text-thunderbird-red"
        @click="logout"
    >
        <ArrowLeftOnRectangleIcon class="w-5"></ArrowLeftOnRectangleIcon>
        <div>Abmelden</div>
    </button>
</template>

<script setup lang="ts">
import { ArrowLeftOnRectangleIcon } from "@heroicons/vue/24/outline";
import { router } from "@inertiajs/vue3";

const logout = () => {
    router.post("/admin/logout");
};
</script>

<style scoped></style>
