<template>
    <div>
        <h1>{{ category.name }}</h1>
        <div v-if="category.parent">
            <h2 class="hfh-label">Oberkategorie</h2>
            <p>
                <a :href="`/admin/categories/${category.parent.id}`">{{
                    category.parent.name
                }}</a>
            </p>
        </div>
        <Link
            :href="`/admin/categories/${category.id}/edit`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow mt-4"
            >Bearbeiten</Link
        >
        <HfhButton class="block mt-4" @click="deleteCategory"
            >Löschen</HfhButton
        >
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { CategoryResource } from "../../types";
import { HfhButton } from "@hfh-dlc/hfh-styleguide";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    categoryResource: {
        type: Object as PropType<CategoryResource>,
        required: true,
    },
});

const category = computed(() => props.categoryResource.data);

const deleteCategory = () => {
    if (
        confirm(
            `Willst du die Kategorie "${category.value.name}" wirklich löschen?`
        )
    ) {
        router.delete(`/admin/categories/${category.value.id}`);
    }
};
</script>

<style lang="scss" scoped></style>
