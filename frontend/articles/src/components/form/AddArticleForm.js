import React, { Component } from 'react';
import './Form.css';

class AddArticleForm extends Component {
  state = {
    title: '',
    author: '',
    context: ''
  };

  onChange = event => {
    this.setState({
      ...this.state,
      [event.target.id]: event.target.value
    });
  };

  saveArticle = event => {
    event.preventDefault();
  };

  render() {
    return (
      <div>
        <form onSubmit={this.saveArticle}>
          <label htmlFor="title">Title</label>
          <input type="text" name="title" id="title" onChange={this.onChange} />
          <br />

          <label htmlFor="author">Author</label>
          <input type="text" name="author" id="author" onChange={this.onChange} />
          <br />

          <label htmlFor="context">Context</label>
          <input type="text" name="context" id="context" onChange={this.onChange} />
          <br />

          <button>Submit</button>
        </form>
      </div>
    );
  }
}

export default AddArticleForm;
