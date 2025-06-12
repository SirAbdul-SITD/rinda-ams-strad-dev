-- Rename price column to amount in penalty_types table
ALTER TABLE penalty_types CHANGE price amount DECIMAL(10,2);

-- Add penalty_type_id column to penalties table if not exists
ALTER TABLE penalties ADD COLUMN IF NOT EXISTS penalty_type_id INT AFTER staff_id;

-- Add amount column to penalties table if not exists
ALTER TABLE penalties ADD COLUMN IF NOT EXISTS amount DECIMAL(10,2) AFTER penalty_type_id;

-- Add foreign key constraint if not exists
ALTER TABLE penalties ADD CONSTRAINT IF NOT EXISTS fk_penalty_type 
FOREIGN KEY (penalty_type_id) REFERENCES penalty_types(id);

-- Update existing penalties to use the first penalty type (if any exist)
UPDATE penalties p 
JOIN penalty_types pt ON pt.id = 1 
SET p.penalty_type_id = pt.id,
    p.amount = pt.amount
WHERE p.penalty_type_id IS NULL; 