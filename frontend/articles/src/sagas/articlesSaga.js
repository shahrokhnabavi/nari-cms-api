import { put, takeLatest } from 'redux-saga/effects';
import { ArticleActions } from '../actions';
import axios from "axios";

const getArticles = async () => {
  const response = await axios.get('https://jsonplaceholder.typicode.com/posts');

  if (response.status === 200) {
    return response.data;
  }

  throw new Error('Can not fetch data.');
};

const articleReceived = function* () {
  try {
    const articles = yield getArticles();

    yield put({type: ArticleActions.RECEIVED_ARTICLES_LIST, articles: articles || []});
  } catch (e) {
    console.log(e);
  }
};

function* getArticlesActionWatcher() {
  yield takeLatest(ArticleActions.REQUEST_ARTICLES_LIST, articleReceived);
}

export default {
  getArticlesActionWatcher
};
