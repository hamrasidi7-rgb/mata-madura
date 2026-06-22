-- Table: ai_features
DROP TABLE IF EXISTS `ai_features`;
CREATE TABLE IF NOT EXISTS "ai_features" ("id" integer primary key autoincrement not null, "title" varchar not null, "description" varchar not null, "icon" varchar not null default 'sparkles', "route_or_url" varchar, "sort_order" integer not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);

-- Table: articles
DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS "articles" ("id" integer primary key autoincrement not null, "category_id" integer not null, "title" varchar not null, "slug" varchar not null, "deck" text, "body" text, "image_path" varchar, "image_caption" varchar, "author" varchar, "read_minutes" integer not null default '3', "is_trending" tinyint(1) not null default '0', "is_featured" tinyint(1) not null default '0', "published_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("category_id") references "categories"("id") on delete cascade);

-- Table: budget_items
DROP TABLE IF EXISTS `budget_items`;
CREATE TABLE IF NOT EXISTS "budget_items" ("id" integer primary key autoincrement not null, "label" varchar not null, "icon" varchar not null default 'wallet', "amount" integer not null default '0', "sort_order" integer not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);

-- Table: cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));

-- Table: cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));

-- Table: categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS "categories" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "sort_order" integer not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);

-- Table: failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" varchar not null, "queue" varchar not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);

-- Table: job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));

-- Table: jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);

-- Table: migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2026_01_01_000001_create_categories_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2026_01_01_000002_create_articles_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2026_01_01_000003_create_ai_features_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2026_01_01_000004_create_budget_items_table', 2);

-- Table: password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));

-- Table: sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('OkiMqOnF6HhKxzdLh2pFUBwx0R3eY93smMMudJ0Y', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0', 'eyJfdG9rZW4iOiJYeWVBQm1YREhsTWdjQ1RNcmJrZDNtYllGVlV1T1g1bTZuOWhManZnIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781810428);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('SufYoZhwhD0fc7XV0Liz35ACAgkjfvxlHBuQI7LY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0', 'eyJfdG9rZW4iOiJPUUZ0cEFMMWl5TVFYRHhLSVhKaTI2SndlUXdGcUIwSDYxSnFobmx4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781810488);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('4NHyxh4pijk4bbSZEV6NSCPbDXq35Olye0BWnG60', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0', 'eyJfdG9rZW4iOiJLR2hmZ0hJSVVBdkRUZVd3QUwzSVpUUDFzOE1BdTBsRVMyMndPVUtRIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781817988);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('RRsyd9Pl8WvOdlhCLzisWahmzBJL7uzz9xRYN3NY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.122.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'eyJfdG9rZW4iOiJwWmVJYmJBRFpGcFdoeHFBaEZVWHlqWGN2aTNCampFTFJKRDVBeTM0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1781869782);

-- Table: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime);

