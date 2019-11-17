import axios from "axios";

export const addArticle = async (data) => {
  const response = await axios.get('http://localhost/articles');

  if (response.status === 200) {
    console.log('should return article id.', data);
    return response.data;
  }

  throw new Error('Can not fetch data.');
};

export const getArticles = async () => {
  const response = await axios.get('http://localhost/articles');

  if (response.status === 200) {
    return response.data;
  }

  throw new Error('Can not fetch data.');
};
