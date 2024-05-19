/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.html',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

