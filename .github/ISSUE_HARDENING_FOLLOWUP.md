# Hardening follow-up: move logs outside web root, rotation, proxy-awareness, rate limiting, and docs

Summary
The initial patch (commit 1fc10e5) stops trusting client-supplied IPs and stores logs under `logs/` with deny rules for Apache. To fully mitigate exposure and improve robustness, we should complete the remaining hardening items below.

Background
- Vulnerability: Public log file exposure of `ips.txt` (PII leakage)
- Advisory: Draft in GitHub Security Advisories
- Current fix: `logip.php` derives IP server-side, logs as JSONL to `logs/ips.ndjson`, POST-only, JSON responses.

Tasks
- [ ] Storage: Move log path outside the web root (e.g., `/var/log/ip-logger/ips.ndjson`) and make it configurable.
- [ ] Server config: Deny access to `/logs` for non-Apache servers (e.g., Nginx/IIS) or remove the directory from the web root entirely.
- [ ] Proxy awareness: If behind a trusted reverse proxy/CDN, extract client IP from `X-Forwarded-For` safely (trusted proxies only).
- [ ] Rotation/retention: Add size/time-based log rotation and define retention (e.g., 30 days); document the policy.
- [ ] Abuse controls: Add basic rate limiting (app-level or web server/WAF) for `logip.php`; optionally check Origin/Referer.
- [ ] Repo hygiene: Remove `ips.txt` from the repository and delete from servers; consider history rewrite (filter-repo/BFG) if it contained real data.
- [ ] Apache deny file: Ensure `logs/.htaccess` is committed and deployed; for Nginx/IIS add equivalents.
- [ ] Documentation: Update README to include privacy notice, retention period, deployment/server config guidance; remove inaccurate SSL claims.
- [ ] Optional: Move inline script to a separate file and add a basic CSP.

Acceptance criteria
- Logs are written to a non-web-accessible path by default, or all servers block access to the log directory.
- A rotation/retention mechanism is in place and documented.
- Proxy environments yield correct client IPs when configured with trusted proxies; otherwise fall back to REMOTE_ADDR.
- Rate limiting reduces spam/noise; endpoint resists trivial log flooding.
- `ips.txt` is no longer present in the repo or deployments; (optional) history scrub complete.
- README updated with privacy/retention policy and deployment instructions.

References
- OWASP Logging Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/Logging_Cheat_Sheet.html
- GDPR Recital 30 (IP addresses as personal data): https://gdpr-info.eu/recitals/no-30/
- GitHub advisories: https://docs.github.com/en/code-security/security-advisories
