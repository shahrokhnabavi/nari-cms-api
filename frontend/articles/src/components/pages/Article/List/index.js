import React, { Component, Fragment } from 'react';
import { connect } from 'react-redux';

import { ArticleActions } from '../../../../actions';
import './ArticleList.css';
import withTitle from '../../../shared/withTitle';

class ArticleList extends Component {
  componentDidMount() {
    this.props.getArticles();
  }

  render() {
    const articles = Object.keys(this.props.articles);
    return this.props.loading ?
      (<div>loading</div>) :
      (<Fragment>
        <h3 className="ArticleListTitle">Article List</h3>
        <ul className="ArticleList">
          {
            articles.length ?
              articles.map(identifier => (<li key={identifier}>{this.props.articles[identifier].title}</li>)) :
              (<div>List is empty</div>)
          }
        </ul>
      </Fragment>);
  }
}

const mapStoreToProps = state => ({
  articles: state.ArticlesReducer.articles,
  loading: state.ArticlesReducer.loading
});

const mapDispatchToProps = {
  getArticles: ArticleActions.getArticles
};

export default connect(mapStoreToProps, mapDispatchToProps)(
  withTitle(ArticleList, 'Articles')
);
