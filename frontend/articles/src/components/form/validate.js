export const validate = values => {
  const errors = {};

  if (!values.title) {
    errors.title = 'Required'
  } else if (values.title.length < 2) {
    errors.title = 'Minimum be 2 characters or more'
  }

  if (!values.email) {
    errors.email = 'Required'
  } else if (!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(values.email)) {
    errors.email = 'Invalid email address'
  }

  if (!values.author) {
    errors.author = 'Required'
  } else if (values.author.length < 2) {
    errors.author = 'Minimum be 2 characters or more'
  }

  if (!values.content) {
    errors.content = 'Required'
  } else if (values.content.length < 10) {
    errors.content = 'Minimum be 10 characters or more'
  }

  return errors
};
