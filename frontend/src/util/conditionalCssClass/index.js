export default (...classes) => {
  const cls = classes.filter(item => {
    if (Array.isArray(item)) {
      if (item.length !== 2) {
        return false;
      }

      return item[0] === true
    }

    return true;
  }).map(item => {
    if (Array.isArray(item)) {
      return item[1];
    }

    return item;
  });

  return cls.join(' ');
}
