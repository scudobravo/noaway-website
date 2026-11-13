#!/usr/bin/env node
/**
 * Mint a signed /invoice-details/ link (same crypto as license-server/billingFormToken.js).
 *
 * Usage:
 *   BILLING_FORM_SECRET='your-secret' node bin/mint-billing-link.js [email] [name] [licenseKey]
 */
const crypto = require('crypto');

const email = process.argv[2] || 'preview@noaway.app';
const name = process.argv[3] || 'Alex Preview';
const licenseKey = process.argv[4] || 'PREVIEW-LICENSE';
const base = process.env.BILLING_FORM_URL || 'https://noaway.app/invoice-details';
const secret = process.env.BILLING_FORM_SECRET || '';

if (!secret) {
  console.error('Set BILLING_FORM_SECRET in the environment first.');
  process.exit(1);
}

const payload = JSON.stringify({
  license_key: licenseKey,
  email,
  name: name || null,
  iat: Date.now(),
});
const key = crypto.createHash('sha256').update(String(secret), 'utf8').digest();
const iv = crypto.randomBytes(12);
const cipher = crypto.createCipheriv('aes-256-gcm', key, iv);
const ciphertext = Buffer.concat([cipher.update(Buffer.from(payload, 'utf8')), cipher.final()]);
const tag = cipher.getAuthTag();
const token = Buffer.concat([iv, tag, ciphertext]).toString('base64url');
const url = `${base}?key=${encodeURIComponent(licenseKey)}&d=${encodeURIComponent(token)}`;
console.log(url);
