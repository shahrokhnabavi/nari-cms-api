import { reducer as FormReducer } from 'redux-form';
import AgeCounterReducer from './AgeCounterReducer';
import ArticlesReducer from './ArticlesReducer';

export default {
  AgeCounterReducer,
  ArticlesReducer,
  form: FormReducer
};


