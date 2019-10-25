import { reducer as FormReducer } from 'redux-form';
import AgeCounterReducer from './AgeCounterReducer';
import ArticlesReducer from './ArticlesReducer';
import AdminPanelLayoutReducer from './AdminPanelLayoutReducer';

export default {
  AgeCounterReducer,
  ArticlesReducer,
  AdminPanelLayoutReducer,
  form: FormReducer
};


