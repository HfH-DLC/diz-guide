<template>
    <header>
        <HfhHeader
            :primaryItems="menuState.primaryItems"
            :tertiaryItems="menuState.tertiaryItems"
            @updateItems="onUpdateItems"
            :currentItem="currentItem"
        >
            <template #logo-desktop
                ><Link href="/" class="inline-flex gap-x-4 items-center"
                    ><HfhLogo></HfhLogo>
                    <div class="text-2xl mb-[3px]">DiZ-Guide</div></Link
                ></template
            >
        </HfhHeader>
    </header>
    <main class="mx-4 xl:max-w-container xl:mx-auto pb-20 mt-3 lg:mt-20">
        <slot></slot>
    </main>
    <footer>
        <HfhFooter>
            <template #tagline
                ><p>
                    wissenschaftsbasiert, praxisorientiert, breit verankert
                </p></template
            >
            <template #contact-address
                ><p>
                    Schaffhauserstrasse 239<br />Postfach 5850<br />CH-8050
                    Zürich
                </p></template
            >
            <template #contact-other>
                <p>T +41 44 317 11 11</p>
                <p><a href="mailto:info@hfh.ch">info@hfh.ch</a></p>
            </template>
            <template #socials>
                <HfhSocialBlock
                    icon="facebook"
                    href="https://www.facebook.com/hfh.edu"
                />
                <HfhSocialBlock
                    icon="youtube"
                    href="https://www.youtube.com/user/hfhzuerich"
                />
                <HfhSocialBlock
                    icon="linkedin"
                    href="https://www.linkedin.com/company/hfh.edu"
                />
                <HfhSocialBlock
                    icon="instagram"
                    href="https://www.instagram.com/hfh_edu/"
                />
                <HfhSocialBlock
                    icon="twitter"
                    href="https://twitter.com/hfh_edu"
                />
                <HfhSocialBlock
                    icon="issuu"
                    href="https://issuu.com/hochschule_fuer_heilpaedagogik"
                />
            </template>
            <template #copyright
                >© Copyright {{ new Date().getFullYear() }} HfH</template
            >
        </HfhFooter>
    </footer>
</template>

<script setup lang="ts">
import {
    HfhHeader,
    HfhFooter,
    HfhLogo,
    HfhSocialBlock,
} from "@hfh-dlc/hfh-styleguide";
import type { MenuItem } from "@hfh-dlc/hfh-styleguide/types";
import { usePage, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { menuState } from "@/menuState";

const currentItem = computed(() => {
    return usePage().url;
});

const onUpdateItems = (items: {
    primaryItems: Array<MenuItem>;
    secondaryItems: Array<MenuItem>;
    tertiaryItems: Array<MenuItem>;
}) => {
    menuState.value.primaryItems = items.primaryItems;
    menuState.value.secondaryItems = items.secondaryItems;
    menuState.value.tertiaryItems = items.tertiaryItems;
};
</script>

<style scoped lang="sass"></style>
