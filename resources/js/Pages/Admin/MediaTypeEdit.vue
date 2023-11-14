<template>
    <div>
        <h1>Medienart bearbeiten</h1>
        <form @submit.prevent="submit" class="mt-4 grid gap-y-4 max-w-[30rem]">
            <HfhInput
                label="Name"
                v-model="form.name"
                id="media-type-name"
                required
            ></HfhInput>
            <HfhButton type="submit">Speichern</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import { MediaTypeResource } from "@/types";
import { HfhButton, HfhInput } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";
import { PropType, computed } from "vue";

const props = defineProps({
    mediaTypeResource: {
        type: Object as PropType<MediaTypeResource>,
        required: true,
    },
});

const mediaType = computed(() => props.mediaTypeResource.data);

const form = useForm({
    name: mediaType.value.name,
});

const submit = () => {
    form.put(`/admin/media-types/${mediaType.value.id}`);
};
</script>

<style lang="scss" scoped></style>
