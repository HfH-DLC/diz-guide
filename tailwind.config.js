/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        screens: {
            sm: "640px",
            md: "768px",
            lg: "1024px",
            xl: "1152px",
            "2xl": "1536px",
        },
        extend: {
            colors: {
                "thunderbird-red": "var(--c-thunderbird-red)",
                "thunderbird-red-light": "var(--c-thunderbird-red-light)",
                "fantasy-light": "var(--c-fantasy-light)",
                "fantasy-dark": "var(--c-fantasy-dark)",
                "fantasy-plain": "var(--c-fantasy-plain)",
                "gray-light": "var(--c-gray-light)",
                "gray-dark": "var(--c-gray-dark)",
            },
            width: {
                content: "var(--w-content)",
                container: "var(--w-container)",
            },
            maxWidth: {
                content: "var(--w-content)",
                container: "var(--w-container)",
            },
        },
    },
    plugins: [],
};
