import makeStyles from '@material-ui/core/styles/makeStyles'

export default makeStyles(theme => ({
    deleteButton: {
      color: theme.palette.error.main
    },
    editButton: {
      color: theme.palette.warning[700]
    }
}));
