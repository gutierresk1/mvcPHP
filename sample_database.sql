-- -----------------------------
-- SQL SAMPLE DATABASE----------
-- -----------------------------

-- Table Structure

CREATE TABLE posts(
    
    id int(11) NOT NULL AUTO_INCREMENT, 
    title varchar(128) NOT NULL, 
    content text NOT NULL, 
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY(id), 
    KEY created_at (created_at)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;
 

-- Sample Data

INSERT INTO posts (title, content) VALUES
('First Post', 'This is a really interesting post'),
('Second Post', 'This is a fascinating post!'),
('Third Post', 'This a very informative post!');