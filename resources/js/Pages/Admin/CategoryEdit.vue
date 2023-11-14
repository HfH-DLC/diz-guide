<template>
    <div>
        <h1>Kategorie bearbeiten</h1>
        <form @submit.prevent="submit" class="mt-4 grid gap-y-4 max-w-[30rem]">
            <HfhInput
                label="Name"
                v-model="form.name"
                id="category-name"
                required
            ></HfhInput>
            <HfhSelect
                label="Oberkategorie"
                v-model="form.parentId"
                id="category-parent"
                default-option="Bitte wählen..."
                :options="categoryOptions"
            ></HfhSelect>
            <HfhButton type="submit">Speichern</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import { HfhButton, HfhInput, HfhSelect } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";
import { PropType, computed } from "vue";
import { CategoriesResource, CategoryResource } from "../../types";

const props = defineProps({
    categoryResource: {
        type: Object as PropType<CategoryResource>,
        required: true,
    },
    categoriesResource: {
        type: Object as PropType<CategoriesResource>,
        required: true,
    },
});

const category = computed(() => props.categoryResource.data);

const categoryOptions = computed(() =>
    props.categoriesResource.data.map((categoryData) => {
        return {
            label: categoryData.name,
            value: categoryData.id,
        };
    })
);

const form = useForm({
    name: category.value.name,
    parentId: category.value.parent?.id || "",
});

const submit = () => {
    form.transform((data) => {
        if (data.parentId === "") {
            return { ...data, parentId: null };
        }
        return data;
    }).put(`/admin/categories/${category.value.id}`);
};
</script>

<style lang="scss" scoped></style>
