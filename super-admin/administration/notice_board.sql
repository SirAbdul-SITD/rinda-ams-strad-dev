-- Add notice board columns to academic_calendar table
ALTER TABLE academic_calendar
ADD COLUMN is_notice TINYINT(1) DEFAULT 0,
ADD COLUMN notice_readers VARCHAR(255) DEFAULT NULL;

-- Create notice_board table
CREATE TABLE IF NOT EXISTS notice_board (
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE,
    readers VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES academic_calendar(id) ON DELETE CASCADE
);

-- Create trigger to sync notices to notice_board table
DELIMITER //
CREATE TRIGGER after_event_insert
AFTER INSERT ON academic_calendar
FOR EACH ROW
BEGIN
    IF NEW.is_notice = 1 THEN
        INSERT INTO notice_board (event_id, title, description, start_date, end_date, readers)
        VALUES (NEW.id, NEW.title, NEW.description, NEW.start_date, NEW.end_date, NEW.notice_readers);
    END IF;
END//

CREATE TRIGGER after_event_update
AFTER UPDATE ON academic_calendar
FOR EACH ROW
BEGIN
    IF NEW.is_notice = 1 THEN
        IF EXISTS (SELECT 1 FROM notice_board WHERE event_id = NEW.id) THEN
            UPDATE notice_board 
            SET title = NEW.title,
                description = NEW.description,
                start_date = NEW.start_date,
                end_date = NEW.end_date,
                readers = NEW.notice_readers
            WHERE event_id = NEW.id;
        ELSE
            INSERT INTO notice_board (event_id, title, description, start_date, end_date, readers)
            VALUES (NEW.id, NEW.title, NEW.description, NEW.start_date, NEW.end_date, NEW.notice_readers);
        END IF;
    ELSE
        DELETE FROM notice_board WHERE event_id = NEW.id;
    END IF;
END//

CREATE TRIGGER after_event_delete
AFTER DELETE ON academic_calendar
FOR EACH ROW
BEGIN
    DELETE FROM notice_board WHERE event_id = OLD.id;
END//
DELIMITER ; 