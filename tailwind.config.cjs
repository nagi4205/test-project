/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'media', 
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "node_modules/preline/dist/*.js",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('preline/plugin'),
    ],
};
