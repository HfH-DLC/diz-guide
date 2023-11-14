<template>
    <div>
        <h1>Neuer Eintrag</h1>
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
            <HfhSelect
                id="item-topics"
                label="Fachliches Thema"
                v-model="form.topicId"
                :options="topicOptions"
            ></HfhSelect>
            <HfhButton type="submit">Eintrag erstellen</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import {
    CategoriesResource,
    LocationsResource,
    MediaTypesResource,
    TopicsResource,
} from "@/types";
import { HfhButton, HfhInput, HfhSelect } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";
import { PropType, computed } from "vue";

const props = defineProps({
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
    topicsResource: {
        type: Object as PropType<TopicsResource>,
        required: true,
    },
});

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

const topicOptions = computed(() =>
    props.topicsResource.data.map((topicData) => {
        return {
            label: topicData.name,
            value: topicData.id,
        };
    })
);

const form = useForm({
    categoryId: "",
    locationId: "",
    mediaTypeId: "",
    topicId: "",
    signature: "",
});

const submit = () => {
    form.post("/admin/items");
};
</script>

<style lang="scss" scoped></style>
