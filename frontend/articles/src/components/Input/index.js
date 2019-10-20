import React, { Fragment } from 'react';
import './Input.css';

const Input = ({ input, label, type, meta: { touched, error, warning } }) => {
  return (
    <Fragment>
      <label className="ControlLabel">{label}</label>
      <div>
        <input {...input} placeholder={label} type={type} className="FormControl" />
        {touched && ((error && <span className="TextDanger">{error}</span>) || (warning &&
          <span>{warning}</span>))}
      </div>
    </Fragment>
  );
};

export default Input;
