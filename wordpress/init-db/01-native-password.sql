-- Compatibilità con wp-cli (client MariaDB nel container non supporta caching_sha2_password)
-- Forza l'utente WordPress a usare mysql_native_password
ALTER USER 'wordpress'@'%' IDENTIFIED WITH mysql_native_password BY 'wordpress';
FLUSH PRIVILEGES;
