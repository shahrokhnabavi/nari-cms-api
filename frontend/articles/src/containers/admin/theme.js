import { createMuiTheme } from '@material-ui/core';
import lightBlue from '@material-ui/core/colors/lightBlue';
import red from '@material-ui/core/colors/red';
import blue from '@material-ui/core/colors/blue';
import amber from '@material-ui/core/colors/amber';

const theme = {
  palette: {
    secondary: {
      ...lightBlue,
      contrastText: 'white'
    },
    primary: blue,
    error: red,
    warning: amber
  }
};

export default createMuiTheme(theme);
