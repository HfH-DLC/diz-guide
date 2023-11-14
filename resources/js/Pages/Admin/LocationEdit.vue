<template>
    <div>
        <h1>Aufbewahrungsort bearbeiten</h1>
        <form @submit.prevent="submit" class="mt-4 grid gap-y-4 max-w-[30rem]">
            <HfhInput
                label="Name"
                v-model="form.name"
                id="location-name"
                required
            ></HfhInput>
            <HfhInput
                id="location-image"
                label="Bild"
                type="file"
                @input="setFile"
            ></HfhInput>
            <img
                v-if="location.imageSrc"
                :src="location.imageSrc"
                :alt="location.imageAlt"
            />
            <HfhInput
                label="Bild Alternativtext"
                v-model="form.imageAlt"
                id="location-image-alt"
                required
            ></HfhInput>
            <HfhButton type="submit">Speichern</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import { LocationResource } from "@/types";
import { HfhButton, HfhInput } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";
import { PropType, computed } from "vue";

const props = defineProps({
    locationResource: {
        type: Object as PropType<LocationResource>,
        required: true,
    },
});

const location = computed(() => props.locationResource.data);

const form = useForm<{ name: string; image: File | null; imageAlt: string }>({
    name: location.value.name,
    image: null,
    imageAlt: location.value.imageAlt,
});

const setFile = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.image = target.files[0];
    }
};

const submit = () => {
    form.put(`/admin/locations/${location.value.id}`);
};
</script>

<style lang="scss" scoped></style>
