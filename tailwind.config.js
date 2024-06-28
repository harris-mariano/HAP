/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        'custom-gray': '#FCFCFC',
        'custom-orange': '#E88504',
        'all-tickets': '#FB923C',
        'open': '#EAB308',
        'in-progress' : '#3B82F6',
        'resolved': '#22C55E', 
        'closed': '#EF4444'
      },
    },
  },
  plugins: [],
}

