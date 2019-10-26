import { reducer as FormReducer } from 'redux-form';
import ArticlesReducer from './ArticlesReducer';
import AdminPanelLayoutReducer from './AdminPanelLayoutReducer';

export default {
  ArticlesReducer,
  AdminPanelLayoutReducer,
  form: FormReducer
};


