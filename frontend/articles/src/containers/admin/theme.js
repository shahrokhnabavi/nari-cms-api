import { createMuiTheme } from '@material-ui/core';
import lightBlue from '@material-ui/core/colors/lightBlue';
import red from '@material-ui/core/colors/red';
import blue from '@material-ui/core/colors/blue';

const theme = {
  palette: {
    secondary: {
      ...lightBlue,
      contrastText: 'white'
    },
    primary: blue,
    error: red,
  }
};

export default createMuiTheme(theme);
