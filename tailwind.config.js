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
                "fantasy-light": "#fbf3f4",
                "fantasy-plain": "#f2d1d3",
                "fantasy-dark": "#d8757c",
                "gray-dark": "#767676",
                "gray-light": "#f4f4f4",
                "thunderbird-red": "#be1925",
                "thunderbird-red-light": "#e31826",
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
