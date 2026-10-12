# NoAway — protected downloads (`api/`)

Deploy **`download.php`** to your WordPress site root under **`api/`**, next to this `.htaccess`:

- **URL:** `https://noaway.app/api/download.php?t=…&p=…&e=…&id=…`
- **License server** (`license-server/email.js`) builds these URLs; the secret must match **`NOAWAY_DOWNLOAD_SECRET`** in `wp-config.php` and **`DOWNLOAD_SECRET`** in the license server `.env`.

## Files

Place **both** macOS DMGs and the Windows installer in the directory set as **`NOAWAY_RELEASES_PATH`** in `wp-config.php` (e.g. `~/noaway-releases` on the server), using the **exact filenames** from the constants.

## Platforms (`p` parameter)

| `p`             | Constant / behaviour                                      |
|-----------------|-----------------------------------------------------------|
| `mac`           | Legacy; same file as universal                          |
| `mac_universal` | `NOAWAY_RELEASE_MACOS` or `NOAWAY_RELEASE_MACOS_UNIVERSAL` |
| `mac_arm64`     | `NOAWAY_RELEASE_MACOS_ARM64` (falls back to universal if unset) |
| `win`           | `NOAWAY_RELEASE_WINDOWS`                                |

## Nginx

If you use Nginx instead of Apache, add a rule so `/api/download` (without `.php`) still hits `download.php`, for older emailed links:

```nginx
location = /api/download {
    rewrite ^ /api/download.php last;
}
```
