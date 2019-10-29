import React from 'react';
import {List} from 'react-virtualized';
import axios from 'axios';

const height = 700;
const rowHeight = 40;
const width = 800;

class App extends React.Component {
  state = {
    key: [],
    data: {}
  };

  componentDidMount() {
    axios.get('http://localhost/articles')
      .then( result => {
        this.setState({
          ...this.state,
          key: Object.keys(result.data),
          data: result.data
        })
      })
  }

  rowRenderer = ({ index, isScrolling, key, style }) => {
    return (
      <div key={key} style={style}>
        <div>{this.state.key[index]}</div>
      </div>
    );
  };

  render() {
    return (
      <div>
        <h2>Details</h2>
        <List
          rowCount={this.state.key.length}
          width={width}
          height={height}
          rowHeight={rowHeight}
          rowRenderer={this.rowRenderer}
          overscanRowCount={3}
        />
      </div>
    );
  }
}

export default App;
