<template>
    <header>
        <div
            class="min-h-[4rem] border-b border-gray-300 flex justify-between pl-4"
        >
            <div class="flex items-center">
                <Link href="/"><HfhLogo class="w-auto h-8"></HfhLogo></Link>
            </div>
        </div>
    </header>
    <main class="p-4">
        <div>
            <h1>Login</h1>
            <form @submit.prevent="submit" class="max-w-[20rem]">
                <HfhFormField :error="errors?.email" v-slot="errorInfo">
                    <HfhInput
                        id="email"
                        v-model="form.email"
                        label="E-Mail"
                        type="email"
                        required
                        :hasError="errorInfo.hasError"
                        :errorId="errorInfo.errorId"
                    ></HfhInput>
                </HfhFormField>
                <HfhFormField :error="errors?.password" v-slot="errorInfo">
                    <HfhInput
                        id="password"
                        v-model="form.password"
                        label="Passwort"
                        type="password"
                        required
                        :hasError="errorInfo.hasError"
                        :errorId="errorInfo.errorId"
                    ></HfhInput>
                </HfhFormField>
                <HfhButton type="submit" class="mt-4">Anmelden</HfhButton>
            </form>
        </div>
    </main>
</template>

<script setup lang="ts">
import {
    HfhButton,
    HfhFormField,
    HfhInput,
    HfhLogo,
} from "@hfh-dlc/hfh-styleguide";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({ errors: Object });

const form = useForm({
    email: "",
    password: "",
});

const submit = () => {
    form.post("/login");
};
</script>

<style scoped></style>
