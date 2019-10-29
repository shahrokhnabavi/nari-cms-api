import React, { Component, Fragment } from 'react';
import { connect } from 'react-redux';
import { List, AutoSizer } from 'react-virtualized';

import { ArticleActions } from '../../../../actions';
import './ArticleList.css';
import withTitle from '../../../shared/withTitle';
import FloatingButton from '../../../shared/FloatingButton';
import TableListItem from './TableListItem';
import Loading from '../../../shared/Loading';
import { ListItem } from '@material-ui/core';

class ArticleList extends Component {
  componentDidMount() {
    this.props.getArticles();
  }

  rowRenderer = ({ index, isScrolling, key, style }) => {
    const { articles } = this.props;
    const articleIds = Object.keys(articles);

    return (
      <ListItem style={style} role={undefined} button onClick={() => ({})} key={key}>
        <TableListItem item={articles[articleIds[index]]} />
      </ListItem>
    );
  };

  render() {
    const { articles } = this.props;
    const articleIds = Object.keys(articles);

    return this.props.loading ?
      <Loading size="30" thickness="5" /> :
      (<Fragment>
        <h3 className="ArticleListTitle">Article List</h3>
        <ul className="ArticleList">

          {
            articleIds.length ?
              (<AutoSizer>
                {({ height, width }) => (
                  <List
                    rowCount={articleIds.length}
                    width={width}
                    height={height}
                    rowHeight={58}
                    rowRenderer={this.rowRenderer}
                    overscanRowCount={3}
                  />
                )}
              </AutoSizer>) :
              (<div>List is empty</div>)
          }
        </ul>
        <FloatingButton enter />
      </Fragment>);
  }
}

const mapStoreToProps = state => ({
  articles: state.ArticlesReducer.articles,
  loading: state.ArticlesReducer.loading,
});

const mapDispatchToProps = {
  getArticles: ArticleActions.getArticles,
};

export default connect(mapStoreToProps, mapDispatchToProps)(
  withTitle(ArticleList, 'Articles'),
);
