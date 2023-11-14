<template>
    <div>
        <h1>Neue Medienart</h1>
        <form @submit.prevent="submit" class="mt-4 grid gap-y-4 max-w-[30rem]">
            <HfhInput
                label="Name"
                v-model="form.name"
                id="media-type-name"
                required
            ></HfhInput>
            <HfhButton type="submit">Medienart erstellen</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import { HfhButton, HfhInput } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
});

const submit = () => {
    form.post("/admin/media-types");
};
</script>

<style lang="scss" scoped></style>
