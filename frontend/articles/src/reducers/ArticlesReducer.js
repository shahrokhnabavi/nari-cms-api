import { ArticleActions } from '../actions';

const initialState = {
  articles: [],
  loading: false
};

const ArticlesReducer = (state = initialState, action) => {
  switch (action.type) {
    case ArticleActions.REQUEST_ARTICLES_LIST:
      return {
        ...state,
        loading: true
      };
    case ArticleActions.RECEIVED_ARTICLES_LIST:
      return {
        ...state,
        articles: action.articles,
        loading: false,
      };
    default:
      return state;
  }
};

export default ArticlesReducer;
