
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('daisyui'),
  ],
  daisyui: {
    themes: [
      {
        'mytheme': {                          /* your theme name */
          'primary': '#570df8',           /* Primary color */
          'primary-focus': '#4506cb',     /* Primary color - focused */
          'primary-content': '#ffffff',   /* Foreground content color to use on primary color */

          'secondary': '#58c7f3',         /* Secondary color */
          'secondary-focus': '#88d8f7',   /* Secondary color - focused */
          'secondary-content': '#201047', /* Foreground content color to use on secondary color */

          'accent': '#f3cc30',            /* Accent color */
          'accent-focus': '#f6d860',      /* Accent color - focused */
          'accent-content': '#201047',    /* Foreground content color to use on accent color */

          'neutral': '#20134e',           /* Neutral color */
          'neutral-focus': '#140a2e',     /* Neutral color - focused */
          'neutral-content': '#f9f7fd',   /* Foreground content color to use on neutral color */

          'base-100': '#2d1b69',          /* Base color of page, used for blank backgrounds */
          'base-200': '#20134e',          /* Base color, a little darker */
          'base-300': '#140a2e',          /* Base color, even more darker */
          'base-content': '#201047',      /* Foreground content color to use on base color */

          'info': '#53c0f3',              /* Info */
          'success': '#71ead2',           /* Success */
          'warning': '#f3cc30',           /* Warning */
          'error': '#e24056',             /* Error */
        },
      },
    ],
  },
}