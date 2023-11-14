<template>
    <div class="flex items-center gap-x-2">
        <div class="text-base">{{ userName }}</div>
    </div>
</template>

<script setup lang="ts">
import { UserResource } from "@/types";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage<{
    auth: {
        user: UserResource;
    };
}>();
const userName = computed(() => page.props.auth.user.data.name);
</script>

<style scoped></style>
