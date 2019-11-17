import React, { Component } from 'react';
import { connect } from 'react-redux';
import { List, AutoSizer } from 'react-virtualized';
import { Paper } from '@material-ui/core';

import { ArticleActions } from '../../../../actions';
import './ArticleList.css';
import withTitle from '../../../shared/withTitle';
import FloatingButton from '../../../shared/FloatingButton';
import TableListItem from './TableListItem';
import Loading from '../../../shared/Loading';

const renderVirtualizedList = ( height, width, items) => {
  const itemIds = Object.keys(items);

  return (
    <List
      tabIndex={null}
      rowCount={itemIds.length}
      width={width}
      height={height}
      rowHeight={47}
      rowRenderer={
        ({ index, key, style }) => (<TableListItem item={items[itemIds[index]]} key={key} style={style} />)
      }
      noRowsRenderer={() => (<div>List is empty</div>)}
      overscanRowCount={20}
    />
  );
};

class ArticleList extends Component {
  componentDidMount() {
    this.props.getArticles();
  }

  render() {
    const { articles } = this.props;

    return this.props.loading ?
      <Loading size="30" thickness="5" /> :
      (<Paper className="ArticleListPager">
        <h3 className="ArticleListTitle">Article List</h3>
        <ul className="ArticleList">
          <AutoSizer>
            {({ height, width }) => (renderVirtualizedList(height, width, articles))}
          </AutoSizer>
        </ul>
        <FloatingButton enter />
      </Paper>);
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
