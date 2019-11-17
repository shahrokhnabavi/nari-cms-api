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
    case ArticleActions.FAILED_ARTICLE_LIST:
      return {
        ...state,
        loading: false,
      };
    case ArticleActions.REQUEST_ARTICLE_ADD:
      return {
        ...state,
      };
    case ArticleActions.RECEIVED_ARTICLE_ADD:
      return {
        ...state,
        articleId: action.articleId
      };
    case ArticleActions.FAILED_ARTICLE_ADD:
      return {
        ...state,
        error: action.error
      };
    default:
      return state;
  }
};

export default ArticlesReducer;
