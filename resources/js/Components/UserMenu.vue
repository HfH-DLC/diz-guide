<template>
    <details class="flex items-center relative px-4">
        <summary class="list-none h-full flex items-center cursor-pointer">
            <!-- <Avatar></Avatar> -->
        </summary>
        <div
            class="shadow-md border border-gray-300 absolute bg-white right-0 top-full p-4 flex justify-end"
        >
            <LogoutButton></LogoutButton>
        </div>
    </details>
</template>

<script setup lang="ts">
import Avatar from "./Avatar.vue";
import LogoutButton from "./LogoutButton.vue";
</script>

<style scoped></style>
