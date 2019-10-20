import { put, takeLatest, takeEvery } from 'redux-saga/effects';
import { reset, startSubmit, stopSubmit } from "redux-form";
import { ArticleActions } from '../actions';
import { addArticle, getArticles } from '../api/articles';

const articleReceived = function* () {
  try {
    const articles = yield getArticles();

    yield put({ type: ArticleActions.RECEIVED_ARTICLES_LIST, articles: articles || [] });
  } catch (error) {
    console.error(error); // eslint-disable-line no-console
    yield put({ type: ArticleActions.FAILED_ARTICLE_LIST, error: error.message });
  }
};

const articleAdded = function* (action) {
  yield put(startSubmit('addArticleForm'));

  try {
    const articleId = yield addArticle(action.data);

    yield put({ type: ArticleActions.RECEIVED_ARTICLE_ADD, id: articleId });

    yield put(stopSubmit('addArticleForm'));
    yield put(reset('addArticleForm'));
  } catch (error) {
    console.error(error); // eslint-disable-line no-console
    yield put({ type: ArticleActions.FAILED_ARTICLE_ADD, error: error.message });

    yield put(stopSubmit('addArticleForm', { _error: error.message }));
  }
};

export default () => [
  takeLatest(ArticleActions.REQUEST_ARTICLES_LIST, articleReceived),
  takeEvery(ArticleActions.REQUEST_ARTICLE_ADD, articleAdded)
];
