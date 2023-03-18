CREATE DATABASE IF NOT EXISTS module_4_project;

USE module_4_project;

CREATE TABLE IF NOT EXISTS posts (
    post_id VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    content TEXT,
    thumbnail VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    posted_at DATETIME,
    PRIMARY KEY (post_id)
);

CREATE TABLE IF NOT EXISTS categories (
    category_id VARCHAR(100) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    PRIMARY KEY (category_id)
);

CREATE TABLE IF NOT EXISTS posts_categories (
    post_id VARCHAR(100) NOT NULL,
    category_id VARCHAR(100) NOT NULL,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);


