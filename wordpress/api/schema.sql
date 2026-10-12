-- NoAway API - Schema MySQL (stesso DB di WordPress)
-- Esegui una volta su MySQL (phpMyAdmin o wp-cli / docker).

-- Licenze
CREATE TABLE IF NOT EXISTS noaway_licenses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  license_key VARCHAR(50) NOT NULL UNIQUE,
  max_devices INT NOT NULL DEFAULT 2,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_validation DATETIME NULL,
  last_device VARCHAR(128) NULL,
  last_version VARCHAR(20) NULL,
  last_platform VARCHAR(20) NULL,
  last_activity_mode VARCHAR(20) NULL,
  last_detected_apps TEXT NULL,
  last_active_seconds INT DEFAULT 0,
  total_active_seconds INT DEFAULT 0,
  INDEX idx_license_key (license_key),
  INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Attivazioni (licenza + device_id)
CREATE TABLE IF NOT EXISTS noaway_activations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  license_key VARCHAR(50) NOT NULL,
  device_id VARCHAR(128) NOT NULL,
  activated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uk_license_device (license_key, device_id),
  INDEX idx_license_key (license_key),
  INDEX idx_device_id (device_id),
  FOREIGN KEY (license_key) REFERENCES noaway_licenses(license_key) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Rate limiting per IP ed endpoint
CREATE TABLE IF NOT EXISTS noaway_rate_limit (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ip_address VARCHAR(45) NOT NULL,
  endpoint VARCHAR(64) NOT NULL,
  request_count INT NOT NULL DEFAULT 1,
  window_start DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ip_endpoint (ip_address, endpoint),
  INDEX idx_window (window_start)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
