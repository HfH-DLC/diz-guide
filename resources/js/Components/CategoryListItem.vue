<template>
    <li>
        <Link
            :href="`/admin/categories/${category.id}`"
            class="hover:text-thunderbird-red"
            >{{ category.name }}</Link
        >
        <ul
            v-if="category.children && category.children.length > 0"
            class="ml-6 mb-2"
        >
            <CategoryListItem
                v-for="child in category.children"
                :category="child"
            ></CategoryListItem>
        </ul>
    </li>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { CategoryData } from "@/types";
import { PropType } from "vue";

const props = defineProps({
    category: {
        type: Object as PropType<CategoryData>,
        required: true,
    },
});
</script>

<style scoped></style>
