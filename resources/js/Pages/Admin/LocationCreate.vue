<template>
    <div>
        <h1>Neuer Aufbewahrungsort</h1>
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
                required
            ></HfhInput>
            <HfhInput
                label="Bild Alternativtext"
                v-model="form.imageAlt"
                id="location-image-alt"
                required
            ></HfhInput>
            <HfhButton type="submit">Aufbewahrungsort erstellen</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import { HfhButton, HfhInput } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";

const form = useForm<{ name: string; image: File | null; imageAlt: string }>({
    name: "",
    image: null,
    imageAlt: "",
});

const setFile = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.image = target.files[0];
    }
};

const submit = () => {
    form.post("/admin/locations");
};
</script>

<style lang="scss" scoped></style>
