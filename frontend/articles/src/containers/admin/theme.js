import { createMuiTheme } from '@material-ui/core';
import indigo from '@material-ui/core/colors/indigo';
import red from '@material-ui/core/colors/red';
import purple from '@material-ui/core/colors/purple';

const theme = {
  palette: {
    primary: indigo,
    secondary: {
      light: purple.A200,
      main: purple.A400,
      dark: purple.A700,
    },
    error: red,
  }
};

export default createMuiTheme(theme);
