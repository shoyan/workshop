-- schema.sql

-- 短縮URL情報を格納するテーブル
CREATE TABLE IF NOT EXISTS short_urls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_url TEXT NOT NULL,
    short_code VARCHAR(10) NOT NULL UNIQUE,
    password_hash VARCHAR(255) DEFAULT NULL,
    expires_at DATETIME DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- アクセスログを格納するテーブル
CREATE TABLE IF NOT EXISTS access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    short_code VARCHAR(10) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    accessed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (short_code) REFERENCES short_urls(short_code) ON DELETE CASCADE
);
