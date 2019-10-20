import React, { Component, Fragment } from 'react';
import { connect } from 'react-redux';
import { ArticleActions } from '../../actions';
import './ArticleList.css';

class ArticleList extends Component {
  componentDidMount() {
    this.props.getArticles();
  }

  render() {
    return this.props.loading ?
      (<div>loading</div>) :
      (<Fragment>
        <h3 className="ArticleListTitle">Article List</h3>
        <ul className="ArticleList">
          {
            this.props.articles.length ?
              this.props.articles.map(article => (<li key={article.id}>{article.title}</li>)) :
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

export default connect(mapStoreToProps, mapDispatchToProps)(ArticleList);
