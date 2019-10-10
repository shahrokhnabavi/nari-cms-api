CREATE TABLE article
(
    article_id BIGINT AUTO_INCREMENT,
    title      VARCHAR(255) NOT NULL,
    text       TEXT,
    author     VARCHAR(64)  NOT NULL,
    PRIMARY KEY (article_id)
);
