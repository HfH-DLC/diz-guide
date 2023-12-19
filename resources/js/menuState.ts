import type { MenuItem } from "@hfh-dlc/hfh-styleguide/types/types";
import { ref } from "vue";
import type { Ref } from "vue";

export const menuState: Ref<{
    primaryItems?: Array<MenuItem>;
    secondaryItems?: Array<MenuItem>;
    tertiaryItems?: Array<MenuItem>;
}> = ref({
    primaryItems: [
        {
            label: "Willkommen",
            link: {
                href: "/",
            },
        },
        {
            label: "Kategorien",
            link: {
                href: "/kategoriesuche",
            },
        },
        {
            label: "Stichwortsuche",
            link: {
                href: "/stichwortsuche",
            },
        },
        {
            label: "Weitere Informationen",
            children: [
                {
                    label: "Vollständige Materialliste des DiZ",
                    link: {
                        href: "/materialliste",
                    },
                },
                {
                    label: "Signatursuche",
                    link: {
                        href: "/signatursuche",
                    },
                },
                {
                    label: "Suche nach Aufbewahrungsorten",
                    link: {
                        href: "/ortsuche",
                    },
                },
                {
                    label: "Didaktisches Zentrum",
                    link: {
                        href: "https://www.hfh.ch/services/didaktisches-zentrum",
                        target: "_blank",
                    },
                },
                {
                    label: "Virtual Tour TLP & DiZ",
                    link: {
                        href: "https://www.hfh.ch/services/didaktisches-zentrum#virtualtour",
                        target: "_blank",
                    },
                },
            ],
            open: false,
        },
    ],
    tertiaryItems: [
        {
            label: "Didaktisches Zentrum",
            link: {
                href: "https://www.hfh.ch/services/didaktisches-zentrum",
                target: "_blank",
            },
        },
        { label: "hfh.ch", link: { href: "https://hfh.ch", target: "_blank" } },
    ],
});
