<template>
    <div>
        <h1>Fachliches Thema bearbeiten</h1>
        <form @submit.prevent="submit" class="mt-4 grid gap-y-4 max-w-[30rem]">
            <HfhSelect
                id="item-category"
                label="Kategorie"
                v-model="form.categoryId"
                :options="categoryOptions"
            ></HfhSelect>
            <HfhInput
                id="item-signature"
                label="Signatur"
                v-model="form.signature"
            ></HfhInput>
            <HfhSelect
                id="item-location"
                label="Aufbewahrungsort"
                v-model="form.locationId"
                :options="locationOptions"
            ></HfhSelect>
            <HfhSelect
                id="item-media-type"
                label="Medienart"
                v-model="form.mediaTypeId"
                :options="mediaTypeOptions"
            ></HfhSelect>
            <HfhInput
                id="item-topics"
                label="Fachliches Thema"
                v-model="form.topic"
            ></HfhInput>
            <HfhButton type="submit">Speichern</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import {
    CategoriesResource,
    LocationsResource,
    MediaTypesResource,
    ItemResource,
} from "@/types";
import { HfhButton, HfhInput, HfhSelect } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";
import { PropType, computed } from "vue";

const props = defineProps({
    itemResource: {
        type: Object as PropType<ItemResource>,
        required: true,
    },
    categoriesResource: {
        type: Object as PropType<CategoriesResource>,
        required: true,
    },
    locationsResource: {
        type: Object as PropType<LocationsResource>,
        required: true,
    },
    mediaTypesResource: {
        type: Object as PropType<MediaTypesResource>,
        required: true,
    },
});

const item = computed(() => props.itemResource.data);

const categoryOptions = computed(() =>
    props.categoriesResource.data.map((categoryData) => {
        return {
            label: categoryData.name,
            value: categoryData.id,
        };
    })
);

const mediaTypeOptions = computed(() =>
    props.mediaTypesResource.data.map((mediaTypeData) => {
        return {
            label: mediaTypeData.name,
            value: mediaTypeData.id,
        };
    })
);

const locationOptions = computed(() =>
    props.locationsResource.data.map((locationData) => {
        return {
            label: locationData.name,
            value: locationData.id,
        };
    })
);

const form = useForm({
    categoryId: item.value.category.id,
    locationId: item.value.location.id,
    mediaTypeId: item.value.mediaType.id,
    topic: item.value.topic,
    signature: item.value.signature,
});

const submit = () => {
    form.put(`/admin/items/${item.value.id}`);
};
</script>

<style lang="scss" scoped></style>
