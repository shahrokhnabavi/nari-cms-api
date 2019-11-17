export default theme => ({
  root: {
    display: 'flex',
    height: '100%',
  },
  content: {
    flexGrow: 1,
    paddingTop: theme.spacing(8),
    boxSizing: 'border-box',
    position: 'relative',
    left: 0,
    bottom: 0,
    right: 0,
  },
  contentTopPadding: {
    ...theme.mixins.toolbar,
  },
});
