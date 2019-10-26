import { AdminPanelLayoutActions } from '../actions';

const initialState = {
  isMenuOpen: false,
  pageTitle: ''
};

const AdminPanelLayoutReducer = (state = initialState, action) => {
  switch (action.type) {
    case AdminPanelLayoutActions.OPEN_MENU_PANEL:
      return {
        ...state,
        isMenuOpen: true
      };
    case AdminPanelLayoutActions.CLOSE_MENU_PANEL:
      return {
        ...state,
        isMenuOpen: false
      };
    case 'changeTitle':
      return {
        ...state,
        pageTitle: action.title
      };
    default:
      return state;
  }

};

export default AdminPanelLayoutReducer;
