import { sizing } from '../variables';

export default theme => ({
  drawer: {
    width: sizing.drawerWidth,
    flexShrink: 0,
  },
  drawerPaper: {
    width: sizing.drawerWidth,
    '& a': {
      textDecoration: 'none',
      color: 'inherit',
    },
  },
  drawerHeader: {
    display: 'flex',
    alignItems: 'center',
    padding: theme.spacing(0, 1),
    ...theme.mixins.toolbar,
    justifyContent: 'flex-end',
  },
});
