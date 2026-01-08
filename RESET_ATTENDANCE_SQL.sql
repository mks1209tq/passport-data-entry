-- Quick SQL to reset all attendance to pending
-- Run this in phpMyAdmin or your database tool

UPDATE run_registrations SET attendance_status = 'pending';

-- Verify it worked (should return 0)
SELECT COUNT(*) as present_count 
FROM run_registrations 
WHERE attendance_status = 'present';

