import React, { Component, Fragment } from 'react';
import { connect } from 'react-redux';

import { ArticleActions } from '../../../../actions';
import './ArticleList.css';
import withTitle from '../../../shared/withTitle';
import FloatingButton from '../../../shared/FloatingButton';
import TableListItem from './TableListItem';

class ArticleList extends Component {
  componentDidMount() {
    this.props.getArticles();
  }

  render() {
    const { articles } = this.props;
    const articleIds = Object.keys(articles);

    return this.props.loading ?
      (<div>loading</div>) :
      (<Fragment>
        <h3 className="ArticleListTitle">Article List</h3>
        <ul className="ArticleList">
          {
            articleIds.length ?
              articleIds.map(identifier => (<TableListItem key={identifier} item={articles[identifier]} />)) :
              (<div>List is empty</div>)
          }
        </ul>
        <FloatingButton enter />
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
