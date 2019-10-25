import { AdminPanelLayoutActions } from '../actions';

const initialState = {
  isMenuOpen: false
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
    default:
      return state;
  }

};

export default AdminPanelLayoutReducer;
