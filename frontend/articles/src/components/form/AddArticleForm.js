import React  from 'react';
import { reduxForm, Field } from 'redux-form';
import { connect } from 'react-redux';

import './Form.css';
import { validate } from './validate';
import { ArticleActions } from '../../actions';
import Input  from '../Input';

const AddArticleForm = props => {
  const { error, handleSubmit, pristine, submitting, invalid } = props;

  return (<form onSubmit={handleSubmit(props.addArticle)}>
    <div className="FormGroup">
      <Field name="title" label="Title" type="text" component={Input} />
    </div>
    <div className="FormGroup">
      <Field name="author" label="Author" type="text" component={Input} />
    </div>
    <div className="FormGroup">
      <Field name="content" label="Content" type="text" component={Input} />
    </div>
    <div className="FormGroup">
      <Field name="email" label="Email" type="text" component={Input} />
    </div>
    <div className="FormGroup">
      <button className="BtnPrimary" disabled={invalid} type="submit">Save</button>
      <button className="BtnPrimary" disabled={pristine || submitting} type="reset">reset</button>
    </div>
    <div>{error && <strong>{error}</strong>}</div>
  </form>);
};

const Form = reduxForm({
  form: 'addArticleForm',
  validate
})(AddArticleForm);

const mapDispatchToProps = {
  addArticle: ArticleActions.addArticle
};

export default connect(null, mapDispatchToProps)(Form);
