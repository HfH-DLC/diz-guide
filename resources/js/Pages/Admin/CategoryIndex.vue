<template>
    <div>
        <h1>Kategorien</h1>
        <Link
            :href="`/admin/categories/create`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow"
            >Neue Kategorie</Link
        >
        <ul v-if="categories.length > 0" class="mt-4">
            <CategoryListItem
                v-for="category in categories"
                :category="category"
            ></CategoryListItem>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { CategoriesResource } from "@/types";
import CategoryListItem from "@/Components/CategoryListItem.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    categoriesResource: {
        type: Object as PropType<CategoriesResource>,
        required: true,
    },
});

const categories = computed(() => props.categoriesResource.data);
</script>

<style scoped></style>
