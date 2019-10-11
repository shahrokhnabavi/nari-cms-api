CREATE TABLE tags
(
    tag_id varchar(36) NOT NULL,
    name   VARCHAR(25) NOT NULL,
    PRIMARY KEY (tag_id)
);

CREATE UNIQUE INDEX idx_u_tag_name ON tags (name);

INSERT INTO tags (tag_id, name)
VALUES ('4f5bc1d2-ec5c-11e9-81b4-2a2ae2dbcce4', 'php'),
       ('a42c05c8-ec5c-11e9-81b4-2a2ae2dbcce4', 'javascript');
