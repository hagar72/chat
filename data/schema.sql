CREATE TABLE message (
    id INTEGER PRIMARY KEY , 
    message text NOT NULL,
    created timestamp NULL DEFAULT CURRENT_TIMESTAMP    
);
INSERT INTO message (message) VALUES ('First Message');