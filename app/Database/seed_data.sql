-- Zero Hunger - Seed data
-- Run after migrations. Database: zero_hunger
-- Tables: donations, users, inventory, recipients, distributions
-- 1. Clears all data from app tables  2. Inserts seed data

SET FOREIGN_KEY_CHECKS = 0;

-- Clear all data (child tables first, then parents)
TRUNCATE TABLE `distributions`;
TRUNCATE TABLE `inventory`;
TRUNCATE TABLE `donations`;
TRUNCATE TABLE `recipients`;
TRUNCATE TABLE `users`;

-- ========== USERS ==========
-- Password for admin/driver/viewer is: password (bcrypt hash below)
INSERT INTO `users` (`username`, `email`, `password_hash`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
('admin', 'admin@zerohunger.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', 'active', NULL, NOW(), NOW()),
('driver1', 'driver@zerohunger.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'driver', 'active', NULL, NOW(), NOW()),
('viewer1', 'viewer@zerohunger.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'viewer', 'active', NULL, NOW(), NOW());

-- ========== DONATIONS (was zerohunger) ==========
-- Note: Same person can have multiple rows (one per donation). Donations list shows each donation, not unique donors.
INSERT INTO `donations` (`full_name`, `phone`, `email`, `food_type`, `estimated_quantity`, `preferred_datetime`, `pickup_address`, `notes`, `status`, `assigned_to`, `assigned_driver`, `scheduled_time`, `internal_notes`, `status_history`, `created_at`, `updated_at`) VALUES
('Ahmad bin Hassan', '012-3456789', 'ahmad@email.com', 'Rice, vegetables', '50 kg', '2026-02-10 10:00:00', '123 Jalan Merdeka, Kuala Lumpur', NULL, 'completed', NULL, NULL, '2026-02-01 09:00:00', NULL, NULL, NOW() - INTERVAL 10 DAY, NOW()),
('Siti Nurhaliza', '019-8765432', 'siti@email.com', 'Cooked meals', '100 meals', '2026-02-12 14:00:00', '45 Lorong Aman, Petaling Jaya', 'Halal only', 'scheduled', NULL, NULL, '2026-02-15 11:00:00', NULL, NULL, NOW() - INTERVAL 3 DAY, NOW()),
('Lee Wei Ming', '016-1122334', 'lee@email.com', 'Canned food, dry goods', '30 boxes', '2026-02-08 09:00:00', '78 Taman Desa, Cheras', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NOW() - INTERVAL 1 DAY, NOW()),
('Maria Garcia', '017-5566778', 'maria@email.com', 'Fresh vegetables', '20 kg', '2026-02-14 08:00:00', '22 Jalan Sentosa, Shah Alam', NULL, 'confirmed', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
('Raj Kumar', '018-9988776', 'raj@email.com', 'Bread, pastries', '200 pieces', '2026-02-09 07:00:00', '5 Jalan Masjid, Klang', 'From bakery surplus', 'picked_up', NULL, NULL, '2026-02-09 07:30:00', NULL, NULL, NOW() - INTERVAL 5 DAY, NOW()),
('Ahmad bin Hassan', '012-3456789', 'ahmad@email.com', 'Frozen chicken, eggs', '15 kg', '2026-02-20 11:00:00', '123 Jalan Merdeka, Kuala Lumpur', 'Second donation', 'pending', NULL, NULL, NULL, NULL, NULL, NOW() - INTERVAL 2 DAY, NOW()),
('Tan Mei Ling', '011-2233445', 'meiling@email.com', 'Noodles, cooking oil', '40 kg', '2026-02-16 09:00:00', '12 Jalan Bukit Bintang, KL', NULL, 'scheduled', NULL, NULL, '2026-02-18 10:00:00', NULL, NULL, NOW() - INTERVAL 4 DAY, NOW()),
('Kumar Rajesh', '019-5544332', 'kumar@email.com', 'Fruits, vegetables', '35 kg', '2026-02-22 08:00:00', '67 Jalan Gombak, Setapak', 'Organic produce', 'pending', NULL, NULL, NULL, NULL, NULL, NOW() - INTERVAL 1 DAY, NOW()),
('Nurul Izzati', '017-9988776', 'nurul@email.com', 'Rice, canned sardines', '60 kg', '2026-02-25 14:00:00', '33 Taman Melawati, KL', NULL, 'confirmed', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
('David Tan', '016-7788990', 'david@email.com', 'Bread, biscuits', '80 packets', '2026-02-28 07:00:00', '9 Jalan Imbi, Kuala Lumpur', 'Near expiry clearance', 'pending', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
('Salmah binti Omar', '013-4455667', 'salmah@email.com', 'Cooked rice, curry', '50 meals', '2026-03-01 12:00:00', '21 Lorong Haji Taib, Ampang', 'Halal', 'pending', NULL, NULL, NULL, NULL, NULL, NOW(), NOW());

-- ========== RECIPIENTS ==========
INSERT INTO `recipients` (`name`, `type`, `phone`, `email`, `notes`, `address`, `service_area`, `status`, `created_at`, `updated_at`) VALUES
('Rumah Kebajikan Sri Cahaya', 'organization', '03-87365210', 'contact@sriecahaya.org', NULL, '100 Jalan Bantuan, Kuala Lumpur', 'Kuala Lumpur', 'active', NOW() - INTERVAL 30 DAY, NOW()),
('Puan Fatimah', 'individual', '012-3344556', 'puan.fatimah@example.com', NULL, 'Block C-12, PPR Sri Pantai', 'Kuala Lumpur', 'active', NOW() - INTERVAL 20 DAY, NOW()),
('Community Kitchen PJ', 'organization', '03-79561234', 'hello@ckpj.org', 'Community kitchen partner', '88 Jalan SS2, Petaling Jaya', 'Petaling Jaya', 'active', NOW() - INTERVAL 15 DAY, NOW()),
('Encik Ibrahim', 'individual', '019-7788990', 'ibrahim@example.com', NULL, 'Lorong 5, Taman Merdeka', 'Shah Alam', 'active', NOW() - INTERVAL 10 DAY, NOW()),
('Food Bank Selangor', 'organization', '03-55443210', 'info@foodbankselangor.org', NULL, '200 Persiaran Raja Muda, Shah Alam', 'Selangor', 'active', NOW() - INTERVAL 25 DAY, NOW()),
('Surau Al-Ikhlas Community', 'organization', '03-89234567', 'committee@alikhlas.org', NULL, '45 Jalan Masjid India, KL', 'Kuala Lumpur', 'active', NOW() - INTERVAL 14 DAY, NOW()),
('Mdm Lim', 'individual', '018-6677889', 'mdm.lim@example.com', NULL, 'Block D-8, PPR Kerinchi', 'Kuala Lumpur', 'active', NOW() - INTERVAL 7 DAY, NOW()),
('Baitul Ehsan Shelter', 'organization', '03-76543210', 'contact@baitulehsan.org', 'Shelter home partner', '120 Jalan Pudu, Kuala Lumpur', 'Kuala Lumpur', 'active', NOW() - INTERVAL 21 DAY, NOW());

-- ========== INVENTORY ==========
INSERT INTO `inventory` (`donation_id`, `food_type`, `quantity`, `unit`, `expiration_date`, `storage_location`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Rice', 25, 'kg', '2026-03-15', 'Warehouse A, Shelf 1', 'available', NOW() - INTERVAL 8 DAY, NOW()),
(1, 'Vegetables', 25, 'kg', '2026-02-20', 'Cold Room 1', 'available', NOW() - INTERVAL 8 DAY, NOW()),
(5, 'Bread', 100, 'pieces', '2026-02-10', 'Room temp area', 'available', NOW() - INTERVAL 4 DAY, NOW()),
(5, 'Pastries', 100, 'pieces', '2026-02-12', 'Room temp area', 'available', NOW() - INTERVAL 4 DAY, NOW()),
(NULL, 'Canned beans', 50, 'cans', '2026-06-01', 'Warehouse B', 'available', NOW() - INTERVAL 2 DAY, NOW()),
(2, 'Cooked meals', 50, 'meals', '2026-02-16', 'Freezer 2', 'reserved', NOW(), NOW()),
(4, 'Fresh vegetables', 20, 'kg', '2026-02-18', 'Cold Room 1', 'available', NOW(), NOW()),
(NULL, 'Rice', 80, 'kg', '2026-04-01', 'Warehouse A, Shelf 2', 'available', NOW() - INTERVAL 5 DAY, NOW()),
(NULL, 'Canned fish', 120, 'cans', '2026-05-15', 'Warehouse B', 'available', NOW() - INTERVAL 3 DAY, NOW()),
(7, 'Noodles', 20, 'kg', '2026-03-20', 'Warehouse A', 'available', NOW(), NOW()),
(7, 'Cooking oil', 15, 'litres', '2026-04-10', 'Warehouse A', 'available', NOW(), NOW());

-- ========== DISTRIBUTIONS (recipient_id refers to recipients.id) ==========
-- items column: JSON array of {food_type, quantity, unit}
INSERT INTO `distributions` (`recipient_id`, `items`, `date`, `delivery_method`, `notes`, `created_at`, `updated_at`) VALUES
(1, '[{"food_type":"Rice","quantity":10,"unit":"kg"},{"food_type":"Vegetables","quantity":5,"unit":"kg"}]', '2026-02-01', 'Pickup', 'Weekly allocation', NOW() - INTERVAL 6 DAY, NOW()),
(2, '[{"food_type":"Bread","quantity":20,"unit":"pieces"}]', '2026-02-05', 'Delivery', NULL, NOW() - INTERVAL 2 DAY, NOW()),
(3, '[{"food_type":"Cooked meals","quantity":30,"unit":"meals"}]', '2026-02-06', 'Pickup', 'Lunch service', NOW() - INTERVAL 1 DAY, NOW()),
(4, '[{"food_type":"Rice","quantity":15,"unit":"kg"},{"food_type":"Canned beans","quantity":10,"unit":"cans"}]', '2026-02-04', 'Pickup', NULL, NOW() - INTERVAL 3 DAY, NOW()),
(5, '[{"food_type":"Canned fish","quantity":25,"unit":"cans"},{"food_type":"Rice","quantity":20,"unit":"kg"}]', '2026-02-07', 'Delivery', 'Monthly bulk', NOW(), NOW()),
(6, '[{"food_type":"Bread","quantity":30,"unit":"pieces"},{"food_type":"Cooked meals","quantity":15,"unit":"meals"}]', '2026-02-03', 'Pickup', 'Friday distribution', NOW() - INTERVAL 4 DAY, NOW()),
(7, '[{"food_type":"Rice","quantity":5,"unit":"kg"}]', '2026-02-06', 'Delivery', NULL, NOW() - INTERVAL 1 DAY, NOW()),
(8, '[{"food_type":"Vegetables","quantity":8,"unit":"kg"},{"food_type":"Canned beans","quantity":12,"unit":"cans"}]', '2026-02-05', 'Pickup', 'Shelter kitchen', NOW() - INTERVAL 2 DAY, NOW());

SET FOREIGN_KEY_CHECKS = 1;

-- Note: Login with username "admin" and password "password" (same for driver1, viewer1).
