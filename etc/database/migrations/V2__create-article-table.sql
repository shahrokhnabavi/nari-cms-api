CREATE TABLE articles
(
    article_id VARCHAR(36)  NOT NULL,
    title      VARCHAR(255) NOT NULL,
    text       TEXT,
    author     VARCHAR(64)  NOT NULL,
    PRIMARY KEY (article_id)
);

CREATE UNIQUE INDEX idx_u_article_title ON articles (title);

INSERT INTO articles (article_id, title, text, author)
VALUES ('fa98354e-ec5c-11e9-81b4-2a2ae2dbcce4', 'My First Blog', 'In this post we are going to explain how to win.',
        'Sha');

CREATE TABLE articles_tags
(
    article_id VARCHAR(36) NOT NULL,
    tag_id     VARCHAR(36) NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    CONSTRAINT fk_article_article_tag FOREIGN KEY (article_id) REFERENCES articles (article_id) ON DELETE CASCADE,
    CONSTRAINT fk_tag_article_tag FOREIGN KEY (tag_id) REFERENCES tags (tag_id) ON DELETE CASCADE
);

INSERT INTO articles_tags
VALUES ('fa98354e-ec5c-11e9-81b4-2a2ae2dbcce4', 'a42c05c8-ec5c-11e9-81b4-2a2ae2dbcce4'),
       ('fa98354e-ec5c-11e9-81b4-2a2ae2dbcce4', '4f5bc1d2-ec5c-11e9-81b4-2a2ae2dbcce4');
